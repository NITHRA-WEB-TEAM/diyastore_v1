<script setup>
import {
  HorizontalNavGroup,
  HorizontalNavLink,
} from '@layouts/components'
import NavBarI18n from '@/layouts/components/NavBarI18n.vue'
import NavBarNotifications from '@/layouts/components/NavBarNotifications.vue'
import NavbarShortcuts from '@/layouts/components/NavbarShortcuts.vue'
import NavbarThemeSwitcher from '@/layouts/components/NavbarThemeSwitcher.vue'
import NavSearchBar from '@/layouts/components/NavSearchBar.vue'
import UserProfile from '@/layouts/components/UserProfile.vue'
import { useThemeConfig } from '@core/composable/useThemeConfig'
import { themeConfig } from '@themeConfig'
const { appRouteTransition } = useThemeConfig()
import { VNodeRenderer } from '@layouts/components/VNodeRenderer'
import diyaLogo from '../../../images/logos/diyaLogo.png'


const props = defineProps({
  navItems: {
    type: null,
    required: true,
  },
})

const resolveNavItemComponent = item => {
  if ('children' in item)
    return HorizontalNavGroup

  return HorizontalNavLink
}
</script>

<template>
  <ul class="nav-items">
    <RouterLink
      to="/"
      class="app-logo d-flex align-center gap-x-3"
    >
<!--      <VNodeRenderer :nodes="themeConfig.app.logo" />-->
      <img :src="diyaLogo" style="width: 165px">

      <h1 class="app-title font-weight-bold leading-normal text-xl">
<!--        {{ themeConfig.app.title }}-->
      </h1>
    </RouterLink>
    <Component
      :is="resolveNavItemComponent(item)"
      v-for="(item, index) in navItems"
      :key="index"
      :item="item"
    />
<!--    <div class="alert-demo-v-model-wrapper text-center" style="margin: 10px 0px 0px 550px" >-->
<!--      <VAlert-->
<!--        v-model="isAlertVisible"-->
<!--        color="warning"-->
<!--        variant="tonal"-->
<!--        height="30px"-->
<!--      >-->
<!--        Added to Cart-->
<!--      </VAlert>-->
<!--    </div>-->
    <VSpacer />

    <NavSearchBar trigger-btn-class="ms-lg-n3" />

    <NavBarI18n />
    <NavbarThemeSwitcher />
<!--    <NavbarShortcuts />-->
    <NavBarNotifications class="me-2" />
    <UserProfile />
  </ul>
</template>

<style lang="scss">
.layout-wrapper.layout-nav-type-horizontal {
  .nav-items {
    display: flex;
    flex-wrap: wrap;
  }
}
</style>
