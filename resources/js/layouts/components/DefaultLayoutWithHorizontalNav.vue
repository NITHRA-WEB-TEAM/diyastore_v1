<script setup>
import navItems from '@/navigation/horizontal'
import { useThemeConfig } from '@core/composable/useThemeConfig'
import { themeConfig } from '@themeConfig'

// Components
import Footer from '@/layouts/components/Footer.vue'
import NavBarI18n from '@/layouts/components/NavBarI18n.vue'
import NavBarNotifications from '@/layouts/components/NavBarNotifications.vue'
import NavbarShortcuts from '@/layouts/components/NavbarShortcuts.vue'
import NavbarThemeSwitcher from '@/layouts/components/NavbarThemeSwitcher.vue'
import NavSearchBar from '@/layouts/components/NavSearchBar.vue'
import UserProfile from '@/layouts/components/UserProfile.vue'
import { HorizontalNavLayout } from '@layouts'
import { VNodeRenderer } from '@layouts/components/VNodeRenderer'

const { appRouteTransition } = useThemeConfig()
</script>

<template>
  <div class="layout-horizontal-nav" style="background-color: orange">
    <div class="horizontal-nav-content-container">
  <VRow
    no-gutters
    class="auth-wrapper">
    <VCol
      md="3"
      class="d-none auth-bg d-lg-flex">
    </VCol>
    <VCol
      md="6"
      class="d-none auth-bg  d-lg-flex"
    >
      <v-carousel
        height="50"
        hide-delimiters

      >
        <v-carousel-item
        >
          <v-sheet
            height="100%"
            class="bg-light-secondary"
          >
            <div class="d-flex fill-height justify-center align-center">
              <h5 style="color: white;">
                For Telangana &amp; Andhra Pradesh : <a style="color: darkslateblue" href="tel:9360299668">93602 99668</a>
              </h5>
            </div>
          </v-sheet>
        </v-carousel-item>
        <v-carousel-item
        >
          <v-sheet
            height="100%"
            class="bg-light-secondary"
          >
            <div class="d-flex fill-height justify-center align-center">
              <h5 style="color: white">
                For Tamil Nadu : <a style="color: darkslateblue" href="tel:9597215816"> 95972 15816</a>
              </h5>
            </div>
          </v-sheet>
        </v-carousel-item>

        <v-carousel-item
        >
          <v-sheet
            height="100%"
            class="bg-light-secondary">
            <div class="d-flex fill-height justify-center align-center">
              <h5 style="color: white">
                For Hindi : <a style="color: darkslateblue" href="tel:7568224311">75682 24311</a>
              </h5>
            </div>
          </v-sheet>
        </v-carousel-item>
        <v-carousel-item
        >
          <v-sheet
            height="100%"
            class="bg-light-secondary">
            <div class="d-flex fill-height justify-center align-center">
              <h5 style="color: white">
                For Karnataka : <a style="color: darkslateblue" href="tel: 8056601121">80566 01121</a>
              </h5>
            </div>
          </v-sheet>
        </v-carousel-item>
      </v-carousel>
    </VCol>

    <VCol
      md="3"
      class="d-none auth-bg  d-lg-flex"
    >
    </VCol>
  </VRow>
      </div></div>

<!--  <div class="layout-horizontal-nav">-->
<!--    <div class="horizontal-nav-content-container">-->
<!--      <v-sheet-->
<!--        class="mx-auto"-->
<!--        max-width="400"-->
<!--        max-height="400"-->
<!--      >-->
<!--        <v-slide-group-->
<!--          show-arrows-->
<!--        >-->
<!--          <v-slide-group-item-->
<!--            v-slot="{ isSelected, toggle }"-->
<!--          >-->
<!--            <h5 class="ma-2"-->
<!--             style="padding-top: 10px;">-->
<!--              For Hindi: 75682 24311-->
<!--            </h5>-->
<!--            <h5 class="ma-2"-->
<!--                style="padding-top: 10px;">-->
<!--              For Telangana &amp; Andhra Pradesh : 93602 99668-->

<!--            </h5>-->
<!--            <h5 class="ma-2"-->
<!--                style="padding-top: 10px;">-->
<!--              For Tamil Nadu : 95972 15816-->

<!--            </h5>-->
<!--            <h5 class="ma-2"-->
<!--                style="padding-top: 10px;">-->
<!--              For Karnataka : 80566 01121-->

<!--            </h5>-->
<!--            <h5 class="ma-2"-->
<!--                style="padding-top: 10px;">-->
<!--              For Telangana &amp; Andhra Pradesh :93602 99668-->
<!--            </h5>-->
<!--          </v-slide-group-item>-->

<!--        </v-slide-group>-->

<!--      </v-sheet>-->
<!--    </div>-->
<!--  </div>-->

  <HorizontalNavLayout
    :nav-items="navItems"
  >
    <!-- 👉 navbar -->
    <template >
<!--      <RouterLink-->
<!--        to="/"-->
<!--        class="app-logo d-flex align-center gap-x-3"-->
<!--      >-->
<!--        <VNodeRenderer :nodes="themeConfig.app.logo" />-->

<!--        <h1 class="app-title font-weight-bold leading-normal text-xl">-->
<!--          {{ themeConfig.app.title }}-->
<!--        </h1>-->
<!--      </RouterLink>-->
<!--      <VSpacer />-->

<!--      <NavSearchBar trigger-btn-class="ms-lg-n3" />-->

<!--      <NavBarI18n />-->
<!--      <NavbarThemeSwitcher />-->
<!--      <NavbarShortcuts />-->
<!--      <NavBarNotifications class="me-2" />-->
<!--      <UserProfile />-->
    </template>

    <!-- 👉 Pages -->
    <RouterView v-slot="{ Component, route }">
      <Transition
        :name="appRouteTransition"
        mode="out-in"
      >
        <Component
          :is="Component"
          :key="route.path"
        />
      </Transition>
    </RouterView>

    <!-- 👉 Footer -->
    <template #footer>
      <Footer />
    </template>

    <!-- 👉 Customizer -->
    <TheCustomizer />
  </HorizontalNavLayout>
</template>

