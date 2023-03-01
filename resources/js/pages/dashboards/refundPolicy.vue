<script setup>
import axios from '@axios'
import AppSearchHeaderBg from '../../../../../full-version_test/resources/images/pages/app-search-header-bg1.png'

const apiData = ref()

// fetching data from the @fake-db
const fetchHelpCenterData = () => {
  return axios.get('/pages/help-center/landing').then(res => {
    apiData.value = res.data
  })
}

fetchHelpCenterData()
</script>

<template>
  <VCard
    flat
    class="text-center search-header rounded-0"

  >
    <VCardText :style="`background: url(${AppSearchHeaderBg});`">
      <h5 class="text-h5 font-weight-semibold">
        CANCELLATION AND REFUND POLICY
      </h5>


      <!--      <p class="mb-0">-->
      <!--        Common troubleshooting topics: eCommerce, Blogging to payment-->
      <!--      </p>-->
    </VCardText>
    <div class="py-12">
      <VCardText class="text-center py-6">
        <p class="text-justify">
          1. If the product is reached you in bad condition please inform us immediately over phone and send the picture
          to our whatsapp number (which is sent via SMS with your order id) and send the product to us within three
          days. Either we will send a new product or refund the amount paid for the particular product with the return
          courier/postal charges.
          2. Any of the order placed with diyastore.in will be subject to cancelation before shipping. Any cancelation
          request should reach us before the shipping of the products. If the order was cancelled before shipment the
          refund will be 100%. Any refund request will get processed with in a day of accepting the cancelation policy.
          We will usually refund any money received from you using the same method originally used by you to pay for
          your purchase. We will process the refund due to you as soon as possible and, in any event, within 10 days of
          the day we received your notice of cancellation.
          3. If we are unable to deliver because of wrong address, receiver unavailability then the responsibility is on
          the receiver side
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
