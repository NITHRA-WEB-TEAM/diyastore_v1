<script setup>
// import {useTheme} from 'vuetify'
import ImageView
  from '@/views/dashboards/diya/imageView.vue'
import ProductDetail
  from '@/views/dashboards/diya/productDetail.vue'
import relatedProducts from '@/views/dashboards/crm/relatedProduct.vue'
import CrmSalesAreaCharts from '@/views/dashboards/crm/CrmSalesAreaCharts.vue'

</script>

<template>
  <VRow class="match-height">

    <VCol
      cols="12"
      md="5"
    >

      <!--            <analytics-view :image-data="getSingleData"/>-->
      <image-view :imageData="getSingleData"/>
      <!--                  <image-view />-->
    </VCol>

    <VCol
      cols="12"
      md="7"
    >
      <!--      <VCard>-->
      <!--        <img :src="getSingleData.images[0].src" style="width: -webkit-fill-available;" alt="">-->
      <!--      </VCard>-->
      <productDetail :productData="getSingleData"/>
    </VCol>
  </VRow>
  <VRow>
    <VCol
      cols="12"
      md="8"
      sm="8"
      lg="8"
    >
      <h2 class="align-center">Related Products</h2>
    </VCol>
  </VRow>
  <VRow>
    <VCol v-for="(product,index) in relatedProduct" :key="index"
          cols="12"
          md="4"
          sm="6"
          lg="3"
    >
      <CrmSalesAreaCharts
        :product="product"
        :index="index"
      />
    </VCol>

  </VRow>
</template>

<style lang="scss">
</style>
<script>
import axios from "axios";

// const route = useRoute()
export default {
  setup(){
    // alert('check')
  },
  inheritAttrs: false,
  data() {
    return {
      getSingleData: [],
      ProductsList: [],
      relatedProduct: [],
      categoryId: '',
      userData1: [{"id":''}],
// id: $route.params.id
    }
  },
  async created() {
    // console.log(this.$route)
    this.userData1 = JSON.parse(localStorage.getItem("userData") || '[]')
    await axios.post('http://192.168.58.42:3000/api/site/action', {
      action: 'getSingleData',
      lang_id: localStorage.lang_id,
      productId: this.$route.params.id,
      userId: this.userData1.id,
    })
      .then(result => {
        this.getSingleData = result.data
        this.categoryId = (JSON.parse(JSON.stringify(this.getSingleData.category)))
        console.log(JSON.parse(JSON.stringify(this.getSingleData)))
        // console.log('here 12')
        // alert(this.categoryId)
      });
    axios.post('http://192.168.58.42:3000/api/site/action', {
      action: 'relatedProduct',
      lang_id: localStorage.lang_id,
      category: this.categoryId,
      userId: this.userData1.id,

    })
      .then(result => {
        this.relatedProduct = result.data
        // console.log(result.data)
        // this.relatedProduct = (JSON.parse(JSON.stringify(this.relatedProduct1)))
        // console.log(JSON.parse(JSON.stringify(this.relatedProduct)))
      });
    // this.getDetails()

  },
  watch: {
    async $route(to, from) {
      console.log(this.$route)
      // this.segment = this.$route.params.segment
      // this.onLoadTableData()
    }
  },

}
</script>
