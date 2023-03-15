<script setup>
import ProceedToPay
  from '@/views/diya/diya/proceedToPay.vue'
import InvoiceAddAddressDrawer from '@/views/diya/diya/addAddressForm.vue'
import {
  requiredValidator, integerValidator,
  lengthValidator
} from '@validators'

// const deliveryOption = ref('post')
// const paymentType = ref('online')
// const addressOption = ref(0)
const panel = ref(0)
const radioGroup = ref(0)
const isAddAddressSidebarVisible = ref(false)
</script>
<template>
  <div>
    <VRow>


      <VCol cols="12" md="8">
        <h4 class="text-h6 font-weight-medium mt-2 mb-5 text-center">
          Address Section
        </h4>

        <!--      {{PosatalMaster}}-->
        <VForm ref="placeOrderForm"
               @submit.prevent="() => { placeOrder() }">
          <VExpansionPanels v-model="panel" multiple>
            <!-- SECTION Delivery Address -->
            <VExpansionPanel>
              <VExpansionPanelTitle>Select Delivery Address</VExpansionPanelTitle>

              <VExpansionPanelText>

                <VRadioGroup
                  model-value="addressOption"
                  class="delivery-options"
                >
                  <div
                    v-for="(address, index) in userAddress"
                    class="delivery-option d-flex rounded-t"
                    :class="addressOption === index ? 'active' : ''"
                    @click="addressOption = index"
                  >
                    <VRadio
                      inline
                      :value="address.id"
                      class="mt-n4"
                    />
                    <div class="w-100">
                      <div class=" justify-space-between">
                        <h6 class="text-base font-weight-medium">
                          {{ address.name }}, {{ address.mobile }}
                        </h6>
                        <span class="text-base font-weight-regular">
                      {{ address.address }}
                    </span>
                        <h6 class="text-base font-weight-medium">
                          {{ address.statename }},
                          {{ address.pincode }},
                        </h6>
                      </div>
                    </div>
                  </div>

                </VRadioGroup>
                <VDivider class="my-5"/>
                <VBtn
                  @click="isAddAddressSidebarVisible = true"
                >+Add Address
                </VBtn>
              </VExpansionPanelText>
            </VExpansionPanel>
            <!-- !SECTION Delivery Address -->

            <!-- SECTION Delivery Options -->
            <VExpansionPanel>
              <VExpansionPanelTitle>Preferred Postal Method:</VExpansionPanelTitle>

              <VExpansionPanelText>
                <!-- 👉 Radio Group -->
                <VRadioGroup
                  model-value="postalOption"
                  class="delivery-options"
                  :rules="[requiredValidator]"
                >
                  <div
                    v-for="(postal, index) in PosatalMaster"
                    class="delivery-option d-flex rounded-t"
                    :class="postalOption === index ? 'active' : ''"
                    @click="postalOption = index"
                  >
                    <VRadio
                      inline
                      value="standard"
                      class="mt-n4"
                      :value="postal.id"
                    />
                    <div class="w-100">
                      <div class="d-flex justify-space-between">
                        <h6 class="text-base font-weight-medium">
                          {{ postal.postel_name }}
                        </h6>
                      </div>
                    </div>
                  </div>

                </VRadioGroup>
              </VExpansionPanelText>
            </VExpansionPanel>
            <VExpansionPanel>
              <VExpansionPanelTitle>Payment Type</VExpansionPanelTitle>

              <VExpansionPanelText>
                <!-- 👉 Radio Group -->
                <VRadioGroup
                  model-value="paymentType"
                  class="delivery-options"
                >
                  <div
                    class="delivery-option d-flex"
                    :class="this.paymentType === 'online' ? 'active' : ''"
                    @click="payment_type('online',0)"
                  >
                    <VRadio
                      inline
                      value="0"
                      class="mt-n4"
                    />
                    <div class="w-100">
                      <div class="d-flex justify-space-between">
                        <h6 class="text-base font-weight-medium">
                          ONLINE PAYMENT ( FREE DELIVERY )

                        </h6>
                        <h6 class="text-base font-weight-bold">
                          Free
                        </h6>
                      </div>
                      <span
                        class="text-sm">Payment Method : Debit / Credit / ATM Card / Net Banking / Other UPI Apps.</span><br>
                      <span class="text-sm">Delivery time 1 - 2 working days</span>
                    </div>
                  </div>
                  <div
                    class="delivery-option d-flex"
                    :class="this.paymentType === 'cod' ? 'active' : ''"
                    @click="payment_type('cod',1)"
                  >
                    <VRadio
                      inline
                      class="mt-n4"
                      value="1"
                    />
                    <div class="w-100">
                      <div class="d-flex justify-space-between">
                        <h5 class="text-base font-weight-medium">
                          CASH ON DELIVERY ( + ₹{{ CodShipAmnt }} DELIVERY FEE )
                        </h5>
                        <h6 class="text-base font-weight-bold">
                          ₹{{ CodShipAmnt }}
                        </h6>
                      </div>
                      <span class="text-sm">Delivery time 5 - 7 working days.</span>
                    </div>
                  </div>

                </VRadioGroup>
                <VDivider class="my-5"/>

                <!-- 👉 Place Order -->

                <VRow class="mt-2 mb-2">
                  <VBtn
                    class="text-xs-center mx-auto"
                    type="button"
                    @click="placeOrder"
                  >
                    <VIcon
                      class="me-2"
                      icon="tabler-message"
                      size="22"
                    />
                    Place Order
                  </VBtn>
                </VRow>

                <!--              <div class="mx-auto">-->
                <!--                <VBtn type="submit">Place Order</VBtn>-->
                <!--                <VBtn-->
                <!--                  color="secondary"-->
                <!--                  variant="tonal"-->
                <!--                >-->
                <!--                  Cancel-->
                <!--                </VBtn>-->
                <!--              </div>-->
              </VExpansionPanelText>
            </VExpansionPanel>
            <!-- !SECTION Delivery Options -->

          </VExpansionPanels>
        </VForm>
      </VCol>
      <VCol
        cols="12"
        md="3"
        style=""
      >

        <VCard class="mt-13">

          <!--        {{ProductsList}}-->
          <VCardText>
            <!-- 👉 Send Invoice Trigger button -->
            <span class="truncate-16">PRICE DETAILS</span>
            <VDivider/>
            <br>
            <p><span class="mb-4 mr-2">Price({{ ProductsList.length }} Items)</span><span class="ml-16 float-right">₹
          {{ getTotal() }}
          </span></p>
            <p><span class="mb-4 mr-16">Discount</span><span class="ml-16 float-right">₹ {{ getDiscount() }}</span></p>
            <template v-if="paymentTypeValue">
              <p><span class="mb-4 mr-16 text-sm">Shipping Amount</span><span class="float-right">₹ {{
                  CodShipAmnt
                }}</span></p>
            </template>
            <template v-else>
              <p><span class="mb-4 mr-16">Delivery Charges</span><span class=" float-right"
                                                                       style="color:#388e3c"
              >FREE</span></p>
            </template>


            <VDivider/>
            <p class="mt-4"><span class=" mr-12 font-weight-black ">Total Amount</span><span
              class="ml-8 font-weight-black float-right">₹ {{
                paymentTypeValue != '0' ? totalPrice - totalDiscount + CodShipAmnt : totalPrice - totalDiscount
              }}</span></p>
            <VDivider/>
            <br>
            <!-- 👉  Add Payment trigger button  -->
            <RouterLink :to="{ name: 'dashboards-addressCheck' }">
            </RouterLink>
          </VCardText>
        </VCard>
        <!--      <ProceedToPay :ProductsList="ProductsList"  :payType="paymentTypeValue"/>-->
      </VCol>
    </VRow>
    <InvoiceAddAddressDrawer v-model:isDrawerOpen="isAddAddressSidebarVisible"/>
  </div>
