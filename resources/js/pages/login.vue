<script setup>
import {VForm} from 'vuetify/components'
import {useAppAbility} from '@/plugins/casl/useAppAbility'
import AuthProvider from '@/views/pages/authentication/AuthProvider.vue'
import {useGenerateImageVariant} from '@core/composable/useGenerateImageVariant'
import {VNodeRenderer} from '@layouts/components/VNodeRenderer'
import {themeConfig} from '@themeConfig'
import {
  emailValidator,
  lengthValidator,
  integerValidator,
  requiredValidator,
} from '@validators'
import authV2LoginIllustrationBorderedDark from '@images/pages/auth-v2-login-illustration-bordered-dark.png'
import authV2LoginIllustrationBorderedLight from '@images/pages/auth-v2-login-illustration-bordered-light.png'
import authV2LoginIllustrationDark from '@images/pages/auth-v2-login-illustration-dark.png'
import authV2LoginIllustrationLight from '@images/pages/auth-v2-login-illustration-light.png'
import authV2MaskDark from '@images/pages/misc-mask-dark.png'
import authV2MaskLight from '@images/pages/misc-mask-light.png'

import navItems from '@/navigation/horizontal'
import {useThemeConfig} from '@core/composable/useThemeConfig'
import {HorizontalNavLayout} from '@layouts'

const authThemeImg = useGenerateImageVariant(authV2LoginIllustrationLight, authV2LoginIllustrationDark, authV2LoginIllustrationBorderedLight, authV2LoginIllustrationBorderedDark, true)
const authThemeMask = useGenerateImageVariant(authV2MaskLight, authV2MaskDark)
const isPasswordVisible = ref(false)
const route = useRoute()
const router = useRouter()
const ability = useAppAbility()

const errors = ref({
  email: undefined,
  password: undefined,
})

const refVForm = ref()
// const email = ref('admin@demo.com')
const mobile = ref()
const otp = ref()
const password = ref('admin')
const rememberMe = ref(false)
// var showOtp = ref(false)
// var showContinue = ref(true)


// const onSubmit = () => {
//   refVForm.value?.validate().then(({valid: isValid}) => {
//     if (isValid)
//       login()
//   })
// }
const {appRouteTransition} = useThemeConfig()

</script>

<template>
  <VRow
    no-gutters
    class="auth-wrapper"
  >

    <VCol
      lg="3"
      class="d-none auth-bg  d-lg-flex"
    >

    </VCol>
    <VCol
      cols="12"
      lg="6"
      class="d-flex align-center auth-bg rounded-lg justify-center"
    >
      <VCard
        flat
        :max-width="700"
        class="mt-12 mt-sm-0 pa-4"
      >
        <VCardText>
          <VNodeRenderer
            :nodes="themeConfig.app.logo"
            class="mb-6"
          />

          <h5 class="text-h5 font-weight-semibold mb-1">
            Welcome to {{ themeConfig.app.title }}! 👋🏻
          </h5>
          <p class="mb-0">
            Please sign-in to your account and start the adventure
          </p>
        </VCardText>

        <VCardText>
          <VForm
            ref="refVForm"
            @submit.prevent="() => {  }"
          >
            <!--            @submit.prevent="onSubmit"-->
            <VRow>
              <!-- email -->
              <VCol cols="12">
                <VTextField
                  v-model="mobile"
                  label="Mobile"
                  type="mobile"
                  :rules="[requiredValidator, lengthValidator(mobile , 10)]"
                  :error-messages="errors.mobile"
                  class="mb-4"
                />
                <VBtn
                  block
                  type="button"
                  class=""
                  v-show="showContinue"
                  @click="enterOtpShow(mobile)"
                >
                  Continue
                </VBtn>
              </VCol>

              <!-- password -->
              <VCol cols="12" v-show="showOtp">
                <VTextField
                  v-model="otp"
                  label="OTP"
                  :rules="[requiredValidator, lengthValidator(otp , 4)]"
                  :error-messages="errors.otp"
                />

                <div class="d-flex align-center flex-wrap justify-space-between mt-2 mb-4">
                  <VCheckbox
                    v-model="rememberMe"
                    label="Remember me"
                  />
                  <RouterLink
                    class="text-primary ms-2 mb-1"
                    :to="{ name: 'forgot-password' }"
                  >
                    Forgot Password?
                  </RouterLink>
                </div>

                <VBtn
                  block
                  type="submit"
                  @click="login(otp, mobile)"
                >
                  Login
                </VBtn>
              </VCol>

              <!-- create account -->
              <VCol
                cols="12"
                class="text-center"
              >
                <span>New on our platform?</span>
                <RouterLink
                  class="text-primary ms-2"
                  :to="{ name: 'register' }"
                >
                  Create an account
                </RouterLink>
              </VCol>
              <VCol
                cols="12"
                class="d-flex align-center"
              >
                <VDivider/>
                <span class="mx-4">or</span>
                <VDivider/>
              </VCol>

              <!-- auth providers -->
              <VCol
                cols="12"
                class="text-center"
              >
                <AuthProvider/>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
    <VCol
      lg="3"
      class="d-none auth-bg  d-lg-flex"
    >
    </VCol>
  </VRow>

