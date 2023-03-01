<script setup>
// import {useTheme} from 'vuetify'
import ImageView
  from '@/views/dashboards/diya/imageView.vue'
import ProductDetail
  from '@/views/dashboards/diya/productDetail.vue'
import CrmSalesAreaCharts from '@/views/dashboards/crm/CrmSalesAreaCharts.vue'
import CheckOut
  from '@/views/dashboards/diya/checkout.vue'

</script>

<template>
  <VRow class="match-height">
    <div class="loading">
      <div class="effect-1 effects"></div>
      <div class="effect-2 effects"></div>
      <div class="effect-3 effects"></div>
    </div>
    <VCol
      cols="12"
      md="3"
      style="margin-left: 950px;position: fixed;"
    >
      <CheckOut :ProductsList="ProductsList"/>

      <!--      <VCard>-->
      <!--        <VCardText>-->
      <!--          &lt;!&ndash; 👉 Send Invoice Trigger button &ndash;&gt;-->
      <!--          <span class="truncate-16">PRICE DETAILS</span>-->
      <!--          <VDivider/>-->
      <!--          <br>-->
      <!--          <p><span class="mb-4 mr-2">Price({{ ProductsList.length }} Items)</span><span class="ml-16">₹-->
      <!--          {{ getTotal() }}-->
      <!--          </span></p>-->
      <!--          <p><span class="mb-4 mr-16">Discount</span><span class="ml-16">₹ {{ getDiscount() }}</span></p>-->
      <!--          <VDivider/>-->
      <!--          <p class="mt-4"><span class=" mr-12 font-weight-bold text-black">Total Amount</span><span-->
      <!--            class="ml-8 font-weight-bold text-black">₹ {{ totalPrice - totalDiscount}}</span></p>-->
      <!--          <VDivider/>-->
      <!--          <br>-->

      <!--          &lt;!&ndash; 👉  Add Payment trigger button  &ndash;&gt;-->
      <!--          <VBtn-->
      <!--            block-->
      <!--            type="button"-->
      <!--            prepend-icon="tabler-currency-rupee"-->
      <!--          >-->
      <!--            Check Out-->
      <!--          </VBtn>-->
      <!--        </VCardText>-->
      <!--      </VCard>-->
    </VCol>
    <VCol v-for="(product,index) in ProductsList" :key="index"
          cols="12"
          md="8"
    >
      <VCard>
        <!--/*    <img src="../../../../images/svg/gift.svg" style="width: -webkit-fill-available;" alt="">*/-->
        <!-- SECTION Header -->
        <VCardText class="d-flex flex-wrap justify-space-between flex-column flex-sm-row print-row">
          <!-- 👉 Left Content -->

          <img :src="product.images[0].src" width="150" height="150" alt="">

          <div class="">
            <div class="d-flex align-center mb-6">

              <!-- 👉 Title -->
              <h5 class="font-weight-bold">
                {{ product.titles.substring(0, 50) + "..." }}

              </h5>

            </div>
            <p class="mb-0 font-weight-medium  ">
              <span class="text-decoration-line-through mr-4"> M.R.P : ₹ {{ product.price }}</span>
              <span class="mb-0 font-weight-medium text-success mr-4 ">
              M.R.P : ₹ {{ Math.ceil(product.price - product.discount_amt) }}
            </span>
              <span class="mb-0 font-weight-medium text-error mr-4">
              {{ product.discount }} %
            </span>
              <span class="mb-0 font-weight-medium text-warning ">
              You Save : ₹ {{ Math.ceil(product.discount_amt) }}
            </span>
            </p>
            <!--            <p class="mb-0 font-weight-medium text-success ">-->
            <!--              M.R.P : ₹ {{ product.price - product.discount_amt }}-->
            <!--            </p>-->
            <!--            <p class="mb-0 font-weight-medium text-error mr-2">-->
            <!--              {{ product.discount }} %-->
            <!--            </p>-->
            <!--            <p class="mb-0 font-weight-medium text-warning ">-->
            <!--              You Save : ₹ {{ Math.ceil(product.discount_amt) }}-->
            <!--            </p>-->
            <br>
            <div class="d-flex align-center ml-0">
              <VAvatar
                color="success"
                style="width: 150px;height: 40px"
                rounded
                class="me-2 v-btn--elevated"
                type="button"
              >
                <VIcon
                  size="25"
                  icon="tabler-credit-card"
                />
                <div style="flex-grow: 0.1"> Buy Now</div>
              </VAvatar>
              <span>Quantity : {{ product.qty }}</span>
            </div>
          </div>

          <!-- 👉 Right Content -->

          <div class="mt-4 ">
            <!-- 👉 Invoice ID -->
            <VCol
              cols="2"
              md="2"
              sm="2"
              lg="2"
              style="margin: -20px 0px 0px 35px;"
            >
              <VBtn
                icon
                variant="text"
                color="error"
                size="small"
                v-if="product.is_fav === 1"
                @click="product.is_fav = 0; addToFavourite(product.id);"
              >
                <VIcon
                  icon="tabler-heart-filled"
                  size="24"
                />

              </VBtn>
              <VBtn
                icon
                variant="text"
                color="error"
                size="small"
                @click="product.is_fav = 1; addToFavourite(product.id);"
                v-else
              >
                <VIcon
                  icon="tabler-heart"
                  size="24"
                />

              </VBtn>
            </VCol>
            <h6 v-if="product.stock > 10" class="font-weight-medium text-xl mb-6 text-success">
              In Stock
            </h6>
            <h6 v-else class="font-weight-medium text-xl mb-6 text-error">
              Only {{ product.stock }} left
            </h6>
            <VAvatar
              color=""
              rounded
              class="me-2 v-btn--elevated"
              style="margin-left: 30px;"
            >
              <VIcon
                size="20"
                color="error"
                icon="tabler-trash"
              />
            </VAvatar>


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
      </VCard>
    </VCol>


  </VRow>
  <VRow class="match-height">
    <VCol
      cols="12"
      md="8"
      sm="8"
      lg="8"
    >
      <h2 class="align-center">Product Wish List(20)</h2>
    </VCol>

    <VCol v-for="(product,index) in favoriteProduct" :key="index"
          cols="12"
          md="8"
    >
      <VCard>
        <!--/*    <img src="../../../../images/svg/gift.svg" style="width: -webkit-fill-available;" alt="">*/-->
        <!-- SECTION Header -->
        <VCardText class="d-flex flex-wrap justify-space-between flex-column flex-sm-row print-row">
          <!-- 👉 Left Content -->
          <img :src="product.images[0].src" width="150" height="150" alt="">

          <div class="">
            <div class="d-flex align-center mb-6">

              <!-- 👉 Title -->
              <h5 class="font-weight-bold">
                {{ product.titles.substring(0, 50) + "..." }}

              </h5>
            </div>
            <p class="mb-0 font-weight-medium  ">
              <span class="text-decoration-line-through mr-4"> M.R.P : ₹ {{ product.price }}</span>
              <span class="mb-0 font-weight-medium text-success mr-4 ">
              M.R.P : ₹ {{ Math.ceil(product.price - product.discount_amt) }}
            </span>
              <span class="mb-0 font-weight-medium text-error mr-4">
              {{ product.discount }} %
            </span>
              <span class="mb-0 font-weight-medium text-warning ">
              You Save : ₹ {{ Math.ceil(product.discount_amt) }}
            </span>
            </p>
            <br>
            <div class="d-flex align-center ml-0">
              <VAvatar
                color="#FF6801"
                style="width: 160px;height: 45px;color: white"
                rounded
                class="me-2 v-btn--elevated"
                @click="isSnackbarScrollReverseVisible = true;addToCart(product.id)"
                type="button"
              >
                <VIcon
                  size="30"
                  icon="tabler-shopping-cart-plus"
                />
                Move to cart
              </VAvatar>
              <VAvatar
                color="success"
                style="width: 160px;height: 45px"
                rounded
                class="me-2 v-btn--elevated"
                type="button"
              >
                <VIcon
                  size="25"
                  icon="tabler-credit-card"
                />
                <div style="flex-grow: 0.1"> Buy Now</div>
              </VAvatar>
              <!--        <span>Add to cart</span>-->
            </div>
          </div>

          <div class="mt-4 ">
            <VCol
              cols="2"
              md="2"
              sm="2"
              lg="2"
              style="margin: -20px 0px 0px 35px;"
            >
              <VBtn
                icon
                variant="text"
                color="error"
                size="small"
                v-if="product.is_fav === 1"
                @click="product.is_fav = 0; addToFavourite(product.id);"
              >
                <VIcon
                  icon="tabler-heart-filled"
                  size="24"
                />

              </VBtn>
              <VBtn
                icon
                variant="text"
                color="error"
                size="small"
                @click="product.is_fav = 1; addToFavourite(product.id);"
                v-else
              >
                <VIcon
                  icon="tabler-heart"
                  size="24"
                />

              </VBtn>
            </VCol>
            <h6 v-if="product.stock > 10" class="font-weight-medium text-xl mb-6 text-success">
              In Stock
            </h6>
            <h6 v-else class="font-weight-medium mb-6 text-error">
              Only {{ product.stock }} left
            </h6>


            <VAvatar
              color=""
              rounded
              class="me-2 v-btn--elevated"
              style="margin-left: 30px;"
            >
              <VIcon
                size="20"
                color="error"
                icon="tabler-trash"
              />
            </VAvatar>
          </div>
        </VCardText>
        <!-- !SECTION -->
        <VDivider/>
      </VCard>
    </VCol>

  </VRow>
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
</template>

