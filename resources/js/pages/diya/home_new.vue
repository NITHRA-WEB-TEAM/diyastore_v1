<script setup>
import ProductCard from '@/views/diya/diya/card.vue'
import bannerImage from '@images/banner/banner1.png'
</script>

<template>
  <div>
    <VImg
      class="mb-10"
      src="https://d1zqapbqie7n0v.cloudfront.net/diya_stores_wesite.png"
    />
    <VSheet
      class="mx-auto"
      elevation="8"

    >
      <VSlideGroup
        v-model="model"
        class="pa-4"
        selected-class="bg-success"
        show-arrows
      >
        <VSlideGroupItem
          v-for="(item,index) in slider"
          :key="index"
        >
          <VCard
            class="margin_class selectedClass"
            color="grey-lighten-1"

            height="173"
            width="600"
            @click="goToSliderView(item.link)"
          >
            <div>
              <VImg
                :src="item.image_url"
                class="mb-10 selectedClass"
              />
            </div>
          </VCard>
        </VSlideGroupItem>
      </VSlideGroup>
    </VSheet>
    <br>
    <VRow style="margin: 0px!important;">
      <h2 style="padding-left:12px;">Most Viewed Products</h2>
    </VRow>

    <VRow style="margin: 0px!important;">
      <br>
      <VCol
        v-for="(product,index) in mostViewedList"
        :key="index"
        lg="3"
        md="3"
        sm="6"
      >
        <div class="container">
        <ProductCard
          :index="index"
          :product="product"
        />
        </div>
      </VCol>
    </VRow>
    <br>

    <VRow style="margin: 0px!important;">
      <h2 style="padding-left:12px;">Newly Added Products</h2>
    </VRow>
    <br>
    <VRow>
      <VCol
        v-for="(product,index) in ProductsList"
        :key="index"
        lg="3"
        md="4"
        sm="6"
      >
        <ProductCard
          :index="index"
          :product="product"
        />
      </VCol>
    </VRow>
    <div
      v-if="loading === 1"
      class="loading"
    >
      <div class="effect-1 effects"/>
      <div class="effect-2 effects"/>
      <div class="effect-3 effects"/>
    </div>
    <div
      v-else
      class="loading"
    />
  </div>
</template>

<script>
import axios from "axios"
import debounce from 'lodash/debounce'