</template>

<style lang="scss">
</style>
<script>
import axios from "axios";

export default {
  inheritAttrs: false,
  data() {
    return {
      ProductsList: [],
      stateList: [],
      userAddress: [],
      PosatalMaster: [],
      categoryId: '',
      totalPrice: 0,
      CodShipAmnt: 0,
      onlineShipAmnt: 0,
      totalDiscount: 0,
      deliveryOption: 0,
      paymentType: 'online',
      postalModel: [],
      addressOption: 0,
      postalOption: 0,
      paymentTypeValue: 0,
      deliveryTypeValue: 1,
    }
  },
  async created() {
    this.userData = JSON.parse(localStorage.getItem("userData") || '[]')
    const getUserAddress = await this.callAxios(this.site_url, {
      'action': 'getUserAddress',
      'userId': this.userData.id
    }, 'post');
    this.userAddress = getUserAddress.data;

    const PosatalMaster = await this.callAxios(this.site_url, {'action': 'PosatalMaster'}, 'post');
    this.PosatalMaster = PosatalMaster.data;
    if (localStorage.userData) {
      this.userData = JSON.parse(localStorage.getItem("userData") || '[]')
      await axios.post(this.site_url, {
        action: 'getCartItem',
        lang_id: localStorage.lang_id,
        userId: this.userData.id,
      })
        .then(result => {
          this.ProductsList = result.data
          this.ShipingAmnt();
        });

    }
    const getStateList = await this.callAxios(this.site_url, {'action': 'getStateList'}, 'post');
    this.stateList = getStateList.data;
  },
  methods: {
    // PlaceOrder(){
    //   console.log(JSON.parse(JSON.stringify(this.userAddressModel)));
    // },
    getTotal() {
      const mulQty = this.ProductsList.filter(x => x.price).map(x => x.qty * x.price);
      const sumTotal = mulQty.reduce((partialSum, a) => partialSum + a, 0);
      return this.totalPrice = sumTotal
    },
    payment_type(type, value) {
      this.paymentTypeValue = value;
      this.paymentType = type;
      // console.log(this.paymentType)
    },
    async ShipingAmnt() {
      let Cod_Sum = this.ProductsList.map(x => x.weight * x.qty);
      const sum_ar = Cod_Sum.reduce((partialSum, a) => partialSum + a, 0)
      const DataShipingAmnt = await this.callAxios(this.site_url, {
        'action': 'ShipingCalAll',
        'weight': sum_ar
      }, 'post');
      this.CodShipAmnt = DataShipingAmnt.data.amount;
      // }
    },
    placeOrder() {
      if (this.userAddress.length != 0) {
        this.$refs.placeOrderForm.validate().then(async success => {
          if (success.valid) {
            const UserDataLogin = JSON.parse(localStorage.getItem("userData") || '[]')
            let Amount = this.paymentTypeValue != '0' ? this.totalPrice - this.totalDiscount + this.CodShipAmnt : this.totalPrice - this.totalDiscount
            let ProId = this.ProductsList.map(x => x.id);
            let paymentTypeValue = this.paymentTypeValue;
            let addressOption = this.userAddress[this.addressOption].id;
            let Mobile = this.userAddress[this.addressOption].mobile;
            let postalOption = this.PosatalMaster[this.postalOption].id;
            // console.log(this.addressOption + '--' + this.postalOption + '--' + this.paymentTypeValue)
            var options = {
              "key": "rzp_test_CvrmThFEnZgW1U", // Enter the Key ID generated from the Razorpay Setting -> API Keys
              // "key": "rzp_live_ao84FiwJF8Lthq", // Enter the Key ID generated from the Razorpay Setting -> API Keys
              "amount": Amount * 100, // Amount is in currency. Default currency is INR. Hence, 50000 refers to 50000 paise
              "currency": "INR",
              "handler": function (response) {
                axios.post("/payment/pay-check", {
                  'paytype': paymentTypeValue,
                  'addressID': addressOption,
                  'postalID': postalOption,
                  'payment_id': response.razorpay_payment_id,
                  'ProID': JSON.parse(JSON.stringify(ProId)),
                  'mobile': Mobile,
                  'login_mobile': UserDataLogin.mobileno,
                  'userId': UserDataLogin.id,
                })
                  .then(function (response1) {
                    console.log(response1);
                  })
                  .catch(function (error) {
                    // Show failed message
                  });
              },
            };
            var rzp = new Razorpay(options);
            rzp.open();
            rzp.on('payment.failed', function (response1) {

              axios.post("PAYMENT_FAILURE_API", {
                payment_id: response.payment_id,
                order_id: response.razorpay_order_id,
                code: response.error.code,
                description: response.error.description,
              })
                .then(function (response2) {
                  // Show failed message
                })
                .catch(function (error) {
                  // Show error message
                });
            });


          } else {
            this.sweetalert("error", "Validation error!", 'btn-success');
          }
        })
      } else {
        this.sweetalert("Error", "Please Add Address!", 'error');
      }
    },
    getDiscount() {
      const mulQtyDiscount = this.ProductsList.filter(x => x.discount_amt).map(x => x.qty * x.discount_amt);
      const sumDiscount = mulQtyDiscount.reduce((partialSum, a) => partialSum + a, 0);
      return this.totalDiscount = Math.ceil(sumDiscount)
    }
  },
}
</script>
<style lang="scss">
.delivery-options {
  .v-selection-control-group {
    inline-size: 100%;
  }
}

.delivery-option {
  padding: 1rem;
  border: 1px solid rgba(var(--v-border-color), var(--v-border-opacity));

  &.active {
    border-color: rgb(var(--v-theme-primary));
  }
}
</style>
