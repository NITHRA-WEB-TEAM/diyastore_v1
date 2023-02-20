<script setup>
import ProductCard from '@/views/diya/diya/card.vue'
import bannerImage from '@images/banner/banner1.png'

// const isAlertVisible = ref(true)


</script>

<template>

  <!--  <div class="alert-demo-v-model-wrapper text-center" style="margin-left: 1200px">-->
  <!--    <VAlert-->
  <!--      v-model="isAlertVisible"-->
  <!--      color="warning"-->
  <!--      variant="tonal"-->
  <!--    >-->
  <!--      Added to Cart-->
  <!--    </VAlert>-->
  <!--  </div>-->

  <!-- button -->
  <!--  <VBtn @click="isAlertVisible = !isAlertVisible">-->
  <!--    {{ isAlertVisible ? "Hide Alert" : "Show Alert" }}-->
  <!--  </VBtn>-->

  <VRow class="set_height">
    <VCol cols="12"
          md="12"
          sm="12"
          lg="12"
    >

      <!--      <VCard>-->
      <v-carousel style="height: 350px">
        <v-carousel-item
          v-for="(item,index) in slider"
          :key="index"
          :src="item.image_url"
          type="button"
          @click="goToSliderView(item.link)"
          reverse-transition="fade-transition"
          transition="fade-transition"
        ></v-carousel-item>
      </v-carousel>
      <!--        <img :src="bannerImage" style="width: -webkit-fill-available;" alt="">-->
      <!--      </VCard>-->

    </VCol>

  </VRow>
  <br>
  <h2>Most Viewed Products</h2>
  <br>
  <VRow>
    <VCol v-for="(product,index) in mostViewedList" :key="index"
          cols="12"
          md="4"
          sm="6"
          lg="3"
    >
      <ProductCard
        :product="product"
        :index="index"
      />
    </VCol>

  </VRow>
  <br>
  <h2>Newly Added Products</h2><br>
  <VRow>
    <VCol v-for="(product,index) in ProductsList" :key="index"
          cols="12"
          md="4"
          sm="6"
          lg="3"
    >
      <ProductCard
        :product="product"
        :index="index"
      />
    </VCol>

  </VRow>
  <div class="loading" v-if="loading === 1">
    <div class="effect-1 effects"></div>
    <div class="effect-2 effects"></div>
    <div class="effect-3 effects"></div>
  </div>
  <div class="loading" v-else>
  </div>
</template>
<script>
import axios from "axios";
import debounce from 'lodash/debounce';

export default {
  data() {
    return {
      ProductsList: [],
      mostViewedList: [],
      tempProductsList: [],
      slider: [
        {
          image_url: '',
        },
      ],
      loading: 0,
      scrollTop: 0,
      limit: 0,
      userData1: [{"id": ''}],
    }
  },
  methods: {
    async handleScroll(event) {
      // Any code to be executed when the window is scrolled

      var windowScrollYOld = 0, windowScrollYNew = 0;
      this.isUserScrolling = (window.scrollY > 0);
      windowScrollYNew = window.scrollY;//alert(windowScrollYNew + '>' + windowScrollYOld);
      if ((window.innerHeight + window.scrollY) >= ((document.body.offsetHeight) - 40) && windowScrollYNew > windowScrollYOld) {
        // alert((window.innerHeight + window.scrollY) + '>=' + document.body.offsetHeight)
        // alert(this.limit)
        this.limit = this.limit + 20
        this.loading = 1
        await axios.post('http://192.168.58.42:3000/api/site/action', {
          action: 'ProductsList',
          lang_id: localStorage.lang_id,
          limit: this.limit
        })
          .then(result => {
            // console.log(result.data)
            this.tempProductsList = result.data
            this.loading = 0
            // console.log(JSON.parse(JSON.stringify(this.ProductsList)))
            // console.log('preethika')
            // console.log(JSON.parse(JSON.stringify(this.tempProductsList)))
            var list = this.ProductsList;
            this.tempProductsList.map(function (value, key) {
              list.push(value)
            });
            this.ProductsList = list;
            // this.tempProductsList = []
            console.log(this.ProductsList)
          });
        if (!localStorage.userData) {
          if (localStorage.favouriteList) {
            this.ProductsList.forEach((value, index) => {
              this.favouriteList = JSON.parse(localStorage.getItem("favouriteList") || '[]')
              let proId = this.favouriteList.filter(x => x.productId == value.id).map(x => x.productId);
              if (proId[0] === value.id) {
                // JSON.parse(JSON.stringify(this.ProductsList[index])).is_fav = 1
                this.ProductsList[index].is_fav = 1
              }
            });
          }
        }
      }
      windowScrollYOld = windowScrollYNew;
    },
    goToSliderView(url) {
      // window.location.href = url;
      window.open(url, '_blank');
    }
  },

  async mounted() {
    this.loading = 1
    this.userData1 = JSON.parse(localStorage.getItem("userData") || '[]')
    await axios.post('http://192.168.58.42:3000/api/site/action', {
      action: 'getSlider',
      lang_id: localStorage.lang_id,
    })
      .then(result => {
        // console.log(result.data)
        this.slider = result.data
        this.loading = 0
        // console.log(JSON.parse(JSON.stringify(this.slider)))
      });
    await axios.post('http://192.168.58.42:3000/api/site/action', {
      action: 'mostViewedList',
      lang_id: localStorage.lang_id,
      userId: this.userData1.id,
    })
      .then(result => {
        // console.log(result.data)
        this.mostViewedList = result.data
        this.loading = 0
        // console.log(JSON.parse(JSON.stringify(this.ProductsList)))
      });
    await axios.post('http://192.168.58.42:3000/api/site/action', {
      action: 'ProductsList',
      lang_id: localStorage.lang_id,
      limit: this.limit,
      userId: this.userData1.id,
    })
      .then(result => {
        // console.log(result.data)
        this.ProductsList = result.data
        this.loading = 0
        // console.log(JSON.parse(JSON.stringify(this.ProductsList)))
      });
    if (!localStorage.userData) {
      this.mostViewedList.forEach((value, index) => {
        this.favouriteList = JSON.parse(localStorage.getItem("favouriteList") || '[]')
        let proId = this.favouriteList.filter(x => x.productId == value.id).map(x => x.productId);
        if (proId[0] === value.id) {
          // JSON.parse(JSON.stringify(this.ProductsList[index])).is_fav = 1
          this.mostViewedList[index].is_fav = 1
          // this.ProductsList[index].is_fav = 1
        }
      });
      if (localStorage.favouriteList) {
        this.ProductsList.forEach((value, index) => {
          this.favouriteList = JSON.parse(localStorage.getItem("favouriteList") || '[]')
          let proId = this.favouriteList.filter(x => x.productId == value.id).map(x => x.productId);
          if (proId[0] === value.id) {
            // JSON.parse(JSON.stringify(this.ProductsList[index])).is_fav = 1
            this.ProductsList[index].is_fav = 1
            // this.mostViewedList[index].is_fav = 1
          }
        });
      }
    }

    this.handleDebouncedScroll = debounce(this.handleScroll, 100);
    window.addEventListener('scroll', this.handleDebouncedScroll);
  },

  // beforeDestroy() {
  //   // I switched the example from `destroyed` to `beforeDestroy`
  //   // to exercise your mind a bit. This lifecycle method works too.
  //   window.removeEventListener('scroll', this.handleDebouncedScroll);
  // }
}

