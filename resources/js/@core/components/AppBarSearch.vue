<script setup>
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import {
  VList,
  VListItem,
  VListSubheader,
} from 'vuetify/components'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  searchQuery: {
    type: String,
    required: true,
  },
  searchResults: {
    type: Array,
    required: true,
  },
  suggestions: {
    type: Array,
    required: false,
  },
  noDataSuggestion: {
    type: Array,
    required: false,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'update:searchQuery',
  'itemSelected',
])

const { ctrl_k, meta_k } = useMagicKeys()
const refSearchList = ref()
const searchQuery = ref(structuredClone(toRaw(props.searchQuery)))
const refSearchInput = ref()
const isLocalDialogVisible = ref(structuredClone(toRaw(props.isDialogVisible)))
const searchResults = ref(structuredClone(toRaw(props.searchResults)))

// 👉 Watching props change
watch(props, () => {
  isLocalDialogVisible.value = structuredClone(toRaw(props.isDialogVisible))
  searchResults.value = structuredClone(toRaw(props.searchResults))
  searchQuery.value = structuredClone(toRaw(props.searchQuery))
})
watch([
  ctrl_k,
  meta_k,
], () => {
  isLocalDialogVisible.value = true
  emit('update:isDialogVisible', true)
})

// 👉 clear search result and close the dialog
const clearSearchAndCloseDialog = () => {
  emit('update:isDialogVisible', false)
  emit('update:searchQuery', '')
  emit('update:Searchdata', [])
  // this.searchQuery=[];


  // this.Searchdata=[];
}

watchEffect(() => {
  if (!searchQuery.value.length)
    searchResults.value = []
})

// const getFocusOnSearchList = e => {
  // if (e.key === 'ArrowDown') {
  //   e.preventDefault()
  //   refSearchList.value?.focus('next')
  // } else if (e.key === 'ArrowUp') {
  //   e.preventDefault()
  //   refSearchList.value?.focus('prev')
  // }
// }

const dialogModelValueUpdate = val => {
  emit('update:isDialogVisible', val)
  emit('update:searchQuery', '')
}

const resolveCategories = val => {
  if (val === 'dashboards')
    return 'Dashboards'
  if (val === 'appsPages')
    return 'Apps & Pages'
  if (val === 'userInterface')
    return 'User Interface'
  if (val === 'formsTables')
    return 'Forms Tables'
  if (val === 'chartsMisc')
    return 'Charts Misc'
  
  return 'Misc'
}
</script>

<template>
  <VDialog
    max-width="600"
    :model-value="isLocalDialogVisible"
    :height="$vuetify.display.smAndUp ? '550' : '100%'"
    :fullscreen="$vuetify.display.width < 600"
    class="app-bar-search-dialog"
    @update:model-value="dialogModelValueUpdate"
    @keyup.esc="clearSearchAndCloseDialog"
  >

    <VCard
      height="100%"
      width="100%"
      class="position-relative"
    >
      <VCardText
        class="pt-1"
        style="max-height: 65px;"
      >
        <!-- 👉 Search Input -->
         <VTextField
          ref="refSearchInput"
          v-model="searchQuery"
          autofocus
          variant="plain"
          density="comfortable"
          class="app-bar-autocomplete-box"
          @keyup.esc="clearSearchAndCloseDialog"
          @keyup="getFocusOnSearchList"
          @update:model-value="$emit('update:searchQuery', searchQuery)"

        >
          <!-- 👉 Prepend Inner -->
          <template #prepend-inner>
            <VBtn
              icon
              variant="text"
              color="default"
              size="x-small"
              class="text-high-emphasis ms-n1"
            >
              <VIcon
                size="22"
                icon="tabler-search"
              />
            </VBtn>
          </template>

          <!-- 👉 Append Inner -->
          <template #append-inner>
            <div class="d-flex align-center">
              <div
                class="text-base text-disabled cursor-pointer me-2"
                @click="clearSearchAndCloseDialog"
              >
                [esc]
              </div>

              <VBtn
                icon
                variant="text"
                color="default"
                size="x-small"
                @click="clearSearchAndCloseDialog"
              >
                <VIcon
                  size="22"
                  icon="tabler-x"
                />
              </VBtn>
            </div>
          </template>
        </VTextField>
      </VCardText>

      <!-- 👉 Divider -->
      <VDivider />

      <!-- 👉 Perfect Scrollbar -->


      <PerfectScrollbar
        :options="{ wheelPropagation: false, suppressScrollX: true }"
        class="h-100"
      >
        <!-- 👉 Search List -->
        <VList
          ref="refSearchList"
          density="compact"
          class="app-bar-search-list"
        >

          <!-- 👉 list Item /List Sub header -->
          <template
            v-for="item in Searchdata">
                  <template>
                    <VIcon
                      size="20"
                      icon="tabler-corner-down-left"
                      class="enter-icon text-disabled"
                    />
                  </template>
                  <VListItemTitle>
                    <RouterLink :to="{ name: 'diya-Search_product', query: { search: item }}" @click="clearSearchAndCloseDialog">&nbsp;
                      &nbsp;&nbsp;
                      &nbsp;
                      {{ item }}  </RouterLink>

                  </VListItemTitle>
          </template>
        </VList>

        <!-- 👉 Suggestions -->
        <div
          v-show="!!searchResults && !searchQuery"
          class="h-100"
        >
          <slot name="suggestions">
            <VCardText class="app-bar-search-suggestions h-100 pa-10">
              <VRow
                v-if="props.suggestions"
                class="gap-y-4"
              >
                <VCol
                  v-for="suggestion in props.suggestions"
                  :key="suggestion.title"
                  cols="12"
                  sm="6"
                  class="ps-6"
                >
                  <p class="text-xs text-disabled text-uppercase">
                    {{ suggestion.title }}
                  </p>

                  <VList class="card-list">
                    <VListItem
                      v-for="item in suggestion.content"
                      :key="item.title"
                      link
                      :title="item.title"
                      class="app-bar-search-suggestion"
                      @click="$emit('itemSelected', item)"
                    >
                      <template #prepend>
                        <VIcon
                          :icon="item.icon"
                          size="20"
                          class="me-2"
                        />
                      </template>
                    </VListItem>
                  </VList>
                </VCol>
              </VRow>
            </VCardText>
          </slot>
        </div>

        <!-- 👉 No Data found -->
        <div

          v-show="!Searchdata.length && searchQuery.length"
          class="h-100"
        >
          <slot name="noData">
            <VCardText class="h-100">
              <div class="app-bar-search-suggestions d-flex flex-column align-center justify-center text-high-emphasis h-100">
                <VIcon
                  size="75"
                  icon="tabler-file-x"
                />
                <h6 class="text-h6 my-3">
                  No Result For "{{ searchQuery }}"
                </h6>
                <div
                  v-if="props.noDataSuggestion"
                  class="mt-8"
                >
                  <span class="d-flex justify-center text-disabled">Try searching for</span>
                  <h6
                    v-for="suggestion in props.noDataSuggestion"
                    :key="suggestion.title"
                    class="app-bar-search-suggestion text-sm font-weight-regular cursor-pointer mt-3"
                    @click="$emit('itemSelected', suggestion)"
                  >
                    <VIcon
                      size="20"
                      :icon="suggestion.icon"
                      class="me-3"
                    />
                    <span class="text-sm">{{ suggestion.title }}</span>
                  </h6>
                </div>
              </div>
            </VCardText>
          </slot>
        </div>
      </PerfectScrollbar>
    </VCard>
  </VDialog>
