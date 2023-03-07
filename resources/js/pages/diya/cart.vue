<script setup>
// import {useTheme} from 'vuetify'
import ImageView
  from '@/views/diya/diya/imageView.vue'
import ProductDetail
  from '@/views/diya/diya/productDetail.vue'
import CrmSalesAreaCharts from '@/views/diya/diya/card.vue'
import CheckOut
  from '@/views/diya/diya/checkout.vue'

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
      <VRow class="match-height">
        <!--     <div class="loading"  >-->
        <!--      <div class="effect-1 effects"></div>-->
        <!--      <div class="effect-2 effects"></div>-->
        <!--      <div class="effect-3 effects"></div>-->
        <!--    </div>-->


        <VCol
          cols="12"
          md="3"
          style="margin-left: 950px;position: fixed;"
        >
          <!--      <CheckOut :ProductsList="ProductsList"/>-->
          <VCard>
            <VCardText>
              <!-- 👉 Send Invoice Trigger button -->
              <span class="truncate-16">PRICE DETAILS</span>
              <VDivider/>
              <br>
              <p><span class="mb-4 mr-2">Price({{ ProductsList.length }} Items)</span><span class="ml-16 float-right">₹
          {{ getTotal() }}
          </span></p>
              <p><span class="mb-4 mr-16">Discount</span><span class=" float-right ml-16">₹ {{ getDiscount() }}</span></p>
              <VDivider/>
              <p class="mt-4"><span class=" mr-12 font-weight-bold text-black">Total Amount</span><span
                class="ml-8 font-weight-bold text-black float-right">₹ 897652 </span></p>
              <VDivider/>
              <br>

              <!-- 👉  Add Payment trigger button  -->
              <RouterLink v-if="goToLocation" :to="{ name: 'diya-addressCheck' }">

                <VBtn
                  block
                  type="button"
                  prepend-icon="tabler-currency-rupee"
                >
                  Check Out
                </VBtn>
              </RouterLink>
              <RouterLink v-else :to="{ name: 'login' }">

                <VBtn
                  block
                  type="button"
                  prepend-icon="tabler-currency-rupee"
                >
                  Check Out
                </VBtn>
              </RouterLink>
            </VCardText>
          </VCard>

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
              <RouterLink :to="{ name: 'diya-id', params: { id: product.id } }" target="_blank">

                <img :src="product.images[0].src" width="150" height="150" alt="">
              </RouterLink>
              <div class="">
                <RouterLink :to="{ name: 'diya-id', params: { id: product.id } }" target="_blank">

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
                </RouterLink>

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
                  @click="deleteCartItem(product.id)"
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
    </template>
    <template v-else>
    <h2>NO data</h2>
    </template>


<!--  <VRow class="match-height">-->
<!--    <VCol-->
<!--      cols="12"-->
<!--      md="8"-->
<!--      sm="8"-->
<!--      lg="8"-->
<!--    >-->
<!--      <h2 class="align-center">Product Wish List(20)</h2>-->
<!--    </VCol>-->

<!--    <VCol v-for="(product,index) in favoriteProduct" :key="index"-->
<!--          cols="12"-->
<!--          md="8"-->
<!--    >-->
<!--      <VCard>-->
<!--        &lt;!&ndash;/*    <img src="../../../../images/svg/gift.svg" style="width: -webkit-fill-available;" alt="">*/&ndash;&gt;-->
<!--        &lt;!&ndash; SECTION Header &ndash;&gt;-->
<!--        <VCardText class="d-flex flex-wrap justify-space-between flex-column flex-sm-row print-row">-->
<!--          &lt;!&ndash; 👉 Left Content &ndash;&gt;-->
<!--          <RouterLink :to="{ name: 'diya-id', params: { id: product.id } }" target="_blank">-->
<!--            <img :src="product.images[0].src" width="150" height="150" alt="">-->
<!--          </RouterLink>-->
<!--          <div class="">-->
<!--            <RouterLink :to="{ name: 'diya-id', params: { id: product.id } }" target="_blank">-->
<!--              <div class="d-flex align-center mb-6">-->
<!--                &lt;!&ndash; 👉 Title &ndash;&gt;-->
<!--                <h5 class="font-weight-bold">-->
<!--                  {{ product.titles.substring(0, 50) + "..." }}-->
<!--                </h5>-->
<!--              </div>-->
<!--              <p class="mb-0 font-weight-medium  ">-->
<!--                <span class="text-decoration-line-through mr-4"> M.R.P : ₹ {{ product.price }}</span>-->
<!--                <span class="mb-0 font-weight-medium text-success mr-4 ">-->
<!--              M.R.P : ₹ {{ Math.ceil(product.price - product.discount_amt) }}-->
<!--            </span>-->
<!--                <span class="mb-0 font-weight-medium text-error mr-4">-->
<!--              {{ product.discount }} %-->
<!--            </span>-->
<!--                <span class="mb-0 font-weight-medium text-warning ">-->
<!--              You Save : ₹ {{ Math.ceil(product.discount_amt) }}-->
<!--            </span>-->
<!--              </p>-->
<!--              <br>-->
<!--            </RouterLink>-->
<!--            <div class="d-flex align-center ml-0">-->
<!--              <VAvatar-->
<!--                color="#FF6801"-->
<!--                style="width: 160px;height: 45px;color: white"-->
<!--                rounded-->
<!--                class="me-2 v-btn&#45;&#45;elevated"-->
<!--                @click.once="isSnackbarScrollReverseVisible = true;addToCart(product.id)"-->
<!--                type="button"-->
<!--              >-->
<!--                <VIcon-->
<!--                  size="30"-->
<!--                  icon="tabler-shopping-cart-plus"-->
<!--                />-->
<!--                Move to cart-->
<!--              </VAvatar>-->
<!--              <VAvatar-->
<!--                color="success"-->
<!--                style="width: 160px;height: 45px"-->
<!--                rounded-->
<!--                class="me-2 v-btn&#45;&#45;elevated"-->
<!--                type="button"-->
<!--              >-->
<!--                <VIcon-->
<!--                  size="25"-->
<!--                  icon="tabler-credit-card"-->
<!--                />-->
<!--                <div style="flex-grow: 0.1"> Buy Now</div>-->
<!--              </VAvatar>-->
<!--              &lt;!&ndash;        <span>Add to cart</span>&ndash;&gt;-->
<!--            </div>-->
<!--          </div>-->

