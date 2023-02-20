<script setup>
// const stateList = [
// 'Alabama',
// 'Alaska',
// 'Arizona',
// 'Arkansas',
// 'California',
// 'Colorado',
// 'Connecticut',
// 'Delaware',
// 'Florida',
// 'Georgia',
// 'Hawaii',
// ]

const deliveryOption = ref('post')
const paymentType = ref('online')
const addressOption = ref(0)
const panel = ref(0)
const radioGroup = ref(1)


import ProceedToPay
  from '@/views/dashboards/diya/proceedToPay.vue'
import InvoiceAddAddressDrawer from '@/views/dashboards/diya/addAddressForm.vue'

const isAddAddressSidebarVisible = ref(false)

</script>

<template>
  <VRow class="">


    <VCol cols="12" md="8">
      <h4 class="text-h6 font-weight-medium mb-5">
        Address Section
      </h4>
      <VForm ref="placeOrderForm"
             @submit.prevent="() => { placeOrder() }">
        <VExpansionPanels v-model="panel">
          <!-- SECTION Delivery Address -->
          <VExpansionPanel>
            <VExpansionPanelTitle>Select Delivery Address</VExpansionPanelTitle>

            <VExpansionPanelText>

              <VRadioGroup
                v-model="addressOption"
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
                style="">+Add Address
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
                v-model="deliveryOption"
                class="delivery-options"
              >
                <div
                  class="delivery-option d-flex rounded-t"
                  :class="deliveryOption === 'post' ? 'active' : ''"
                  @click="deliveryOption = 'post'"
                >
                  <VRadio
                    inline
                    value="standard"
                    class="mt-n4"
                  />
                  <div class="w-100">
                    <div class="d-flex justify-space-between">
                      <h6 class="text-base font-weight-medium">
                        INDIA POST

                      </h6>
                    </div>
                  </div>
                </div>
                <div
                  class="delivery-option d-flex"
                  :class="deliveryOption === 'express' ? 'active' : ''"
                  @click="deliveryOption = 'express'"
                >
                  <VRadio
                    inline
                    class="mt-n4"
                    value="express"
                  />
                  <div class="w-100">
                    <div class="d-flex justify-space-between">
                      <h5 class="text-base font-weight-medium">
                        Professional Courier
                      </h5>
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
                v-model="paymentType"
                class="delivery-options"
              >
                <div
                  class="delivery-option d-flex rounded-t"
                  :class="paymentType === 'online' ? 'active' : ''"
                  @click="paymentType = 'online'"
                >
                  <VRadio
                    inline
                    value="online"
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
                  :class="paymentType === 'cod' ? 'active' : ''"
                  @click="paymentType = 'cod'"
                >
                  <VRadio
                    inline
                    class="mt-n4"
                    value="cod"
                  />
                  <div class="w-100">
                    <div class="d-flex justify-space-between">
                      <h5 class="text-base font-weight-medium">
                        CASH ON DELIVERY ( + ₹120 DELIVERY FEE )
                      </h5>
                      <h6 class="text-base font-weight-bold">
                        ₹120.00
                      </h6>
                    </div>
                    <span class="text-sm">Delivery time 5 - 7 working days.</span>
                  </div>
                </div>

              </VRadioGroup>

              <VDivider class="my-5"/>

              <!-- 👉 Place Order -->
              <div class="d-flex gap-4">
                <VBtn type="submit">Place Order</VBtn>
                <VBtn
                  color="secondary"
                  variant="tonal"
                >
                  Cancel
                </VBtn>
              </div>
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
      <ProceedToPay :ProductsList="ProductsList"/>

    </VCol>
  </VRow>
  <InvoiceAddAddressDrawer v-model:isDrawerOpen="isAddAddressSidebarVisible"/>

</template>

<style lang="scss">
</style>
<script>
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
      stateList: [],
      userAddress: [],
      categoryId: '',
      totalPrice: 0,
      totalDiscount: 0,
      addressOption: '',
      deliveryOption: '',
      paymentType: '',
      // id: $route.params.id
    }
  },
  async created() {
    this.userData = JSON.parse(localStorage.getItem("userData") || '[]')
    await axios.post('http://192.168.58.42:3000/api/site/action', {
      action: 'getUserAddress',
      userId: this.userData.id,
    })
      .then(result => {
        this.userAddress = result.data
        // console.log(JSON.parse(JSON.stringify(this.userAddress)))
        // console.log('here 12')
        // alert(this.categoryId)
      });

    if (localStorage.userData) {
      this.userData = JSON.parse(localStorage.getItem("userData") || '[]')
      await axios.post('http://192.168.58.42:3000/api/site/action', {
        action: 'getCartItem',
        lang_id: localStorage.lang_id,
        userId: this.userData.id,
      })
        .then(result => {
          this.ProductsList = result.data
          // console.log(JSON.parse(JSON.stringify(this.ProductsList)))
          // console.log('here 12')
          // alert(this.categoryId)
        });
    }
    await axios.post('http://192.168.58.42:3000/api/site/action', {
      action: 'getStateList',
    })
      .then(result => {
        this.stateList = result.data
        // console.log(JSON.parse(JSON.stringify(this.stateList)))
        // console.log('here 12')
        // alert(this.categoryId)
      });
  },
  methods: {
    getTotal() {
      const mulQty = this.ProductsList.filter(x => x.price).map(x => x.qty * x.price);
      const sumTotal = mulQty.reduce((partialSum, a) => partialSum + a, 0);
      return this.totalPrice = sumTotal
    },
    placeOrder() {
      alert('placeOrder')

      this.$refs.placeOrderForm.validate().then(async success => {
        // alert('placeOrderForm')
        if (success.valid) {
          alert('hello' + this.addressOption + 'hello')
          console.log(this.addressOption + '--' + this.deliveryOption + '--' + this.paymentType)
        }
      })
    },
    getDiscount() {
      const mulQtyDiscount = this.ProductsList.filter(x => x.discount_amt).map(x => x.qty * x.discount_amt);
      const sumDiscount = mulQtyDiscount.reduce((partialSum, a) => partialSum + a, 0);
      return this.totalDiscount = Math.ceil(sumDiscount)
    }
  }
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