</template>
<script>
import axios from "axios";

const isSnackbarScrollReverseVisible = ref(false)

import {createVuetify} from 'vuetify'
import {aliases, mdi} from 'vuetify/iconsets/mdi'
// const route = useRoute()
export default {
  setup() {
    // alert('check')
  },
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    }
  },

  inheritAttrs: false,
  data() {
    return {
      getSingleData: [],
      ProductsList: [],
      relatedProduct: [],
      Searchdata:[],
      dataAvailable: 1,
      imageSrc: '',
      categoryId: '',
      list:[],
      number: 1,
      userData1: [{"id": ''}],
// id: $route.params.id
    }
  },
  async created() {
    // console.log(this.$route)
    if (this.$route.query.id) {

    }

  },
  methods: {

    // clearSearchAndCloseDialog(){
    //
    //   this.Searchdata=[];
    //   this.searchQuery='';
    // },
    async getFocusOnSearchList(){
      // alert(this.searchQuery);
      const Search_data=this.searchQuery;
      // alert(Search_data);
      if(Search_data.length>2){
        this.Searchdata=[];
      const DataSearchPro = await this.callAxios(this.site_url, {'action':'SearchProduct','Search':Search_data,'lang_id': localStorage.lang_id}, 'post');
      // this.Searchdata1 = DataSearchPro.data;
      //   this.Searchdata= DataSearchPro.data.key_words.split(',');

        // let proArray = DataSearchPro.data.split(",")
        // console.log(Searchdata);
        let detail=[];
        for (let Searchdata1 of DataSearchPro.data) {
          for(let newData of Searchdata1.key_words.split(',')){
            this.Searchdata.push(newData.replace(/[^a-zA-Z0-9 ]/g, ''));
          }
        }
        // console.log(detail)
      }else{
        this.Searchdata=[];
      }
    },
  },
  watch: {
    async $route(to, from) {
      console.log(this.$route)
      // this.segment = this.$route.params.segment
      // this.onLoadTableData()
    }
  },

}
</script>

<style lang="scss">
.app-bar-search-suggestions {
  .app-bar-search-suggestion {
    &:hover {
      color: rgb(var(--v-theme-primary));
    }
  }
}

.app-bar-autocomplete-box {
  .v-field__input {
    padding-block-end: 0.425rem;
    padding-block-start: 0.9375rem;
  }
}

.app-bar-search-dialog {
  .v-list-item-title {
    font-size: 0.875rem !important;
  }

  .app-bar-search-list {
    .v-list-item,
    .v-list-subheader {
      font-size: 0.75rem;
      padding-inline: 1.5rem !important;
    }

    .v-list-item {
      .v-list-item__append {
        .enter-icon {
          visibility: hidden;
        }
      }

      &:hover,
      &:active,
      &:focus {
        .v-list-item__append {
          .enter-icon {
            visibility: visible;
          }
        }
      }
    }

    .v-list-subheader {
      line-height: 1;
      min-block-size: auto;
      padding-block: 0.6875rem 0.3125rem;
      text-transform: uppercase;
    }
  }
}
</style>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 16px;
}
</style>
