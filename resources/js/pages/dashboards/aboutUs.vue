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
        About Us
      </h5>


      <!--      <p class="mb-0">-->
      <!--        Common troubleshooting topics: eCommerce, Blogging to payment-->
      <!--      </p>-->
    </VCardText>
    <div class="py-12">
      <VCardText class="text-center py-6">
        <p class="text-justify">
          diyastore.in is an online portal of Sri Diya Stores, which is one-stop solution for all your pooja related
          religious items. Our product range includes rudraksha, items for offering deities, pooja utensils, puja
          clothes, vasthu items, Japa Maala, dhotis, etc. People Perform Pujas to offer devotional homage and prayer to
          deities, to spiritually celebrate an event. diyastore.in wants to make the prayer a more spiritual one by
          delivering quality products so that people will have a good spiritual experience. At Sri Diya Stores, we
          strive to serve our customers with the best product quality matched with the best service level giving them
          the high level of satisfaction and purchasing experience. Happy Living!
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
