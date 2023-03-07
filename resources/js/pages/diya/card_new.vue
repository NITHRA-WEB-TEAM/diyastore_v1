<script setup>
import VueApexCharts from 'vue3-apexcharts'
import {useTheme} from 'vuetify'

const vuetifyTheme = useTheme()
const currentTheme = vuetifyTheme.current.value.colors
const isSnackbarScrollReverseVisible = ref(false)

const series = [{
  name: 'Subscribers',
  data: [
    200,
    55,
    400,
    250,
  ],
}]

const chartOptions = {
  chart: {
    type: 'area',
    parentHeightOffset: 0,
    toolbar: {show: false},
    sparkline: {enabled: true},
  },
  markers: {
    colors: 'transparent',
    strokeColors: 'transparent',
  },
  grid: {show: false},
  colors: [currentTheme.success],
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 0.9,
      opacityFrom: 0.5,
      opacityTo: 0.07,
      stops: [
        0,
        80,
        100,
      ],
    },
  },
  dataLabels: {enabled: false},
  stroke: {
    width: 2,
    curve: 'smooth',
  },
  xaxis: {
    show: true,
    lines: {show: false},
    labels: {show: false},
    stroke: {width: 0},
    axisBorder: {show: false},
  },
  yaxis: {
    stroke: {width: 0},
    show: false,
  },
  tooltip: {enabled: false},
}
</script>

<template>
  <VBadge content="New"
          location="top start"
          offset-x="50"
          offset-y="-3"
          rounded="sm"
  >
    <VCard
    >

      <!--    <RouterLink :to="{ name: 'diya-singleView-id', params: { id: product.id } }"> -->
      <VCardText class="pb-2">
        <VRow>
          <VCol
            cols="10"
            lg="10"
            md="10"
            sm="10"
          >
            <RouterLink
              :to="{ name: 'diya-id', params: { id: product.id } }"
              target="_blank"
            >
              <h6
                style="font-size: 16px"
              >
                {{ product.titles.substring(0, 25) + "..." }}
              </h6>
            </RouterLink>
          </VCol>
          <VCol
            cols="2"
            lg="2"
            md="2"
            sm="2"
          >
            <VBtn
              v-if="product.is_fav === 1"
              color="error"
              icon
              size="small"
              variant="text"
              @click="product.is_fav = 0; addToFavourite(product.id);"
            >
              <VIcon
                icon="tabler-heart-filled"
                size="24"
              />
            </VBtn>
            <VBtn
              v-else
              color="error"
              icon
              size="small"
              variant="text"
              @click="product.is_fav = 1; addToFavourite(product.id);"
            >
              <VIcon
                icon="tabler-heart"
                size="24"
              />
            </VBtn>
          </VCol>
        </VRow>
        <!--      <span class="text-body-2">Last Year</span> -->
      </VCardText>

      <!--    <VueApexCharts -->
      <!--      :options="chartOptions" -->
      <!--      :series="series" -->
      <!--      :height="80" -->
      <!--    /> -->
      <!--    </RouterLink> -->
      <VCardText class="pt-0">
        <RouterLink
          :to="{ name: 'diya-id', params: { id: product.id } }"
          target="_blank"
        >
          <img
            :src="product.images[0].src"
            style="width: -webkit-fill-available;max-height: 200px;min-height: 100px;"
          >
          <div class="d-flex align-center">
            <h6 class="text-h6 text-center pl-2 font-weight-semibold">
              ₹{{ discountedPrice(product) }}
            </h6>
            <span
              class="text-center font-weight-semibold text-error pl-2"
              style="text-decoration: line-through"
            >
            ₹{{ product.price }}
          </span>
            <span class="text-center font-weight-semibold text-success pl-2">
            ₹{{ Math.ceil(product.discount_amt) }}
          </span>
            <span class="text-center font-weight-semibold text-primary pl-2">
           ({{ discountedPercentage(product.discount) }}% off)
          </span>
          </div>

          <!--        <p class="text-sm text-center text-primary">-->
          <!--          ({{ discountedPercentage(product.discount) }}% off)-->
          <!--        </p>-->
        </RouterLink>
        <div class="d-flex  justify-space-around  mt-2">
          <!--                :size="100" -->
          <!--        variant="tonal" -->
          <VAvatar
            class="me-2"
            color="#FF6801"
            role="button"
            rounded
            style="width: 140px;height: 35px;color: white"
            @click.once="product.is_cart == 1 ? GoToCart(product.id) :(addToCart(product.id),isSnackbarScrollReverseVisible=true)"
          >
            <VIcon
              icon="tabler-shopping-cart-plus"
              size="30"
            />
            {{ product.is_cart == 1 ? 'Go to cart' : 'Add to Cart' }}
          </VAvatar>
          <VAvatar
            class="me-2"
            color="success"
            role="button"
            rounded
            style="width: 140px;height: 35px;color: white"
          >
            <VIcon
              icon="tabler-credit-card"
              size="30"
            />
            Buy Now
          </VAvatar>

          <!--        <span>Add to cart</span> -->
        </div>
      </VCardText>
    </VCard>
    <VSnackbar
      v-model="isSnackbarScrollReverseVisible"
      color="warning"
      location="top end"
      transition="scroll-y-reverse-transition"
    >
      Added to Cart
      <template #actions>
        <VBtn
          color="white"
          max-width="500px"
          @click="isSnackbarScrollReverseVisible = false"
        >
          <VIcon
            icon="tabler-x"
            size="20"
          />
        </VBtn>
      </template>
    </VSnackbar>
  </VBadge>

</template>

<script>
import axios from "axios"

export default {
  props: ['product', 'index'],
  data() {
    return {
      cartItem: [],

      // id: $route.params.id
    }
  },
  created(){
    // alert('sss')

  },
  methods: {
    discountedPrice(product) {
      const price = product.price - (product.price * product.discount / 100)

      return Math.ceil(price)
    },
    discountedPercentage(productDiscount) {
      return productDiscount.toFixed(2)
    },
    GoToCart(productId) {
      this.$router.push({path: `/diya/cart`})
    },

  },
}
</script>