<style lang="scss">
</style>
<script>
const isSnackbarScrollReverseVisible = ref(false)

import axios from "axios";

// const route = useRoute()
export default {
  // setup(){
  //   alert('check')
  // },
  inheritAttrs: false,
  data() {
    return {
      ProductsList: [],
      favoriteProduct: [],
      userData: [],
      categoryId: '',
      totalPrice: 0,
      totalDiscount: 0,
      // id: $route.params.id
    }
  },
  async created() {
    if (localStorage.userData) {
      this.userData = JSON.parse(localStorage.getItem("userData") || '[]')
      // console.log(this.userData.id)
      await axios.post('http://localhost:8000/api/site/action', {
        action: 'getCartItem',
        lang_id: localStorage.lang_id,
        userId: this.userData.id,
      })
        .then(result => {
          this.ProductsList = result.data
          console.log(JSON.parse(JSON.stringify(this.ProductsList)))
          // console.log('here 12')
          // alert(this.categoryId)
        });
    } else {
      if (localStorage.cartItem) {
        this.localCartList = JSON.parse(localStorage.getItem("cartItem") || '[]')
        console.log(this.localCartList)
        axios.post('http://localhost:8000/api/site/action', {
          action: 'dataForLocal',
          proArray: JSON.stringify(this.localCartList),
          lang_id: localStorage.lang_id,
        })
          .then(result => {
            this.ProductsList = result.data
            console.log(JSON.parse(JSON.stringify(this.ProductsList)))
            // console.log('here 12')
            // alert(this.categoryId)
          });
      }
    }

    axios.post('http://localhost:8000/api/site/action', {
      action: 'ProductsList',
      lang_id: localStorage.lang_id,

    })
      .then(result => {
        this.favoriteProduct = result.data
        // console.log(result.data)
        // this.favoriteProduct = (JSON.parse(JSON.stringify(this.favoriteProduct)))
        // console.log(JSON.parse(JSON.stringify(this.favoriteProduct)))
      });
    // this.getDetails()

  },
  methods: {
    getTotal() {
      const mulQty = this.ProductsList.filter(x => x.price).map(x => x.qty * x.price);
      const sumTotal = mulQty.reduce((partialSum, a) => partialSum + a, 0);
      return this.totalPrice = sumTotal
    },
    getDiscount() {
      const mulQtyDiscount = this.ProductsList.filter(x => x.discount_amt).map(x => x.qty * x.discount_amt);
      const sumDiscount = mulQtyDiscount.reduce((partialSum, a) => partialSum + a, 0);
      return this.totalDiscount = Math.ceil(sumDiscount)
    }
  }
}
</script>
