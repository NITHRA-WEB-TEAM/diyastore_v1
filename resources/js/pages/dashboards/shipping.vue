<script setup>
import axios from '@axios'
import AppSearchHeaderBg from '@images/pages/app-search-header-bg1.png'

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
        Shipping
      </h5>


      <!--      <p class="mb-0">-->
      <!--        Common troubleshooting topics: eCommerce, Blogging to payment-->
      <!--      </p>-->
    </VCardText>
    <div class="py-12">
      <VCardText class="text-center py-6">
        <p class="text-justify">
          SHIPPING & DELIVERY Information We Strive to Deliver products ordered through diyastore.in in excellent
          condition wrapped up in Secure pack. Time to Shipping Payment made via online: 1 to 2 Working Days VPP or Cash
          on Delivery 5 to 7 Working Days Note: Working days mentioned above are excluding Saturdays, Sundays and
          Holidays.
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
