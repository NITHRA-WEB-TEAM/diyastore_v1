<template>
  <VCard
    flat
    class="text-center search-header rounded-0"

  >
    <VCardText :style="`background: url(${AppSearchHeaderBg});`">
      <h5 class="text-h5 font-weight-semibold">
      checkout page
      </h5>
    </VCardText>
    <div class="py-12">
      <VCardText class="text-center py-6">
        <p class="text-justify">
        <center>
            <VBtn @click="loadRazorPay" >
             Pay Order
            </VBtn>
      </center>
        </p>

      </VCardText>
    </div>
  </VCard>
</template>
<style>
.demo-space-x {
  display: block;
  align-items: center;
  margin-block-start: -16px;
}
</style>


<script>
import axios from '@axios'
// const Razorpay = require('razorpay');
// import Razorpay from 'razorpay'
import AppSearchHeaderBg from '@images/pages/app-search-header-bg1.png'
import { onMounted } from "vue"
export default {
  data(){
    return{
      script: `https://checkout.razorpay.com/v1/checkout.js`
    }
  },
  methods :{
    async loadRazorPay(){
      var options = {
        "key": "rzp_test_CvrmThFEnZgW1U", // Enter the Key ID generated from the Razorpay Setting -> API Keys
        "amount": 8*100, // Amount is in currency. Default currency is INR. Hence, 50000 refers to 50000 paise
        "currency": "INR",
        "orderid":540,
        "handler": function (response){
          axios.post("/payment/pay-check", {
            'payment_id':response.razorpay_payment_id,
            'orderid':540,
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
      rzp.on('payment.failed', function (response1){
        // console.log(response1)
        // axios.post("PAYMENT_FAILURE_API", {
        //   payment_id: response.payment_id,
        //   order_id: response.razorpay_order_id,
        //   code: response.error.code,
        //   description: response.error.description,
        // })
        //   .then(function (response2) {
        //     // Show failed message
        //   })
        //   .catch(function (error) {
        //     // Show error message
        //   });
      });
    }
  },
}
</script>
