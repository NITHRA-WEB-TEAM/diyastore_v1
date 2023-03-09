<script setup>
import productCard from '@/views/diya/diya/card.vue'
import bannerImage from '@images/banner/banner1.png'

// const isAlertVisible = ref(true)


</script>

<template>



  <VRow>
    <VCol cols="12"
          md="12"
          sm="12"
          lg="12"
    >
      <VCard>
        <img :src="bannerImage" style="width: -webkit-fill-available;" alt="">
      </VCard>

    </VCol>
    <div class="loading" v-if="loading === 1">
      <div class="effect-1 effects"></div>
      <div class="effect-2 effects"></div>
      <div class="effect-3 effects"></div>
    </div>
    <div class="loading" v-else>
    </div>
  </VRow>

  <VRow>
    <VCol v-for="(product,index) in ProductsList" :key="index"
          cols="12"
          md="4"
          sm="6"
          lg="3"
    >
      <productCard
        :product="product"
        :index="index"
      />
    </VCol>

  </VRow>

</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      ProductsList: [],
      loading: 0
    }
  },
  created() {
    window.addEventListener('scroll', this.handleScroll);
    this.loading = 1
    axios.post(this.site_url, {action: 'ProductsList', lang_id: localStorage.lang_id})
      .then(result => {
        // console.log(result.data)
        this.ProductsList = result.data
        this.loading = 0
        // console.log(JSON.parse(JSON.stringify(this.ProductsList)))
      });
  },
  methods: {
    handleScroll (event) {

      // Any code to be executed when the window is scrolled
    }
  }
}
</script>
<style lang="scss">
.alert-demo-v-model-wrapper {
  margin-block-end: 1rem;
  min-block-size: 50px;
}
</style>

<route lang="yaml">
meta:
layout: blank
action: read
subject: Auth
redirectIfLoggedIn: true
</route>

