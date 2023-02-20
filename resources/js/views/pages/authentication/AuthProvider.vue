<script setup>
const authProviders = [
  {
    icon: 'fa-whatsapp',
    color: '#09b603',
  },
  {
    icon: 'fa-youtube',
    color: '#dd4b39',
  },
  {
    icon: 'fa-facebook',
    color: '#4267b2',
  },
  {
    icon: 'fa-instagram',
    color: '#f33ebf',
  },
  {
    icon: 'fa-telegram',
    color: '#1da1f2',
  },
]
</script>

<template>
  <div class="d-flex justify-center flex-wrap gap-3">
    <VBtn
      v-for="link in authProviders"
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
  </div>
</template>
