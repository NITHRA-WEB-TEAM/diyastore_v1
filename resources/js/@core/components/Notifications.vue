<script setup>
import {avatarText} from '@core/utils/formatters'

const props = defineProps({
  notifications: {
    type: Array,
    required: true,
  },
  badgeProps: {
    type: null,
    required: false,
    default: undefined,
  },
  location: {
    type: null,
    required: false,
    default: 'bottom end',
  },
  cartCount:{
    type: null
  }
})

const emit = defineEmits(['click:readAllNotifications'])
</script>

<template>
  <VBadge
    :model-value="!!props.badgeProps"
    v-bind="props.badgeProps"
  >
    <RouterLink :to="{ name: 'diya-wishList' }">
      <VBtn
        icon
        variant="text"
        color="error"
        size="small"
      >
        <VIcon
          icon="tabler-heart"
          size="24"
        />

      </VBtn>
    </RouterLink>
    <RouterLink :to="{ path: 'cart' }">
      <VBtn
        icon
        variant="text"
        color="default"
        size="small"
      >
        <VBadge
          :model-value="!!props.notifications.length"
          color="error"
          :content="cartCount"
        >
          <VIcon
            icon="tabler-shopping-cart"
            size="24"
          />
        </VBadge>
      </VBtn>
    </RouterLink>


  </VBadge>
</template>

<style lang="scss">
.notification-section {
  padding: 14px !important;
}
</style>
