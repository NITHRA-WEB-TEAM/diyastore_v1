<script setup>
// import {useTheme} from 'vuetify'

import ProductCard from '@/views/diya/diya/card.vue'

const isAddAddressSidebarVisible = ref(false)
const panel = ref(0)

</script>

<template>
  <div>
  <VRow>
    <VCol
      cols="12"
      md="3"
      style=""
      location="top end"
    >
      <VCard>
        <VCardText>
          <!-- 👉 Send Invoice Trigger button -->
          <span class="truncate-16 text-center ml-16">Product Filter</span><br>
          <!--          <VDivider/>-->
          <br>
          <!--          <VSelect-->
          <!--            v-model="categoryList.id"-->
          <!--            :items="categoryList"-->
          <!--            item-title="title"-->
          <!--            item-value="id"-->
          <!--            label="Select State"-->
          <!--            @category-filter="categoryFilter()"-->
          <!--          />-->
          <VExpansionPanels v-model="panel">
            <!-- SECTION Sorting by price -->
            <VExpansionPanel>
              <VExpansionPanelTitle>Sorting By Price</VExpansionPanelTitle>

              <VExpansionPanelText>

                <VRadioGroup
                  v-model="sortingList"
                  class="delivery-options"
                >
                  <div
                    v-for="(sortCategory, index) in sortingList"
                    class="delivery-option d-flex rounded-t"
                    :class="sortingList === index ? 'active' : ''"
                    @click="this.priceFilter=sortCategory.id; sortingPrice(sortCategory.id)"
                  >
                    <VRadio
                      inline
                      :value="sortCategory.id"
                      class="mt-n4"
                    />
                    <div class="w-100" type="button">
                      <div class=" justify-space-between">
                        <!--                      <h6 class="text-base font-weight-medium">-->
                        <!--                        {{ address.title }}-->
                        <!--                      </h6>-->
                        <span
                          :class="sortCategory.id === this.priceFilter ? 'text-base font-weight-regular activeCategory' : 'text-base font-weight-regular' ">
                      {{ sortCategory.title }}
                        <VDivider class="my-1 mx-auto"/>
                    </span>

                      </div>
                    </div>
                  </div>

                </VRadioGroup>
                <!--              <VDivider class="my-5" />-->
              </VExpansionPanelText>
            </VExpansionPanel>
            <!-- SECTION Filter by category -->
            <VExpansionPanel>
              <VExpansionPanelTitle>Category Filter</VExpansionPanelTitle>

              <VExpansionPanelText>

                <VRadioGroup
                  v-model="categoryList"
                  class="delivery-options"
                >
                  <div
                    v-for="(category, index) in categoryList"
                    class="delivery-option d-flex rounded-t"
                    :class="categoryList === index ? 'active' : ''"
                    @click="this.categoryId=category.id; categoryFilter(category.id)"
                  >
                    <VRadio
                      inline
                      :value="category.id"
                      class="mt-n4"
                    />
                    <div class="w-100" type="button">
                      <div class=" justify-space-between">
                        <!--                      <h6 class="text-base font-weight-medium">-->
                        <!--                        {{ address.title }}-->
                        <!--                      </h6>-->
                        <span
                          :class="category.id === this.categoryId ? 'text-base font-weight-regular activeCategory' : 'text-base font-weight-regular' ">
                      {{ category.title }}
                        <VDivider class="my-1 mx-auto"/>
                    </span>

                      </div>
                    </div>
                  </div>

                </VRadioGroup>
                <!--              <VDivider class="my-5" />-->
              </VExpansionPanelText>
            </VExpansionPanel>
            <!-- !SECTION Filter by category -->

          </VExpansionPanels>
        </VCardText>
      </VCard>
      <!--      <CheckOut :ProductsList="ProductsList"/>-->

    </VCol>
    <VCol style=""
          cols="12"
          md="9"
          sm="9"
          lg="9"
    >
      <div class="loading" v-if="loading === 1">
        <div class="effect-1 effects"></div>
        <div class="effect-2 effects"></div>
        <div class="effect-3 effects"></div>
      </div>
      <div class="loading" v-else>
      </div>
      <VRow>
        <VCol cols="12" v-for="(product,index) in ProductsList" :key="index"
              md="4"
        >
          <ProductCard
            :product="product"
            :index="index"
          />
        </VCol>
      </VRow>
    </VCol>


  </VRow>
  <VSnackbar
    v-model="isSnackbarScrollReverseVisible"
    transition="scroll-y-reverse-transition"
    location="top end"
    color="warning"
  >
    Added to Cart
    <template #actions>
      <VBtn
        color="white"
        @click="isSnackbarScrollReverseVisible = false"
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