</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>

<route lang="yaml">
meta:
layout: blank
action: read
subject: Auth
redirectIfLoggedIn: true
</route>
<script>
import axios from "@axios";

export default {
  data() {
    return {
      showOtp: ref(false),
      showContinue: ref(true),
      otpDetail: [],
      userData: [],
      cartItem: [],
      userAbilities: [{"action":"manage","subject":"all"}],
      favouriteList: [],
      mobile: '',
      otp: '',
      route: useRoute(),
      router: useRouter()
    }
  },
  created() {
    // console.log(this.router)
    // console.log(JSON.parse(JSON.stringify(this.route)))
    if (localStorage.userData) {
      this.router.replace(this.route.query.to ? String(this.route.query.to) : '/')
    }

  },
  methods: {
    enterOtpShow(mobile) {
      if (mobile.length === 10) {
        this.showOtp = ref(true)
        this.showContinue = ref(false)
        // this.mobile = mobile

        axios.post('http://192.168.58.42:3000/api/site/action', {
          action: 'getOtp',
          mobile: mobile,
        }).then(result => {
          this.otpDetail = result.data
          // console.log(JSON.parse(JSON.stringify(this.otpDetail)))
          // this.otp = this.otpDetail['otp']
          alert(this.otpDetail['otp'])
        })
      } else {
        alert('Enter 10 digit Mobile Number')
      }

    },
    login(otp, mobile) {
      if (otp.length === 4) {
        axios.post('http://192.168.58.42:3000/api/site/action', {
          action: 'getUserData',
          mobile: mobile,
          otp: otp,
        }).then(async result => {
          this.userData = result.data
          console.log(JSON.parse(JSON.stringify(this.userData)))
          // this.otp = this.otpDetail['otp']
          if (this.userData['status'] === 'Success') {
            localStorage.setItem('userData', JSON.stringify(this.userData))
            localStorage.setItem('userAbilities', JSON.stringify(this.userAbilities))
            if (localStorage.cartItem) {
              this.cartItem = JSON.parse(localStorage.getItem("cartItem") || '[]')
              await axios.post('http://192.168.58.42:3000/api/site/action', {
                action: 'addToCart',
                userId: this.userData['id'],
                proArray: (JSON.stringify(this.cartItem)),
                mobile: mobile,
                fromApp: 'diyaStoreSite',
              })
                .then(result => {
                  // console.log(result.data)
                });
            }
            if (localStorage.favouriteList) {
              this.favouriteList = JSON.parse(localStorage.getItem("favouriteList") || '[]')
              await axios.post('http://192.168.58.42:3000/api/site/action', {
                action: 'addToFavourite',
                userId: this.userData['id'],
                proArray: JSON.stringify(this.favouriteList),
                mobile: mobile,
                fromApp: 'diyaStoreSite',
              })
                .then(result => {
                  // alert(this.categoryId)
                });
            }
            this.router.replace(this.route.query.to ? String(this.route.query.to) : '/')
          } else {
            alert('Incorrect OTP')
          }
        })

      } else {
        alert('Enter Valid OTP')
      }
      // axios.post('http://192.168.58.42:3000/api/site/action', {
      //   mobile: mobile.value,
      //   password: password.value,
      // }).then(r => {
      //   const {accessToken, userData, userAbilities} = r.data
      //
      //   localStorage.setItem('userAbilities', JSON.stringify(userAbilities))
      //   ability.update(userAbilities)
      //   localStorage.setItem('userData', JSON.stringify(userData))
      //   localStorage.setItem('accessToken', JSON.stringify(accessToken))
      //
      //   // Redirect to `to` query if exist or redirect to index route
      //   router.replace(route.query.to ? String(route.query.to) : '/')
      // }).catch(e => {
      //   const {errors: formErrors} = e.response.data
      //
      //   errors.value = formErrors
      //   console.error(e.response.data)
      // })
    }
  }
}
</script>
