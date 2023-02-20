

<template>
  <VCard>
    <img class="zoom" src="https://d1zqapbqie7n0v.cloudfront.net/960748_1644050935.webp" style="width: -webkit-fill-available;" alt="">
<!--    <img :src=inImage style="width: -webkit-fill-available;" alt="product_image">-->
    <div class="d-flex align-center ml-4">
      <VAvatar
        color="#FF6801"
        style="width: 160px;height: 45px;color: white"
        rounded
        class="me-2 v-btn--elevated"
      >
        <VIcon
          size="30"
          icon="tabler-shopping-cart-plus"
        />
        Add to cart
      </VAvatar>
      <VAvatar
        color="success"
        style="width: 160px;height: 45px"
        rounded
        class="me-2 v-btn--elevated"
      >
        <VIcon
          size="30"
          icon="tabler-credit-card"
        />
        Buy Now
      </VAvatar>
      <!--        <span>Add to cart</span>-->
    </div><br>
      </VCard>
</template>
<script>
export default {
  // props: ['imageData'],
  // data() {
  //   return {
  //     imageSrc: [],
  //   }
  // },

  props: { imageData: { type: Object } },
  data() {
    return {
      imageDataReceived: [],
      cartItem: [],
      patient_id: this.imageData,
      inImage : [],
      // id: $route.params.id
    }
  },
  mounted() {
    setTimeout(() =>
        this.imageDataReceived = this.imageData
      , 3000);
    // this.imageData.forEach((value, index) => {
    //   this.inImage.push(value)
    // })
    this.inImage = JSON.stringify(this.imageDataReceived.images)
    console.log("ok"+this.inImage)


    console.log(this.inImage)
    console.log("12 test")
  },

  created() {
    // this.imageSrc = this.imageData
    // // alert(this.imageSrc)
    // console.log(this.imageSrc.images[0].src)

  }
}

</script>
<style>
.zoom {
  padding: 50px;
  transition: transform .2s;
  margin: 0 auto;
}

.zoom:hover {
  -ms-transform: scale(1.5);
  -webkit-transform: scale(1.5);
  transform: scale(1.5);
}
</style>