<!--          <div class="mt-4 ">-->
<!--            <VCol-->
<!--              cols="2"-->
<!--              md="2"-->
<!--              sm="2"-->
<!--              lg="2"-->
<!--              style="margin: -20px 0px 0px 35px;"-->
<!--            >-->
<!--              <VBtn-->
<!--                icon-->
<!--                variant="text"-->
<!--                color="error"-->
<!--                size="small"-->
<!--                v-if="product.is_fav === 1"-->
<!--                @click="product.is_fav = 0; addToFavourite(product.id);"-->
<!--              >-->
<!--                <VIcon-->
<!--                  icon="tabler-heart-filled"-->
<!--                  size="24"-->
<!--                />-->

<!--              </VBtn>-->
<!--              <VBtn-->
<!--                icon-->
<!--                variant="text"-->
<!--                color="error"-->
<!--                size="small"-->
<!--                @click="product.is_fav = 1; addToFavourite(product.id);"-->
<!--                v-else-->
<!--              >-->
<!--                <VIcon-->
<!--                  icon="tabler-heart"-->
<!--                  size="24"-->
<!--                />-->

<!--              </VBtn>-->
<!--            </VCol>-->
<!--            <h6 v-if="product.stock > 10" class="font-weight-medium text-xl mb-6 text-success">-->
<!--              In Stock-->
<!--            </h6>-->
<!--            <h6 v-else class="font-weight-medium mb-6 text-error">-->
<!--              Only {{ product.stock }} left-->
<!--            </h6>-->


<!--          </div>-->
<!--        </VCardText>-->
<!--        &lt;!&ndash; !SECTION &ndash;&gt;-->
<!--        <VDivider/>-->
<!--      </VCard>-->
<!--    </VCol>-->

<!--  </VRow>-->
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
  </div>
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
      ProID:[],
      loading: 1,
      favoriteProduct: [],
      userData: [],
      categoryId: '',
      totalPrice: 0,
      totalDiscount: 0,
      goToLocation: 0,
      // id: $route.params.id
    }
  },
  async created() {
    if (localStorage.userData) {
      this.goToLocation = 1
      this.userData = JSON.parse(localStorage.getItem("userData") || '[]')
      // console.log(this.userData.id)
      await axios.post(this.site_url, {
        action: 'getCartItem',
        lang_id: localStorage.lang_id,
        userId: this.userData.id,
      })
        .then(result => {
        this.loading=0;
          this.ProductsList = result.data

          // console.log(JSON.parse(JSON.stringify(this.ProductsList)))
          // console.log(this.ProductsList)
          // alert(this.categoryId)
        });
    } else {
      // alert('ssss')
      if (localStorage.cartItem) {
        this.localCartList = JSON.parse(localStorage.getItem("cartItem") || '[]')
        // console.log(this.localCartList)
        axios.post(this.site_url, {
          action: 'dataForLocal',
          proArray: JSON.stringify(this.localCartList),
          lang_id: localStorage.lang_id,
        })
          .then(result => {
            this.loading=0;
            this.ProductsList = result.data;
            // console.log(JSON.parse(JSON.stringify(this.ProductsList)))
            this.ProductsList.forEach((value, index) => {
              let proQty = this.localCartList.filter(x => x.productId == value.id).map(x => x.qty);
              let prodId = this.localCartList.filter(x => x.productId == value.id).map(x => x.productId);
              if (prodId[0] === value.id) {
                // JSON.parse(JSON.stringify(this.ProductsList[index])).is_fav = 1
                this.ProductsList[index].qty = proQty[0]
              }
            });
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
            // alert(this.categoryId)
          });

      }else{

      }
      // this.loading=0;
    }

    axios.post(this.site_url, {
      action: 'ProductsList',
      lang_id: localStorage.lang_id,
      ProId:this.ProID

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
    },
    deleteCartItem(cartItemId) {
      if (localStorage.userData) {
        alert(cartItemId)
        axios.post(this.site_url, {
          action: 'deleteCartItem',
          cartid: cartItemId,
          userId: this.userData.id,

        })
          .then(result => {
            if (result.data.status === 'success') {
              var deletedCart = this.ProductsList.findIndex(item => item.id === cartItemId);
              this.ProductsList.splice(deletedCart, 1);
            }
            // this.favoriteProduct = (JSON.parse(JSON.stringify(this.favoriteProduct)))
            // console.log(JSON.parse(JSON.stringify(this.favoriteProduct)))
          });
      } else {
        alert('ssss')
        if (localStorage.cartItem) {
          alert('ssss')
          this.cartItem = JSON.parse(localStorage.getItem("cartItem") || '[]')
          var deletedCart = this.cartItem.findIndex(item => item.productId === cartItemId);
          var proListDelCart = this.ProductsList.findIndex(item => item.id === cartItemId);
          this.cartItem.splice(deletedCart, 1);
          this.ProductsList.splice(proListDelCart, 1);
          localStorage.setItem("cartItem", JSON.stringify(this.cartItem));

        }
      }
    }
  }
}
</script>
