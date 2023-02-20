<template>
  <VCard>
    <!--/*    <img src="../../../../images/svg/gift.svg" style="width: -webkit-fill-available;" alt="">*/-->
    <!-- SECTION Header -->
    <VCardText class="d-flex flex-wrap justify-space-between flex-column flex-sm-row print-row">
      <!-- 👉 Left Content -->
      <div class="ma-sm-4">
        <div class="d-flex align-center mb-6">

          <!-- 👉 Title -->
          <h6 class="font-weight-bold text-xl">
            {{ productDataReceived.titles }}

          </h6>
        </div>

        <p class="mb-0 font-weight-medium text-decoration-line-through float-left">
          M.R.P : ₹ {{ productDataReceived.price }}
        </p>
        <p class="mb-0 font-weight-medium text-success float-left ml-4">
          M.R.P : ₹ {{ Math.ceil(productDataReceived.price - productDataReceived.discount_amt) }}
        </p><br><br>
        <p class="mb-0 font-weight-medium text-error mr-2 float-left">
          {{ productDataReceived.discount }} %
        </p>
        <p class="mb-0 font-weight-medium text-warning ">
          You Save : ₹ {{ Math.ceil(productDataReceived.discount_amt) }}
        </p><br>
        <div class="d-flex align-center ml-0">
          <VAvatar
            color="#FF6801"
            style="width: 160px;height: 45px;color: white"
            rounded
            class="me-2 v-btn--elevated"
            role="button"
            @click="isSnackbarScrollReverseVisible = true;addToCart(productDataReceived.id)"
          >
            <VIcon
              size="30"
              icon="tabler-shopping-cart-plus"
            />
            {{ productDataReceived.is_cart == 1 ? 'Go to cart' : 'Add to Cart'  }}
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
        <h6 v-if="productDataReceived.stock > 10" class="font-weight-medium text-xl mb-6 text-success">
          In Stock
        </h6>
        <h6 v-else class="font-weight-medium text-xl mb-6 text-error">
          Only {{ productDataReceived.stock }} left
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
        <p v-html="productDataReceived.description" class="mb-1">
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
</template>
<script>
const isSnackbarScrollReverseVisible = ref(false)
import axios from "axios";

export default {
  // props: ['productData'],
  props: {productData: {type: Object}},
  data() {
    return {
      productDataReceived: [],
      cartItem: [],
      cartArray: [],
      patient_id: this.productData.category
      // id: $route.params.id
    }
  },
  mounted() {
    setTimeout(() =>
        this.productDataReceived = this.productData
      , 1000);
  },
  created() {
    // this.productData = JSON.parse(JSON.stringify(this.productData))
    // this.productDataReceived = this.productData
    //  console.log(this.productDataReceived.titles)
    // console.log('here')
  },
  methods: {

  }
}
</script>
