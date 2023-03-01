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
        TERMS & CONDITIONS
      </h5>


      <!--      <p class="mb-0">-->
      <!--        Common troubleshooting topics: eCommerce, Blogging to payment-->
      <!--      </p>-->
    </VCardText>
    <div class="py-12">
      <VCardText class="text-center py-6">
        <p class="text-justify">
          Your use of this website constitutes acceptance by you of the following Terms of Use: Copyright and Trademarks
          This Site is owned and operated by Sri Diya Stores, and the information and materials appearing on the Site
          (‘the Content’) are displayed for personal, non-commercial use only. All software used on this Site and all
          Content included on this Site (including without limitation Site design, text, graphics, audio and video and
          the selection and arrangement thereof) is the property of Sri Diya Stores., or its suppliers and is protected
          by international copyright laws. None of the Material may be downloaded, copied, reproduced, republished,
          posted, transmitted, stored, sold or distributed without the prior written permission of the copyright holder.
          This excludes the material specifically made available for ‘downloads’ and sharing on social media on any
          single computer for personal, non-commercial home use only, provided that all copyright and proprietary
          notices are kept intact. Modification of any of the Material or use of any of the Material for any purpose
          other than as set out herein (including without limitation on any other website or computer network) is
          prohibited. Requests to use any form of our products published by Sri Diya Stores should be send to our email
          at feedback@diyastore.in Payment & Chargeback Disclaimer You hereby expressly agree that once you or any other
          person have started the process of payment of subscription by expressly without reservation agreeing to the
          terms and conditions of the site by clicking and accepting them and have further submitted your credit card/
          any other card details or other details to the site/internet banking service provider for payment and your
          account gets debited no chargeback claim or dispute with regard to the failure of delivery of Product or the
          use/misuse of such credit card or any other card, or internet banking filed by you/on your behalf with the
          Credit Card Provider/Internet banking service provider or any Bank/Financial Institution or Court /Tribunal
          /Ombudsman shall be binding on Sri Diya Stores or its Merchant Bank or any company which maintains Sri Diya
          Stores servers thereby giving connectivity to internet banking service provider(s). You accept and take full
          responsibility towards the ownership/possession and use of your credit card or any other card or your internet
          banking password or access. This understanding that you will have no right to claim any charge back is a
          material condition of this agreement and once you hereby expressly agree to it you shall be stopped from
          challenging /disputing it in any adjudication/proceeding before any Bank/Financial institution/ Internet
          banking service provider or Court or Tribunal or Ombudsman or otherwise. Warranties We warrant to you that any
          product you purchase through the site will be of satisfactory quality. You warrant to us that: you have full
          authority, power and capacity to enter into this agreement and that all necessary actions have been taken to
          enable you to lawfully enter into this Agreement; you are legally capable of entering into binding contracts;
          the information provided in the order is accurate; and you will be able to accept delivery of the products as
          contemplated in this agreement. Subject to the warranties set out in above, to the maximum extent permitted by
          applicable law we disclaim all warranties with respect to the products, whether express or implied.
          Limitations of liability The Site is provided by Sri Diya Stores in good faith but Sri Diya Stores does not
          make any representations or warranties of any kind, express or implied, in relation to all or any part of the
          Site or the Content or any websites to which the Site is linked, and all warranties and representations are
          hereby excluded to the extent permitted by law. The contents of the Site do not constitute advice and should
          not be relied upon in making, or refraining from making, any decision. There is no guarantee that the Site
          will be free of infection by viruses or anything else which may be harmful or destructive. To the extent
          permitted by law, Sri Diya Stores hereby disclaims all liability (howsoever arising) in connection with any
          loss and/or damage, arising out of or in connection with any use of, or inability to use, all or any part of
          the Content, the Site and/or any website to which the Site is linked, or any action taken (or refrained from
          being taken) as a result of using any of these. Price and Availability of Titles Whilst every effort is made
          to ensure accuracy of prices and availability of the titles featured on this Site, this cannot be guaranteed
          and price and availability information may change without notice. Changes to these conditions of use Sri Diya
          Stores reserves the right to add to or change these conditions of use and agrees to ensure that a note of the
          date and clause number of any such amendments will be included as part of the conditions. Any changes will be
          posted to this page and it is your responsibility as a user to ensure that you are aware of any such changes
          from time to time. Changes will become effective 24 hours after first posting and you will be deemed to have
          accepted any change if you continue to access the Site after that time. By this you are also agreeing that you
          read privacy policy, Delivery and Shipping Information & Cancellation and Refund Policy
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
