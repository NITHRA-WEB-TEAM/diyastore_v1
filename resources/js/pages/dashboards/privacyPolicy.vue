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
        Privacy Policy
      </h5>


      <!--      <p class="mb-0">-->
      <!--        Common troubleshooting topics: eCommerce, Blogging to payment-->
      <!--      </p>-->
    </VCardText>
    <div class="py-12">
      <VCardText class="text-center py-6">
        <p class="text-justify">
          This privacy policy sets out how “diyastore.in” uses and protects any information that you give diyastore.in
          when you use this website. “diyastore.in” is committed to ensure that your privacy is protected. If we ask you
          to provide certain information by which you can be identified when using this website, and you can be assured
          that it will only be used in accordance with this privacy statement. “diyastore.in” may change this policy
          from time to time by updating this page. You should check this page from time to time to ensure that you are
          happy with any changes. This policy is effective from [12/12/2020]. What we collect We may collect the
          following information: • name • contact information including email address • demographic information such as
          postcode, preferences and interests • other information relevant to customer surveys and/or offers • collects
          information on what pages are accessed or visited by consumers, as well as information volunteered by the
          consumer, such as survey information and/or site registrations What we do with the information we gather We
          require this information to understand your needs and provide you with a better service, and for the following
          reasons: • Internal record keeping. • We may use the information to improve our products and services. • We
          may periodically send promotional emails about new products, special offers or other information which we
          think you may find interesting using the email address which you have provided. • From time to time, we may
          also use your information to contact you for market research purposes. We may contact you by email, phone. We
          may use the information to customise the website according to your interests. Sri Diya Stores guarantees that
          if you supply your postal address on-line you will only be sent the information for which you provided your
          address but if you do not wish to receive e-mail from Sri Diya Stores in the future, or if you wish to be
          removed from mailing lists, please let us know by sending an e-mail to feedback@diyastore.in or click the
          unsubscribe link provided in the mail you received. Security We are committed to ensuring that your
          information is secure. In order to prevent unauthorised access or disclosure we have put in place suitable
          physical, electronic and managerial procedures to safeguard and secure the information we collect online. How
          we use cookies A cookie is a small file which asks permission to be placed on your computer’s hard drive. Once
          you agree, the file is added and the cookie helps analyse web traffic or lets you know when you visit a
          particular site. Cookies allow web applications to respond to you as an individual. The web application can
          tailor its operations to your needs, likes and dislikes by gathering and remembering information about your
          preferences. We use traffic log cookies to identify which pages are being used. This helps us analyse data
          about webpage traffic and improve our website in order to tailor it to customer needs. We only use this
          information for statistical analysis purposes and then the data is removed from the system. Overall, cookies
          help us provide you with a better website, by enabling us to monitor which pages you find useful and which you
          do not. A cookie in no way gives us access to your computer or any information about you, other than the data
          you choose to share with us. You can choose to accept or decline cookies. Most web browsers automatically
          accept cookies, but you can usually modify your browser setting to decline cookies if you prefer. This may
          prevent you from taking full advantage of the website. Links to other websites Our website may contain links
          to other websites of interest. However, once you have used these links to leave our site, you should note that
          we do not have any control over that other website. Therefore, we cannot be responsible for the protection and
          privacy of any information which you provide whilst visiting such sites and such sites are not governed by
          this privacy statement. You should exercise caution and look at the privacy statement applicable to the
          website in question. Controlling your personal information You may choose to restrict the collection or use of
          your personal information in the following ways: • whenever you are asked to fill in a form on the website,
          look for the box that you can click to indicate that you do not want the information to be used by anybody for
          direct marketing purposes • if you have previously agreed to us using your personal information for direct
          marketing purposes, you may change your mind at any time by writing to or emailing us at feedback@diyastore.in
          We will not sell, distribute or lease your personal information to third parties unless we have your
          permission or are required by law to do so. We may use your personal information to send you promotional
          information about third parties which we think you may find interesting if you tell us that you wish this to
          happen. If you believe that any information we are holding on you is incorrect or incomplete, please write to
          or email us as soon as possible, at the above address. We will promptly correct any information found to be
          incorrect.
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
