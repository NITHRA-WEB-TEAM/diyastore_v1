<script setup>
import avatar1 from '@images/avatars/pay_on_deliver.png'
import avatar2 from '@images/avatars/refund_policy.png'
import avatar3 from '@images/avatars/speed_delivery.png'


// import {useTheme} from 'vuetify'
import ImageView
  from '@/views/diya/diya/imageView.vue'
// import ProductDetail from '@/views/diya/diya/productDetail.vue'
import ProductCard from '@/views/diya/diya/card.vue'

const isDialogVisible = ref(false)
const isDialogVisible1 = ref(false)
const isDialogVisible2 = ref(false)


</script>

<template>
  <div>
    <VRow v-if="dataAvailable">

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
            <img class="nozoom" type="button" :src="image.src" alt=""
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
              <ul class="list-group">
                <!--              <VIcon-->
                <!--                icon="tabler-heart-filled"-->
                <!--                size="24"-->
                <!--              />-->
                <!--              <VBtn icon="tabler-heart" />-->


                <VIcon
                  icon="tabler-align-left"
                  size="22"/>
                <span class="list-group-item text-amber-accent-1 ml-2">Availability : In Stock</span>
                <br>
                <VIcon
                  icon="tabler-align-left"
                  size="22"/>
                <span class="list-group-item ml-2">Cash on Delivery Available (+ ₹50 Shipping Charges Extra)</span><br>
                <VIcon
                  icon="tabler-align-left"
                  size="22"/>
                <span class="list-group-item ml-2">Delivery : Mar 6 - 8 </span><br>
                <VIcon
                  icon="tabler-align-left"
                  size="22"/>
                <span class="list-group-item ml-2">Return and Refund Policy </span><br>
                <VIcon
                  icon="tabler-align-left"
                  size="22"/>
                <span class="list-group-item ml-2" style="width: 7rem;overflow-wrap: break-word;">Payment Method : Cash on Delivery / Debit / Credit / ATM Card / Net Banking / Other UPI Apps </span><br>
                <!--    <span class="text-no-wrap ml-2"  "></span>-->

              </ul>

              <br>
              <div class="demo-space-x  ml-10">

                <VDialog
                  v-model="isDialogVisible"
                  width="500">
                  <!-- Activator -->
                  <template #activator="{ props }">
                    <span class="test_cursor" v-bind="props">
                    <VAvatar ondragover="this">

                      <VImg :src="avatar1"/>
                    </VAvatar>
                   Pay on Delivery</span>

                  </template>
                  <!-- Dialog close btn -->
                  <DialogCloseBtn @click="isDialogVisible = !isDialogVisible"/>
                  <!-- Dialog Content -->
                  <VCard title="Pay on Delivery">
                    <VCardText>
                      Cash on Delivery Available for this product.
                      <br>
                      ₹50 Shipping Charges Extra
                    </VCardText>

                    <VCardText class="d-flex justify-end">
                      <VBtn @click="isDialogVisible = false">
                        I accept
                      </VBtn>
                    </VCardText>
                  </VCard>
                </VDialog>

                <VDialog
                  v-model="isDialogVisible1"
                  width="500">
                  <!-- Activator -->
                  <template #activator="{ props }">
                    <span class="test_cursor" v-bind="props">
                    <VAvatar ondragover="this">
                      <VImg :src="avatar2" />
                    </VAvatar>Speed Delivery</span>
                  </template>
                  <!-- Dialog close btn -->
                  <DialogCloseBtn @click="isDialogVisible1 = !isDialogVisible1"/>
                  <!-- Dialog Content -->
                  <VCard title="SHIPPING & DELIVERY
">
                    <VCardText>
                      SHIPPING & DELIVERY Information We Strive to Deliver products ordered through diyastore.in in
                      excellent condition wrapped up in Secure pack. Time to Shipping Payment made via online: 1 to 2
                      Working Days VPP or Cash on Delivery 5 to 7 Working Days Note: Working days mentioned above are
                      excluding Saturdays, Sundays and Holidays.

                    </VCardText>

                    <VCardText class="d-flex justify-end">
                      <VBtn @click="isDialogVisible1 = false">
                        I accept
                      </VBtn>
                    </VCardText>
                  </VCard>
                </VDialog>

                <VDialog
                  v-model="isDialogVisible2"
                  width="500">
                  <!-- Activator -->
                  <template #activator="{ props }">
                    <span class="test_cursor" v-bind="props">
                    <VAvatar ondragover="this">
                      <VImg :src="avatar3"/>
                    </VAvatar>
                    Return and Refund Policy