// export default {
//   data() {
//     return {
//       ProductsList: [],
//       loading: 0,
//       scrollTop: 0,
//       limit: 0,
//       userData1: [{"id":''}],
//     }
//   },
//   async created() {
//     // window.addEventListener('scroll', this.handleScroll);
//     this.loading = 1
//     this.userData1 = JSON.parse(localStorage.getItem("userData") || '[]')
//
//     await axios.post('http://192.168.58.42:3000/api/site/action', {
//       action: 'ProductsList',
//       lang_id: localStorage.lang_id,
//       limit: this.limit,
//       userId: this.userData1.id,
//     })
//       .then(result => {
//         // console.log(result.data)
//         this.ProductsList = result.data
//         this.loading = 0
//         // console.log(JSON.parse(JSON.stringify(this.ProductsList)))
//       });
//     console.log(this.ProductsList)
//     // alert(1);
//   },
//   methods: {
//     // handleScroll (event) {
//     // this.scrollTop = event.currentTarget.scrollTop;
//     // alert(event.currentTarget.scrollTop)
//
//     // Any code to be executed when the window is scrolled
//     // }
//   },
//   mounted() {
//     // alert(2);
//     // setTimeout(() =>
//     // alert(this.limit)
//     alert(this.ProductsList);
//     var windowScrollYOld = 0, windowScrollYNew = 0;
//     window.onscroll = function (e) {
//       // alert(this.limit)
//       console.log(this.ProductsList)
//       // alert(window.innerHeight + '/' + window.scrollY + '/' + document.body.offsetHeight)
//       windowScrollYNew = window.scrollY;//alert(windowScrollYNew + '>' + windowScrollYOld);
//       if ((window.innerHeight + window.scrollY) >= ((document.body.offsetHeight) - 20) && windowScrollYNew > windowScrollYOld) {
//         alert((window.innerHeight + window.scrollY) + '>=' + document.body.offsetHeight)
//         // this.limit = this.limit + 20
//         // alert(this.limit)
//         // this.loading = 1
//         // axios.post('http://192.168.58.42:3000/api/site/action', {
//         //   action: 'ProductsList',
//         //   lang_id: localStorage.lang_id,
//         //   limit: 20
//         // })
//         //   .then(result => {
//         //     console.log(result.data)
//         //     this.ProductsList = this.ProductsList.push(result.data)
//         //     // this.loading = 0
//         //     console.log(JSON.parse(JSON.stringify(this.ProductsList)))
//         //   });
//         console.log(this.ProductsList)
//       }
//       windowScrollYOld = windowScrollYNew;
//     }
//     // , 1000);
//   }
// }
</script>
<style lang="scss">
.alert-demo-v-model-wrapper {
  margin-block-end: 1rem;
  min-block-size: 50px;
}

.v-carousel__controls {
  background: none;
}

.v-window__left {
  background: rgba(var(--v-theme-surface-variant), 0.3) !important;
}

.v-window__right {
  background: rgba(var(--v-theme-surface-variant), 0.3) !important;
}

@media (max-width: 991px) {

  .v-window__controls {
    padding-bottom: 230px;
  }

  .v-img__img--contain {
    padding-bottom: 230px;
  }

  .v-carousel__controls {
    padding-bottom: 215px;
  }
  .set_height {
    height: 150px;
  }

}
</style>
