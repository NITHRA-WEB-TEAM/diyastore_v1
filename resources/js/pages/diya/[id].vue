<script setup>
// import {useTheme} from 'vuetify'
import ImageView
  from '@/views/diya/diya/imageView.vue'
// import ProductDetail from '@/views/diya/diya/productDetail.vue'
import ProductCard from '@/views/diya/diya/card.vue'

</script>

<template>
  <div>
  <VRow  v-if="dataAvailable">

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
        <!--                <br>-->
        <VCard>
          <img class="nozoom" type="button" :src="image.src" style="width: 33%;" alt=""
               v-for="(image,index) in getSingleData.images" @click="mainImage(image.src)">
        </VCard>
      </VCard>
      <!--        Add to Cart Button-->
      <br>
      <!--      <div class="d-flex align-center">-->
      <!--        <div class="align-center">-->
      <!--          <VAvatar-->
      <!--            color="#FF6801"-->
      <!--            style="width: 160px;height: 45px;color: white; float: left"-->
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
      <!--            style="width: 160px;height: 45px;float: right"-->
      <!--            rounded-->
      <!--            class="me-2 v-btn&#45;&#45;elevated ml-2"-->
      <!--          >-->
      <!--            <VIcon-->
      <!--              size="30"-->
      <!--              icon="tabler-credit-card"-->
      <!--            />-->
      <!--            Buy Now-->
      <!--          </VAvatar>-->
      <!--          &lt;!&ndash;        <span>Add to cart</span>&ndash;&gt;-->
      <!--        </div>-->
      <!--      </div>-->
    </VCol>

    <VCol
      cols="12"
      md="7"
    >
      <VCard>
        <!--/*    <img src="../../../../images/svg/gift.svg" style="width: -webkit-fill-available;" alt="">*/-->
        <!-- SECTION Header -->
        <VCardText class="d-flex flex-wrap justify-space-between flex-column flex-sm-row print-row">
          <!-- 👉 Left Content -->
          <div class="ma-sm-4">
            <div class="d-flex align-center mb-6">

              <!-- 👉 Title -->
              <h6 class="font-weight-bold text-xl">
                {{ getSingleData.titles }}

              </h6>
            </div>

            <p class="mb-0 font-weight-medium text-decoration-line-through float-left">
              M.R.P : ₹ {{ getSingleData.price }}
            </p>
            <p class="mb-0 font-weight-medium text-success float-left ml-4">
              M.R.P : ₹ {{ Math.ceil(getSingleData.price - getSingleData.discount_amt) }}
            </p><br><br>
            <p class="mb-0 font-weight-medium text-error mr-2 float-left">
              {{ getSingleData.discount }} %
            </p>
            <p class="mb-0 font-weight-medium text-warning ">
              You Save : ₹ {{ Math.ceil(getSingleData.discount_amt) }}
            </p><br>
            <div class="d-flex align-center ml-0">
              <VAvatar
                color="#FF6801"
                style="width: 160px;height: 45px;color: white"
                rounded
                class="me-2 v-btn--elevated"
                role="button"
                @click="isSnackbarScrollReverseVisible = true;addToCart(getSingleData.id)"
              >
                <VIcon
                  size="30"
                  icon="tabler-shopping-cart-plus"
                />
                {{ getSingleData.is_cart == 1 ? 'Go to cart' : 'Add to Cart'  }}
              </VAvatar>
              <VAvatar
                color="success"
                style="width: 160px;height: 45px"
                rounded
                role="button"
                class="me-2 v-btn--elevated"
              >
                <VIcon
                  size="30"
                  icon="tabler-credit-card"
                />
                Buy Now
              </VAvatar>
              <!--        <span>Add to cart</span>-->
            </div>
          </div>

          <!-- 👉 Right Content -->

          <div class="mt-4 ma-sm-4">
            <!-- 👉 Invoice ID -->
            <h6 v-if="getSingleData.stock > 10" class="font-weight-medium text-xl mb-6 text-success">
              In Stock
            </h6>
            <h6 v-else class="font-weight-medium text-xl mb-6 text-error">
              Only {{ getSingleData.stock }} left
            </h6>


            <!-- 👉 Issue Date -->
            <!--        <p class="mb-2">-->
            <!--          <span>Date Issued: </span>-->
            <!--          <span class="font-weight-semibold">Date</span>-->
            <!--        </p>-->

            <!-- 👉 Due Date -->
            <!--        <p class="mb-2">-->
            <!--          <span>Due Date: </span>-->
            <!--          <span class="font-weight-semibold">Due date</span>-->
            <!--        </p>-->
          </div>
        </VCardText>
        <!-- !SECTION -->
        <VDivider/>
        <VCardText class="d-flex justify-space-between flex-wrap flex-column flex-sm-row print-row">
          <div class="ma-sm-8">
            <h6 class="text-sm font-weight-semibold mb-3">
              Product Details
            </h6>
            <p v-html="getSingleData.description" class="mb-1">
            </p>
          </div>

        </VCardText>
      </VCard>
      <VSnackbar
        v-model="isSnackbarScrollReverseVisible"
        transition="scroll-y-reverse-transition"
        location="top end"
        color="warning"
      >
        Added to Cart
        <template #actions>
          <VBtn
            color="white"
            @click="isSnackbarScrollReverseVisible = false"
            max-width="500px"
          >
            <VIcon
              icon="tabler-x"
              size="20"
            />
          </VBtn>
        </template>
      </VSnackbar>
<!--      <productDetail :productData="getSingleData"/>-->
    </VCol>
  </VRow>
  <VRow class="" v-else>
    <VCol
      cols="12"
      md="3"
    >
    </VCol>
    <VCol
      cols="12"
      md="6"
    ><br><br><br>
      <h1 class="text-error">This Product is Currently Not Available </h1>
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
      <ProductCard
        :product="product"
        :index="index"
      />
    </VCol>

  </VRow>
  </div>

</template>

<style lang="scss">
</style>
<script>
import axios from "axios";
const isSnackbarScrollReverseVisible = ref(false)

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
      dataAvailable: 1,
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
    await axios.post(this.site_url, {
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
        // this.productDataReceived = JSON.parse(JSON.stringify(this.getSingleData))

        // console.log(JSON.parse(JSON.stringify(this.productDataReceived)))
        // console.log('here 12')
        // alert(this.categoryId)
      }).catch(error => {
        this.dataAvailable = 0
      });
    axios.post(this.site_url, {
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
  methods: {
    mainImage(url) {
      // alert(url)
      this.imageSrc = url
    }
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
<style>
.zoom {
  padding: 50px;
  transition: transform .2s;
  margin: 0 auto;
}

.nozoom {
  padding: 50px;
  transition: transform .2s;
  margin: 0 auto;
}

.zoom:hover {
  -ms-transform: scale(1.5);
  -webkit-transform: scale(1.5);
  transform: scale(1.5);
}
</style>
