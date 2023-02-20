<script setup>
// import {useTheme} from 'vuetify'
import ImageView
  from '@/views/dashboards/diya/imageView.vue'
import ProductDetail
  from '@/views/dashboards/diya/productDetail.vue'
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
    </VCol>

  </VRow>
</template>

<style lang="scss">
</style>
<script>
import axios from "axios";

const route = useRoute()
export default {
  setup() {
    const route = useRoute()

    onMounted(() => {
      const id = route.params.id
      alert(id)
    })
  },
  data() {
    return {
      getSingleData: [],
      ProductsList: [],
      relatedProduct: [],
      categoryId: ''
      // id: $route.params.id
    }
  },
   created() {
console.log('test')
     const route = useRoute()
console.log(this.$route)
     axios.post('http://192.168.58.42:3000/api/site/action', {
      action: 'getSingleData',
      lang_id: localStorage.lang_id,
      productId: this.$route.params.id
    })
      .then(result => {
        this.getSingleData = result.data
        this.categoryId = this.getSingleData.category
        // console.log(result.data)
      });
    axios.post('http://192.168.58.42:3000/api/site/action', {action: 'relatedProduct', lang_id: localStorage.lang_id, category: this.categoryId})
      .then(result => {
        console.log(result.data)
        this.relatedProduct = result.data
        // console.log(JSON.parse(JSON.stringify(this.ProductsList)))
      });
    // this.getDetails()
  }

}
</script>
