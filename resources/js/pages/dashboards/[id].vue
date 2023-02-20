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
  <VRow class="">

    <VCol
      cols="12"
      md="5"
    >
      <!--      <image-view :imageData="getSingleData"/>-->
      <VCard>
        <!--        <img class="zoom" src="https://d1zqapbqie7n0v.cloudfront.net/960748_1644050935.webp" style="width: -webkit-fill-available;" alt="">-->
        <img class="zoom" :src="imageSrc" style="width: -webkit-fill-available;" alt="">
<!--        Add to Cart Button-->
<!--        <div class="d-flex align-center ml-4">-->
<!--          <VAvatar-->
<!--            color="#FF6801"-->
<!--            style="width: 160px;height: 45px;color: white"-->
<!--            rounded-->
<!--            class="me-2 v-btn&#45;&#45;elevated"-->
<!--          >-->
<!--            <VIcon-->
<!--              size="30"-->
<!--              icon="tabler-shopping-cart-plus"-->
<!--            />-->
<!--            Add to cart-->
<!--          </VAvatar>-->
<!--          <VAvatar-->
<!--            color="success"-->
<!--            style="width: 160px;height: 45px"-->
<!--            rounded-->
<!--            class="me-2 v-btn&#45;&#45;elevated"-->
<!--          >-->
<!--            <VIcon-->
<!--              size="30"-->
<!--              icon="tabler-credit-card"-->
<!--            />-->
<!--            Buy Now-->
<!--          </VAvatar>-->
<!--          &lt;!&ndash;        <span>Add to cart</span>&ndash;&gt;-->
<!--        </div>-->
<!--        <br>-->
      </VCard>
    </VCol>

    <VCol
      cols="12"
      md="7"
    >
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
  setup() {
    // alert('check')
  },
  inheritAttrs: false,
  data() {
    return {
      getSingleData: [],
      ProductsList: [],
      relatedProduct: [],
      imageSrc: '',
      categoryId: '',
      userData1: [{"id": ''}],
// id: $route.params.id
    }
  },
  async created() {
    // console.log(this.$route)
    var imageSrcs = ''
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
        this.getSingleData.images.map(function (value, key) {
          imageSrcs = value.src;
          // console.log(value.src)
          // console.log(imageSrcs)
        });
        this.imageSrc = imageSrcs
        // console.log(JSON.parse(JSON.stringify(this.getSingleData)))
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
