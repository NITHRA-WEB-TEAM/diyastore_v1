<script setup>
import axios from '@axios'
import AppSearchHeaderBg from '../../../../../full-version_test/resources/images/pages/app-search-header-bg1.png'

const authProviders = [
  {
    icon: 'fa-whatsapp',
    color: '#09b603',
    link: 'https://chat.whatsapp.com/I9KAG1UrcprH0OsJ9rLYk4',
  },
  {
    icon: 'fa-youtube',
    color: '#dd4b39',
    link: 'https://www.youtube.com/channel/UC6pMZ0G17bjEm3MVDAodYSA',
  },
  {
    icon: 'fa-facebook',
    color: '#4267b2',
    link: 'https://www.facebook.com/marketplace/you/selling',
  },
  {
    icon: 'fa-instagram',
    color: '#f33ebf',
    link: 'https://www.instagram.com/sridiyastores00/',
  },
  {
    icon: 'fa-telegram',
    color: '#1da1f2',
    link: 'https://t.me/joinchat/O3T_KTpEJqw3N2Q1',
  },
]
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
        Contact Us
      </h5>

    </VCardText>
    <div class="py-12">
      <VCardText class="text-center py-6">
        <h5 class="text-h5 text-center mb-6">
          For Further Queries Please Contact
        </h5>
        <p><span style="letter-spacing: 0.1px; color: black;">Write to Us at : <a
          href="mailto:nithra.solutions@gmail.com">nithra.solutions@gmail.com</a></span></p>
        <p>
          <span style="color: black;">1)<a
            href="tel:9360299668" style="text-decoration:none;color: black;">&nbsp;&nbsp;Andhra &amp; Telangana : 93602 99668</a></span><br>
          <span style="color: black;"> 2)
            <a href="tel:9597215816" style="text-decoration:none;color:black;">&nbsp;&nbsp;Tamil Nadu :&nbsp;</a>95972 15816</span><br>
          <span style="color: black;">
    3) </span><span style="color: black;">
          <a href="tel:8056601121"
             style="text-decoration:none;color: black;">&nbsp;&nbsp;Karnataka : 80566 01121</a></span>
          <br><span
          style="color: black;">
    4) </span>
          <span style="color: black;"><a href="tel:7568224311" style="text-decoration:none;color: black;">&nbsp;&nbsp;Hindi: 75682 24311</a></span>
        </p>
        <h5 class="text-h5 text-center mb-6">
          Join Us
        </h5>
        <!--        <div class="demo-space-x">-->
        <!--          <a href="https://chat.whatsapp.com/I9KAG1UrcprH0OsJ9rLYk4" target="_blank" style="color:#35a468;">-->
        <!--            <VIcon-->
        <!--              ref="tRefWhatsappBadge"-->
        <!--              size="25"-->
        <!--              variant="tonal"-->
        <!--              icon="tabler-brand-whatsapp"-->
        <!--              color="green"-->
        <!--            />-->
        <!--          </a>-->
        <!--          <a href="https://www.facebook.com/marketplace/you/selling" target="_blank" style="color:#e30101;">-->
        <!--            <VIcon-->
        <!--              ref="tRefTwitterBadge"-->
        <!--              size="25"-->
        <!--              icon="tabler-brand-youtube"-->
        <!--            />-->
        <!--          </a>-->
        <!--          <a href="https://www.facebook.com/marketplace/you/selling" target="_blank" style="color:blue;">-->
        <!--            <VIcon-->
        <!--              ref="tRefTwitterBadge"-->
        <!--              size="25"-->
        <!--              icon="tabler-brand-facebook"-->
        <!--            />-->
        <!--          </a>-->
        <!--          <a href="https://www.instagram.com/sridiyastores/" target="_blank" style="color:#ff4bd5;">-->
        <!--            <VIcon-->
        <!--              ref="tRefInstagramBadge"-->
        <!--              size="25"-->
        <!--              icon="tabler-brand-instagram"-->
        <!--            />-->
        <!--          </a>-->
        <!--          <a href="https://t.me/joinchat/O3T_KTpEJqw3N2Q1" target="_blank" style="color:#68a8f8;">-->
        <!--            <VIcon-->
        <!--              ref="tRefInstagramBadge"-->
        <!--              size="25"-->
        <!--              icon="tabler-brand-telegram"-->
        <!--            />-->
        <!--          </a>-->
        <!--        </div>-->
        <div class="d-flex justify-center flex-wrap gap-3">
          <a :href="link.link" v-for="link in authProviders" target="_blank">
            <VBtn
              :key="link.icon"
              icon
              variant="tonal"
              size="38"
              :color="link.color"
              class="rounded"
            >
              <VIcon
                size="18"
                :icon="link.icon"
              />
            </VBtn>
          </a>
        </div>


        <!--        <p>-->
        <!--          Our specialists are always happy to help. Contact us during standard business hours or email us-->
        <!--          <br>-->
        <!--          24/7 and we'll get back to you.-->
        <!--        </p>-->
        <!--        <div class="d-flex justify-center gap-4 flex-wrap">-->
        <!--          <VBtn>Visit our community</VBtn>-->
        <!--          <VBtn>Contact us</VBtn>-->
        <!--        </div>-->
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
export default{
  async created() {
    const ContactData = await this.callAxios(this.site_url, {'action':'ContactDetails'}, 'post');
    // console.log(ContactData)
  },
}
</script>
