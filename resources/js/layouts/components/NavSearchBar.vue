<script setup>
import axios from '@axios'
import { useThemeConfig } from '@core/composable/useThemeConfig'

const { appContentLayoutNav } = useThemeConfig()
// 👉 Is App Search Bar Visible
const isAppSearchBarVisible = ref(false)

// 👉 Default suggestions
const suggestionGroups = [
  {
    title: 'PAGES',
    content: [
      {
        icon: 'tabler-chart-donut',
        title: 'Home',
        url: { name: 'diya-home' },
      },
      {
        icon: 'tabler-chart-bubble',
        title: 'Product Category',
        url: { name: 'diya-category' },
      },
      {
        icon: 'tabler-file',
        title: 'My Orders',
        url: { name: 'diya-myorders' },
      },

      {
        icon: 'tabler-shopping-cart',
        title: 'My Cart',
        url: { name: 'diya-cart' },
      },
    ],
  },



]

// 👉 No Data suggestion
const noDataSuggestions = [
  {
    title: 'My Cart',
    icon: 'tabler-shopping-cart',
    url: { name: 'diya-cart' },
  },
  {
    icon: 'tabler-chart-donut',
    title: 'Home',
    url: { name: 'diya-home' },
  },
  {
    icon: 'tabler-chart-bubble',
    title: 'Product Category',
    url: { name: 'diya-category' },
  },
]

const searchQuery = ref('')
const searchResult = ref([])
const router = useRouter()

// 👉 fetch search result API
watchEffect(() => {
  axios.get('/app-bar/search', { params: { q: searchQuery.value } }).then(response => {
    searchResult.value = response.data
  })
})

const redirectToSuggestedOrSearchedPage = selected => {
  router.push(selected.url)
  isAppSearchBarVisible.value = false
  searchQuery.value = ''
}

const LazyAppBarSearch = defineAsyncComponent(() => import('@core/components/AppBarSearch.vue'))
</script>

<template>
  <div
    class="d-flex align-center cursor-pointer"
    v-bind="$attrs"
    @click="isAppSearchBarVisible = !isAppSearchBarVisible"
  >
    <!-- 👉 Search Trigger button -->
    <VBtn
      icon
      variant="text"
      color="default"
      size="small"
    >
      <VIcon
        icon="tabler-search"
        size="24"
      />
    </VBtn>

    <span
      v-if="appContentLayoutNav === 'vertical'"
      class="d-none d-md-flex align-center text-disabled"
    >
      <span class="me-3">Search</span>
      <span class="meta-key">&#8984;K</span>
    </span>
  </div>

  <!-- 👉 App Bar Search -->
  <LazyAppBarSearch
    v-model:isDialogVisible="isAppSearchBarVisible"
    v-model:search-query="searchQuery"
    :search-results="searchResult"
    :suggestions="suggestionGroups"
    :no-data-suggestion="noDataSuggestions"
    @item-selected="redirectToSuggestedOrSearchedPage"
  >
    <!--
      <template #suggestions>
      use this slot if you want to override default suggestions
      </template>
    -->

    <!--
      <template #noData>
      use this slot to change the view of no data section
      </template>
    -->

    <!--
      <template #searchResult="{ item }">
      use this slot to change the search item
      </template>
    -->
  </LazyAppBarSearch>
</template>

<style lang="scss" scoped>
@use "@styles/variables/_vuetify.scss";

.meta-key {
  border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: vuetify.$card-border-radius;
  block-size: 1.5625rem;
  line-height: 1.3125rem;
  padding-block: 0.125rem;
  padding-inline: 0.25rem;
}
</style>
