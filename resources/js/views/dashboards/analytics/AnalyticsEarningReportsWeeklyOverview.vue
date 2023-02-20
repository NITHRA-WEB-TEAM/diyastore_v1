<template>
  <VCard>

    <VCardText>
      <!--    <img :src="imageData.images[0].src" style="width: -webkit-fill-available;" alt="">-->
      <img src="../../../../images/svg/gift.svg" style="width: -webkit-fill-available;" alt="">
      <div class="d-flex align-center ml-16">
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
      </div>
    </VCardText>

  </VCard>
</template>
<script>
export default {
  props: ['imageData'],
}
</script>