</span>

{{list}}
                  </template>
                  <!-- Dialog close btn -->
                  <DialogCloseBtn @click="isDialogVisible2 = !isDialogVisible2"/>
                  <!-- Dialog Content -->
                  <VCard title="Return and Refund Policy">
                    <VCardText>
                      1. If the product is reached you in bad condition please inform us immediately over phone and send
                      the picture to our whatsapp number (which is sent via SMS with your order id) and send the product
                      to us within three days. Either we will send a new product or refund the amount paid for the
                      particular product with the return courier/postal charges. <br>
                      2. Any of the order placed with diyastore.in will be subject to cancelation before shipping. Any
                      cancelation request should reach us before the shipping of the products. If the order was
                      cancelled before shipment the refund will be 100%. Any refund request will get processed with in a
                      day of accepting the cancelation policy. We will usually refund any money received from you using
                      the same method originally used by you to pay for your purchase. We will process the refund due to
                      you as soon as possible and, in any event, within 10 days of the day we received your notice of
                      cancellation.<br>
                      3. If we are unable to deliver because of wrong address, receiver unavailability then the
                      responsibility is on the receiver side
                    </VCardText>

                    <VCardText class="d-flex justify-end">
                      <VBtn @click="isDialogVisible2 = false">
                        I accept
                      </VBtn>
                    </VCardText>
                  </VCard>
                </VDialog>

              </div>
              <br>
              <div class="container">
                <div class="row mb-8 justify-content-center ">
                  <div class="col-md-6 col-12">
                    <br>
                    <div class="row">
                      <div class="col-12">
                        <div class="d-flex justify-content-between">
                          <div style="overflow-wrap: break-word;">
                            <p class="text-wrap">Quantity:</p><br>
                          </div>
                          <br>
                          <div class="input-group w-auto justify-content-end align-items-center"
                               style="padding-left: 26px;">
                            <input type="button" @click="number > 1 ? decrement():''" value="-"
                                   class="button-minus border rounded-circle  icon-shape icon-sm mx-1 "
                                   data-field="quantity">
                            <input disabled type="text" :value="number" name="quantity"
                                   class="quantity-field border-0 text-center w-25">
                            <input type="button" @click="number <10 ? increment():''" value="+"
                                   class="button-plus border rounded-circle icon-shape icon-sm " data-field="quantity">
                          </div>
                        </div>
                      </div>
                      <div>
                        <p>Unit Price : {{ Math.ceil(getSingleData.price - getSingleData.discount_amt) }} X
                          {{ number }}</p>
                        <p>Total Amount :
                          {{ Math.ceil(getSingleData.price - getSingleData.discount_amt) * Math.ceil(number) }}</p>
                        <span>For Cash on Delivery : ₹ 70 /- Extra</span> &nbsp;&nbsp;
                      </div>

                    </div>
                  </div>
                </div>
              </div>

              <div class="d-flex  align-center" min-height="220">
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
                  {{ getSingleData.is_cart == 1 ? 'Go to cart' : 'Add to Cart' }}
                </VAvatar>
                <VAvatar
                  color="success"
                  style="width: 160px;height: 45px"
                  rounded
                  role="button"
                  class="me-1 v-btn--elevated"
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

import {createVuetify} from 'vuetify'
import {aliases, mdi} from 'vuetify/iconsets/mdi'
// const route = useRoute()
export default {
  setup() {
    // alert('check')
  },
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    }
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
      list:[],
      number: 1,
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

  },
  methods: {
    mainImage(url) {
      // alert(url)
      this.imageSrc = url
    },
    increment() {
      this.number++;
      this.ShipingAmntCalc(this.$route.params.id,this.number);
    },
    decrement() {
      this.number--;
      this.ShipingAmntCalc(this.$route.params.id,this.number);
    },
  async ShipingAmntCalc(ProId,Qty){
      const DataShipamnt = await this.callAxios(this.site_url, {'action':'ShipingAmnt',ProId:ProId,Qty:Qty}, 'post');
    this.list = DataShipamnt.data;
    },
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

icon-shape {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  vertical-align: middle;
}

.icon-sm {
  width: 2rem;
  height: 2rem;

}

@media screen and (max-width: 992px) {
  .nozoom {
    width: 160px;
  }
}

.test_cursor {
  cursor: pointer;
}

/* On screens that are 600px wide or less, make the columns stack on top of each other instead of next to each other */
@media screen and (min-width: 600px) {
  .nozoom {
    width: 230px;
  }
}
</style>
