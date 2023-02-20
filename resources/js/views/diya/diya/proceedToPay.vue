<template>
  <VCard>
    <VCardText>
      <!-- 👉 Send Invoice Trigger button -->
      <span class="truncate-16">PRICE DETAILS</span>
      <VDivider/>
      <br>
      <p><span class="mb-4 mr-2">Price({{ ProductsList.length }} Items)</span><span class="ml-16">₹
          {{ getTotal() }}
          </span></p>
      <p><span class="mb-4 mr-16">Discount</span><span class="ml-16">₹ {{ getDiscount() }}</span></p>
      <VDivider/>
      <p class="mt-4"><span class=" mr-12 font-weight-bold text-black">Total Amount</span><span
        class="ml-8 font-weight-bold text-black">₹ {{ totalPrice - totalDiscount }}</span></p>
      <VDivider/>
      <br>

      <!-- 👉  Add Payment trigger button  -->
      <RouterLink :to="{ name: 'dashboards-addressCheck' }">

<!--        <VBtn-->
<!--          block-->
<!--          type="button"-->
<!--          prepend-icon="tabler-currency-rupee"-->
<!--        >-->
<!--          Proceed To Pay-->
<!--        </VBtn>-->
      </RouterLink>
    </VCardText>
  </VCard>

</template>

<script>

export default {
  props: ['ProductsList'],

  // setup(){
  //   alert('check')
  // },
  inheritAttrs: false,
  data() {
    return {
      totalPrice: 0,
      totalDiscount: 0,
      // id: $route.params.id
    }
  },
  async created() {
  },
  methods: {
    getTotal() {
      const mulQty = this.ProductsList.filter(x => x.price).map(x => x.qty * x.price);
      const sumTotal = mulQty.reduce((partialSum, a) => partialSum + a, 0);
      return this.totalPrice = sumTotal
    },
    getDiscount() {
      const mulQtyDiscount = this.ProductsList.filter(x => x.discount_amt).map(x => x.qty * x.discount_amt);
      const sumDiscount = mulQtyDiscount.reduce((partialSum, a) => partialSum + a, 0);
      return this.totalDiscount = Math.ceil(sumDiscount)
    }
  }
}
</script>
