<script setup>
// import {useTheme} from 'vuetify'
import ImageView
  from '@/views/dashboards/diya/imageView.vue'
import ProductDetail
  from '@/views/dashboards/diya/productDetail.vue'
import relatedProducts from '@/views/dashboards/crm/relatedProduct.vue'
import CrmSalesAreaCharts from '@/views/dashboards/crm/CrmSalesAreaCharts.vue'
import ProductCard from '@/views/diya/diya/card.vue'
</script>

<template>
  <div>
    <template v-if="ProductsList.length > 0">
      <div class="loading" v-if="loading===1">
        <div class="effect-1 effects"></div>
        <div class="effect-2 effects"></div>
        <div class="effect-3 effects"></div>
      </div>
      <div class="loading" v-else>
      </div>
      <VRow class="mt-2">
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
    </template>
    <template v-else>
      <h2>NO data</h2>
    </template>

  </div>
</template>

<style lang="scss">
</style>
<script>
import axios from "axios";

// const route = useRoute()
export default {
  inheritAttrs: false,
  data() {
    return {
      ProductsList: [],
      loading: 1,
      relatedProduct: [],
      userData: [],
      categoryId: '',
      // id: $route.params.id
    }
  },
  created() {
    if (localStorage.userData) {
      this.userData = JSON.parse(localStorage.getItem("userData") || '[]')
      axios.post(this.site_url, {
        action: 'getFavouriteItem',
        lang_id: localStorage.lang_id,
        userId: this.userData.id
      })
        .then(result => {
          this.loading = 0;
          this.ProductsList = result.data

          console.log(JSON.parse(JSON.stringify(this.ProductsList)))
          // console.log('here 12')
          // alert(this.categoryId)
        });
    }else {
      if (localStorage.favouriteList) {
        this.favouriteList = JSON.parse(localStorage.getItem("favouriteList") || '[]')

        axios.post(this.site_url, {
          action: 'dataForLocal',
          proArray: JSON.stringify(this.favouriteList),
          lang_id: localStorage.lang_id,
        })
          .then(result => {
            this.loading = 0;
            this.ProductsList = result.data
            console.log(JSON.parse(JSON.stringify(this.ProductsList)))
            this.ProductsList.forEach((value, index) => {
              this.favouriteList = JSON.parse(localStorage.getItem("favouriteList") || '[]')
              let proId = this.favouriteList.filter(x => x.productId == value.id).map(x => x.productId);
              if(proId[0]===value.id){
                // JSON.parse(JSON.stringify(this.ProductsList[index])).is_fav = 1
                this.ProductsList[index].is_fav = 1
              }
            });
            // console.log('here 12')
            // alert(this.categoryId)
          });
      }
    }
    // this.getDetails()
  }

}
</script>