<style>
.activeCategory {
  color: #ff6801;
}

</style>
<script>
const isSnackbarScrollReverseVisible = ref(false)

import axios from "axios";

// const route = useRoute()
export default {
  // setup(){
  //   alert('check')
  // },
  inheritAttrs: false,
  data() {
    return {
      ProductsList: [],
      categoryList: [],
      sortingList: [
        {
          "id": 1,
          "title": "Price (Low To High)"
        },
        {
          "id": 2,
          "title": "Price (High To Low)"
        },
      ],
      categoryId: '',
      loading: 0,
      priceFilter: 0,
      userData1: [{"id": ''}],

      // id: $route.params.id
    }
  },
  async created() {
    this.userData1 = JSON.parse(localStorage.getItem("userData") || '[]')
    this.loading = 1;
    await axios.post(this.site_url, {
      action: 'categoryList',
    })
      .then(result => {
        this.categoryList = result.data
        // console.log(JSON.parse(JSON.stringify(this.categoryList)))
        // console.log('here 12')
        // alert(this.categoryId)
      });

    await axios.post(this.site_url, {
      action: 'ProductsList',
      lang_id: localStorage.lang_id,
      userId: this.userData1.id,

    })
      .then(result => {
        this.ProductsList = result.data
        this.loading = 0;
        // console.log(result.data)
        // this.relatedProduct = (JSON.parse(JSON.stringify(this.relatedProduct1)))
        // console.log(JSON.parse(JSON.stringify(this.relatedProduct)))
      });
    // this.getDetails()
    if (!localStorage.userData) {
      if (localStorage.favouriteList) {
        this.ProductsList.forEach((value, index) => {
          this.favouriteList = JSON.parse(localStorage.getItem("favouriteList") || '[]')
          let proId = this.favouriteList.filter(x => x.productId == value.id).map(x => x.productId);
          if (proId[0] === value.id) {
            // JSON.parse(JSON.stringify(this.ProductsList[index])).is_fav = 1
            this.ProductsList[index].is_fav = 1
            // this.mostViewedList[index].is_fav = 1
          }
        });
      }
    }

  },
  methods: {
    categoryFilter(categoryId) {
      this.ProductsList = [];
      this.loading = 1;
      // alert(categoryId)
      this.categoryId = categoryId
      axios.post(this.site_url, {
        action: 'categoryFilter',
        lang_id: localStorage.lang_id,
        category: categoryId,
        priceFilter: this.priceFilter,
        userId: this.userData1.id,

      })
        .then(result => {
          this.ProductsList = result.data
          this.loading = 0;
          // console.log(result.data)
          // this.relatedProduct = (JSON.parse(JSON.stringify(this.relatedProduct1)))
          // console.log(JSON.parse(JSON.stringify(this.relatedProduct)))
        });
    },
    sortingPrice(sortCategory) {
      this.ProductsList = [];
      this.loading = 1;
      // alert(sortCategory)
      if (sortCategory === 1) {
        this.priceFilter = 1
      } else if (sortCategory === 2) {
        this.priceFilter = 2
      } else {
        this.priceFilter = 0
      }
      // alert(this.categoryId)
      axios.post(this.site_url, {
        action: 'categoryFilter',
        lang_id: localStorage.lang_id,
        category: this.categoryId,
        priceFilter: this.priceFilter,
        userId: this.userData1.id,
      })
        .then(result => {
          this.ProductsList = result.data
          this.loading = 0;
          // console.log(result.data)
          // this.relatedProduct = (JSON.parse(JSON.stringify(this.relatedProduct1)))
          // console.log(JSON.parse(JSON.stringify(this.relatedProduct)))
        });
    }
  }
}
</script>
