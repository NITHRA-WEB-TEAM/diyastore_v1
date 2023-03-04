<template>
  <div>
    <VRow class="set_height">
      <VCol
        cols="12"
        lg="12"
        md="12"
        sm="12"
      >
        <!--      <VCard> -->
        <VCarousel style="height: 350px">
          <VCarouselItem
            v-for="(item,index) in slider"
            :key="index"
            :src="item.image_url"
            reverse-transition="fade-transition"
            transition="fade-transition"
            type="button"
            @click="goToSliderView(item.link)"
          />
        </VCarousel>
        <!--        <img :src="bannerImage" style="width: -webkit-fill-available;" alt=""> -->
        <!--      </VCard> -->
      </VCol>
    </VRow>
  </div>
</template>

<script>
import {BButton} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'

export default {
  directives: {
    Ripple,
  },
  components: {
    BButton,
  },
}
</script>

<style>

</style>