export default {

  data() {
    return {
      ProductsList: [],
      ProductId: [],
      model:'',
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
  mounted() {
    alert(this.cartCount)
  },
  created() {
    // console.log(this.$options);
    // $('#cartAlert').hide();
  },

  async mounted() {
    this.loading = 1
    this.userData1 = JSON.parse(localStorage.getItem("userData") || '[]')
    await axios.post(this.site_url, {
      action: 'getSlider',
      lang_id: localStorage.lang_id,
    })
      .then(result => {
        // console.log(result.data)
        this.slider = result.data
        this.loading = 0

        console.log(JSON.parse(JSON.stringify(this.slider)))
      })
    await axios.post(this.site_url, {
      action: 'mostViewedList',
      lang_id: localStorage.lang_id,
      userId: this.userData1.id,
    })
      .then(result => {
        // console.log(result.data)
        this.mostViewedList = result.data
        this.loading = 0

        // console.log(JSON.parse(JSON.stringify(this.ProductsList)))
      })
    await axios.post(this.site_url, {
      action: 'ProductsList',
      lang_id: localStorage.lang_id,
      limit: this.limit,
      userId: this.userData1.id,
      ProId: this.ProductId,
    })
      .then(result => {
        // (result.data)
        this.ProductsList = result.data

        // this.ProductId = result.data.map(x => x.id);
        this.ProductId = result.data.map(x => x.id)
        this.loading = 0

        // console.log(JSON.stringify(this.ProductId));
        // console.log(JSON.parse(JSON.stringify(this.ProductsList)))
      })
    if (!localStorage.userData) {
      this.mostViewedList.forEach((value, index) => {
        this.favouriteList = JSON.parse(localStorage.getItem("favouriteList") || '[]')
        let proId = this.favouriteList.filter(x => x.productId == value.id).map(x => x.productId)
        if (proId[0] === value.id) {
          // JSON.parse(JSON.stringify(this.ProductsList[index])).is_fav = 1
          this.mostViewedList[index].is_fav = 1

          // this.ProductsList[index].is_fav = 1
        }
      })
      if (localStorage.favouriteList) {
        this.ProductsList.forEach((value, index) => {
          this.favouriteList = JSON.parse(localStorage.getItem("favouriteList") || '[]')
          let proId = this.favouriteList.filter(x => x.productId == value.id).map(x => x.productId)
          if (proId[0] === value.id) {
            // JSON.parse(JSON.stringify(this.ProductsList[index])).is_fav = 1
            this.ProductsList[index].is_fav = 1

            // this.mostViewedList[index].is_fav = 1
          }
        })
      }
    }

    this.handleDebouncedScroll = debounce(this.handleScroll, 100)
    window.addEventListener('scroll', this.handleDebouncedScroll)
  },


  methods: {
    async handleScroll(event) {
      // Any code to be executed when the window is scrolled

      var windowScrollYOld = 0, windowScrollYNew = 0
      this.isUserScrolling = (window.scrollY > 0)
      windowScrollYNew = window.scrollY//alert(windowScrollYNew + '>' + windowScrollYOld);
      if ((window.innerHeight + window.scrollY) >= ((document.body.offsetHeight) - 40) && windowScrollYNew > windowScrollYOld) {
        // alert((window.innerHeight + window.scrollY) + '>=' + document.body.offsetHeight)
        // alert(this.limit)
        this.limit = this.limit + 20
        this.loading = 1
        await axios.post(this.site_url, {
          action: 'ProductsList',
          lang_id: localStorage.lang_id,
          limit: this.limit,
          ProId: this.ProductId,

          // proId:this.
        })
          .then(result => {
            // console.log(result.data)
            this.tempProductsList = result.data
            this.loading = 0

            // console.log(JSON.parse(JSON.stringify(this.ProductsList)))
            // console.log('preethika')
            // console.log(JSON.parse(JSON.stringify(this.tempProductsList)))
            var list = this.ProductsList
            this.tempProductsList.map(function (value, key) {
              list.push(value)
            })
            this.ProductsList = list
            this.ProductId = this.ProductsList.map(x => x.id)

            // this.tempProductsList = []
            console.log(JSON.parse(JSON.stringify(this.ProductsList)))

            // console.log(this.ProductsList)
          })
        if (!localStorage.userData) {
          if (localStorage.favouriteList) {
            this.ProductsList.forEach((value, index) => {
              this.favouriteList = JSON.parse(localStorage.getItem("favouriteList") || '[]')
              let proId = this.favouriteList.filter(x => x.productId == value.id).map(x => x.productId)
              if (proId[0] === value.id) {
                // JSON.parse(JSON.stringify(this.ProductsList[index])).is_fav = 1
                this.ProductsList[index].is_fav = 1
              }
            })
          }
        }
      }
      windowScrollYOld = windowScrollYNew
    },
    goToSliderView(url) {
      // window.location.href = url;
      window.open(url, '_blank')
    },
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
//     await axios.post('http://localhost:8000/api/site/action', {
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
//         // axios.post('http://localhost:8000/api/site/action', {
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

.margin_class {
  margin: 16px !important;
}

@media (max-width: 991px) {

  .v-window__controls {
    padding-bottom: 230px;
  }

  //.v-img__img--contain {
  //  padding-bottom: 230px;
  //}

  .v-carousel__controls {
    padding-bottom: 215px;
  }
  .set_height {
    height: 150px;
  }
  .selectedClass {
    height: 80px !important;
    width: 220px !important;
  }
  .margin_class {
    margin: 4px !important;
  }

}


</style>
