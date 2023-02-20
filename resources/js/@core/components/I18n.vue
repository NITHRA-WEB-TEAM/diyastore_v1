<script setup>
const props = defineProps({
  languages: {
    type: Array,
    required: true,
  },
  location: {
    type: null,
    required: false,
    default: 'bottom end',
  },
})

const emit = defineEmits(['change'])

const {locale} = useI18n({useScope: 'global'})
</script>

<template>
  <VBtn
    icon
    variant="text"
    color="default"
    size="small"
  >
    <img alt src="https://d3c16wgne86swu.cloudfront.net/images/language%20icon/fr.png" class="img-fluid"
         style="width: 25px">
    <!--    <VIcon-->
    <!--      icon="tabler-language"-->
    <!--      size="24"-->
    <!--    />-->

    <!-- Menu -->
    <VMenu
      activator="parent"
      :location="props.location"
      offset="14px"
    >
      <!-- List -->
      <VList min-width="175px">
        <!-- List item -->
        <VListItem
          v-for="lang in props.languages"
          :key="lang.lang_id"
          :value="lang.lang_id"
          @click="locale = lang.lang_id; $emit('change', lang.lang_id)"
        >
          <!-- Language label -->
          <VListItemTitle><img alt :src="lang.lang_image" class="img-fluid"
                               style="width: 25px;margin: 0px 7px -7px 0px;">{{ lang.lname }}
          </VListItemTitle>
        </VListItem>
      </VList>
    </VMenu>
  </VBtn>
</template>
