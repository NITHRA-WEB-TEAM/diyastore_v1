<template>
  <div>

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
              <VBtn @click="Paytm" >
                Pay Order
              </VBtn>
            </center>
            </p>

          </VCardText>
        </div>
      </VCard>
    <CheckoutProvider :config="config" openInPopup="false" env='PROD'>
    </CheckoutProvider>

  </div>

</template>
<style>
.demo-space-x {
  display: block;
  align-items: center;
  margin-block-start: -16px;
}
</style>


<script>
import { CheckoutProvider, Checkout } from 'paytm-blink-checkout-vue'

import axios from '@axios'
import AppSearchHeaderBg from '../../../../../full-version_test/resources/images/pages/app-search-header-bg1.png'
export default {
  data(){
    return{
      newSite:'',
       config : {
        "root": "",
        "style": {
          "bodyColor": "",
          "themeBackgroundColor": "",
          "themeColor": "",
          "headerBackgroundColor": "",
          "headerColor": "",
          "errorColor": "",
          "successColor": ""
        },
        "flow": "DEFAULT",
        "data": {
          "orderId": "",
          "token": "",
          "tokenType": "TXN_TOKEN",
          "amount": "",
          "userDetail": {
            "mobileNumber": "",
            "name": ""
          }
        },
        "merchant": {
          "mid": "",
          "name": "",
          "redirect": true
        },
        "labels": {},
        "payMode": {
          "labels": {},
          "filter": [],
          "order": []
        },
        "handler": {}
      },
    }
  },
  methods :{
    async Paytm(){
      // alert('ssss')
      // const ContactData = await this.callAxios('/payment/make-payment',{"amount":1},'post');
      // this.newSite = ContactData.data;
      var config = {
        "root": "",
        "flow": "DEFAULT",
        "merchant":{
          "name":"XYZ Enterprises",
          "logo":"https://business.paytm.com/demo//static/images/merchant-logo.png?v=1.4"
        },
        "style":{
          "headerBackgroundColor":"#8dd8ff",
          "headerColor":"#3f3f40"
        },
        "data": {
          "orderId": '122',
          "token": "txnToken",
          "tokenType": "TXN_TOKEN",
          "amount": 1
        },
        "handler":{
          "notifyMerchant": function (eventName, data) {

            if(eventName == 'SESSION_EXPIRED'){
              alert("Your session has expired!!");
              location.reload();
            }
          }
        }
      };
      // window.Paytm.CheckoutJS.init(config);

      if (window.Paytm && window.Paytm.CheckoutJS) {
        // initialze configuration using init method
        window.Paytm.CheckoutJS.init(config).then(function onSuccess() {
          console.log('Before JS Checkout invoke');
          window.Paytm.CheckoutJS.invoke();
        }).catch(function onError(error) {
          console.log("Error => ", error);
        });
      }

    }
  },
}
</script>
