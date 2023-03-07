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
// const interval = ref()
const refVForm = ref()

// const email = ref('admin@demo.com')
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
  <div>
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
      md="6"
    >
      <VCard
        flat

        class="mt-12 mt-sm-0 pa-4"
      >
        <VCardText>


          <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
            <b-img
              fluid
              :src="imgUrl"
              alt="Login V2"
            />
          </div>

          <VNodeRenderer
            :nodes="themeConfig.app.logo"
            class="mb-6"
          />

          <h5 class="text-h5 font-weight-semibold mb-1">
            Welcome to {{ themeConfig.app.title }}! 👋🏻
          </h5>

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
                  type="text"
                  @keypress="onlyNumber($event)"
                  maxlength="10"
                  :rules="[requiredValidator, lengthValidator(mobile , 10)]"
                  :error-messages="errors.mobile"
                  class="mb-4"
                />


              </VCol>
            </VRow>
            <VRow>
              <VBtn
                class="text-xs-center mx-auto"
                type="button"
                v-show="showContinue"
                @click="enterOtpShow(mobile)"
              >
                <VIcon
                  class="me-2"
                  icon="tabler-message"
                  size="22"
                />

                Send OTP
              </VBtn>
  </VRow>

  <!--              </v-flex>-->
              <!-- password -->
              <div v-show="showOtp">
                <VRow>
                <VCol cols="12">
                <VTextField
                  v-model="otp"
                  label="OTP"
                  @keypress="onlyNumber($event)"
                  type="text"
                  maxlength="4"
                  :rules="[requiredValidator, lengthValidator(otp , 4)]"
                  :error-messages="errors.otp"
                />
              </VCol>
                </VRow>
<!--                <v-row>-->
<!--                  <v-col sm="6">-->
<!--                    <VBtn-->
<!--                      class="mx-auto"-->
<!--                      type="submit"-->
<!--                      @click="login(otp, mobile)"-->
<!--                    >-->
<!--                      Verify OTP-->
<!--                    </VBtn>-->
<!--                  </v-col>-->
<!--                  <v-col  sm="6">-->
<!--                    <VBtn-->
<!--                      color="success"-->
<!--                      type="submit"-->
<!--                      @click="login(otp, mobile)"-->
<!--                    >-->
<!--                      Resend OTP-->
<!--                    </VBtn>-->
<!--                  </v-col>-->
<!--                  <v-col  sm="6">-->
<!--                    <VBtn-->
<!--                      color="info"-->
<!--                      type="submit"-->
<!--                      @click="login(otp, mobile)"-->
<!--                    >-->
<!--                      Mobile Number Change-->
<!--                    </VBtn>-->
<!--                  </v-col>-->
<!--                </v-row>-->
                <div class="mt-2 mb-2 text-center" v-show="OtpTimer">
                  <v-progress-circular
                    :rotate="360"
                    :size="100"
                    :width="15"
                    :model-value="progressValue"
                    color="teal"
                  >
                    {{ progressValue }}
                  </v-progress-circular>
                </div>
                <div class="mt-5 text-center" >
                  <VBtn
                    class="text-center mt-1 ml-1"
                    type="submit"
                    @click="(login(otp, mobile))"
                  >
                    <VIcon
                      class="me-2"
                      icon="tabler-logout"
                      size="22"
                    />
                     Verify OTP
                  </VBtn>
                  <VBtn
                    v-show="RecentOtp"
                    class="text-center mt-1 ml-1"
                    color="success"
                    type="submit"
                    @click="(enterOtpShow(mobile),this.RecentOtp=false)"
                  >
                    <VIcon
                      class="me-2"
                      icon="tabler-reload"
                      size="22"
                    />
                    Resend OTP
                  </VBtn>

                  <VBtn
                    class="text-xs-center mt-1 ml-1"
                    color="info"
                    type="submit"
                    @click="mobileNum()"
                  >
                    <VIcon
                      class="me-2"
                      icon="tabler-edit"
                      size="22"
                    />
                    Mobile Number Change
                  </VBtn>
                </div>
              </div>



              <!-- create account -->
              <!--              <VCol-->
              <!--                cols="12"-->
              <!--                class="text-center"-->
              <!--              >-->
              <!--                <span>New on our platform?</span>-->
              <!--                <RouterLink-->
              <!--                  class="text-primary ms-2"-->
              <!--                  :to="{ name: 'register' }"-->
              <!--                >-->
              <!--                  Create an account-->
              <!--                </RouterLink>-->
              <!--              </VCol>-->
              <!--              <VCol-->
              <!--                cols="12"-->
              <!--                class="d-flex align-center"-->
              <!--              >-->
              <!--                <VDivider/>-->
              <!--                <span class="mx-4">or</span>-->
              <!--                <VDivider/>-->
              <!--              </VCol>-->

              <!-- auth providers -->
              <!--              <VCol-->
              <!--                cols="12"-->
              <!--                class="text-center"-->
              <!--              >-->
              <!--                <AuthProvider/>-->
              <!--              </VCol>-->

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

  <VSnackbar
    v-model="isSnackbar"
    transition="scroll-y-reverse-transition"
    location="top end"
    color="warning"
  >
    {{TitleSnack}}
    <template #actions>
      <VBtn
        color="white"
        @click="isSnackbar = false"
        max-width="500px"
      >
        <VIcon
          icon="tabler-x"
          size="20"
        />
      </VBtn>
    </template>
  </VSnackbar>
  </div>
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
      interval: '',
      TitleSnack:'',
      OtpTimer:false,
      otp:'',
      userData: [],
      RecentOtp:false,
      isSnackbar:false,
      cartItem: [],
      progressValue: 100,
      userAbilities: [{"action": "manage", "subject": "all"}],
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
    mobileNum(){
      this.showOtp= this.OtpTimer = false;
      this.showContinue =true;
      this.progressValue=100;
      this.otp='';
    },
    enterOtpShow(mobile) {
      if (this.mobile.length === 10) {
        this.progressValue=100
        this.showOtp = ref(true)
        this.OtpTimer = true
        this.showContinue = ref(false)
        // this.mobile = mobile
        axios.post(this.site_url, {
          action: 'getOtp',
          mobile: mobile,
        }).then(result => {
          this.otpDetail = result.data
          this.interval = setInterval(() => {
            if (this.progressValue === 0) {
              return (this.RecentOtp = true,this.OtpTimer = false);
            }
            this.progressValue -= 1
          }, 1000)
          // alert(this.otpDetail['otp'])
        })
      } else {
        this.isSnackbar=true;
        this.TitleSnack = 'Enter 10 digit Mobile Number';
      }

    },
    onlyNumber($event) {
      //console.log($event.keyCode); //keyCodes value
      let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
      if ((keyCode < 48 || keyCode > 57)) { // 46 is dot
        $event.preventDefault();
      }
    },
    login(otp, mobile) {
      // console.log(otp);
      // return 2;
      if (this.otp.length === 4) {
        axios.post(this.site_url, {
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
              await axios.post(this.site_url, {
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
              await axios.post(this.site_url, {
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
            this.isSnackbar=true
            this.TitleSnack = 'Incorrect OTP';
          }
        })
      }
    }
  }
}
</script>
