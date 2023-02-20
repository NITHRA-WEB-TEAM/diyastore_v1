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
  <VCard>
    <!--    <RouterLink :to="{ name: 'diya-singleView-id', params: { id: product.id } }">-->
    <VCardText class="pb-2">
      <VRow>
        <VCol
          cols="10"
          md="10"
          sm="10"
          lg="10"
        >
          <RouterLink :to="{ name: 'diya-id', params: { id: product.id } }" target="_blank">

            <h6 class="" style="font-size: 16px">
              {{ product.titles.substring(0, 25) + "..." }}
            </h6>
          </RouterLink>
        </VCol>
        <VCol
          cols="2"
          md="2"
          sm="2"
          lg="2"
        >
          <VBtn
            icon
            variant="text"
            color="error"
            size="small"
            v-if="product.is_fav === 1"
            @click="product.is_fav = 0; addToFavourite(product.id);"
          >
            <VIcon
              icon="tabler-heart-filled"
              size="24"
            />

          </VBtn>
          <VBtn
            icon
            variant="text"
            color="error"
            size="small"
            @click="product.is_fav = 1; addToFavourite(product.id);"
            v-else
          >
            <VIcon
              icon="tabler-heart"
              size="24"
            />

          </VBtn>
        </VCol>
      </VRow>
      <!--      <span class="text-body-2">Last Year</span>-->
    </VCardText>

    <!--    <VueApexCharts-->
    <!--      :options="chartOptions"-->
    <!--      :series="series"-->
    <!--      :height="80"-->
    <!--    />-->
    <!--    </RouterLink>-->
    <VCardText class="pt-0">
      <RouterLink :to="{ name: 'diya-id', params: { id: product.id } }" target="_blank">
        <img :src="product.images[0].src" style="width: -webkit-fill-available;max-height: 275px;min-height: 275px;">
        <div class="d-flex align-center justify-space-between mt-3">
          <h6 class="text-h6 text-center font-weight-semibold">
            ₹{{ discountedPrice(product) }}
          </h6>
          <span class="text-center font-weight-semibold text-error" style="text-decoration: line-through">
          ₹ {{ product.price }}
        </span>
          <span class="text-center font-weight-semibold text-success">
          Save ₹ {{ Math.ceil(product.discount_amt) }}
        </span>
          <span class="text-sm text-primary">
          ({{ discountedPercentage(product.discount) }}%)
        </span>
        </div>
      </RouterLink>
      <div class="d-flex align-center mt-2">
        <!--                :size="100"-->
        <!--        variant="tonal"-->
        <VAvatar
          color="#FF6801"
          style="width: 140px;height: 35px;color: white"
          rounded
          class="me-2"
          role="button"
          @click="isSnackbarScrollReverseVisible = true;addToCart(product.id)"
        >
          <VIcon
            size="30"
            icon="tabler-shopping-cart-plus"
          />
          {{ product.is_cart == 1 ? 'Go to cart' : 'Add to Cart' }}
        </VAvatar>
        <VAvatar
          color="success"
          style="width: 140px;height: 35px"
          rounded
          class="me-2"
          role="button"
        >
          <VIcon
            size="25"
            icon="tabler-credit-card"
          />
          Buy Now
        </VAvatar>

        <!--        <span>Add to cart</span>-->
      </div>
    </VCardText>
  </VCard>
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
</template>
<script>
import axios from "axios";

export default {
  props: ['product', 'index'],
  data() {
    return {
      cartItem: [],
      // id: $route.params.id
    }
  },
  methods: {
    discountedPrice(product) {
      const price = product.price - (product.price * product.discount / 100)
      return Math.ceil(price)
    },
    discountedPercentage(productDiscount) {
      return productDiscount.toFixed(2)
    }
  }
}
</script>
