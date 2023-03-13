<script setup>
import pdf from '@images/pdfs.png'

const resolveStatus1 = {
  0: 'online',
  1: 'COD',
}
const resolveStatus = {
  0: 'success',
  1: 'info',
}
</script>

<template>
  <VCard title="My Orders" style="margin: 10px;">

    <VDivider />
    <VTable class="text-no-wrap" style="max-height: 600px;overflow:overlay">
      <thead>
      <tr>
        <th class="font-weight-semibold">
          PRODUCT
        </th>
        <th class="font-weight-semibold">
          ORDER ID
        </th>
        <th class="font-weight-semibold">
          TRACK ID
        </th>
        <th class="font-weight-semibold">
          TRACK URL
        </th>
        <th class="font-weight-semibold">
          Payment Type
        </th>
        <th class="font-weight-semibold">
          Product Status
        </th>
        <th class="font-weight-semibold">
         Invoice
        </th>

      </tr>
      </thead>

      <tbody>

      <tr
        v-for="transition in my_order_Product"
        :key="transition.pros_id"
      >
<!--{{transition.imgarray}}-->
        <td style="padding-block: 0.61rem;">
          <div class="d-flex align-center" >
            <VAvatar color="info" v-for="listItem in transition.imgarray">

              <VImg :src="listItem.image" />
              <VTooltip
                location="top"
                activator="parent"
              >
                {{listItem.title}}
              </VTooltip>
            </VAvatar>
            &nbsp;&nbsp;
          </div>
        </td>
        <td style="padding-block: 0.61rem;">
<!--          <p class="text-medium-emphasis font-weight-semibold text-base mb-0">-->
<!--            Sent-->
<!--          </p>-->
          <span class="text-sm opacity-100 ">{{ transition.order_id }}</span>
        </td>
        <td style="padding-block: 0.61rem;">
          <span class="text-sm opacity-100 " v-if="transition.track_id">{{ transition.track_id }}  </span>
          <span class="text-sm opacity-100 " v-else>---</span>
        </td>
        <td style="padding-block: 0.61rem;">
          <span class="text-sm opacity-100 " v-if="transition.track_url">{{ transition.track_url }} </span>
          <span class="text-sm opacity-100 " v-else>---</span>
        </td>
        <td style="padding-block: 0.61rem;">
          <VChip
            label
            :color="resolveStatus[transition.payment_type]"
          >
            {{resolveStatus1[transition.payment_type]}}
          </VChip>
        </td>
        <td style="padding-block: 0.10rem;">
          <VBtn
            color="error"
            variant="tonal"
            v-if="transition.cod_cancel==1"
          >
            Canceled

          </VBtn>
          <VBtn
            color="success"
            variant="tonal"
            v-if="transition.is_dispatch==1"
          >
            Dispatched
          </VBtn>
          <VBtn
            color="warning"
            variant="tonal"
            v-if="transition.is_dispatch==0 &&transition.cod_cancel==0 "
          >
           NOT Dispatched
          </VBtn>

        </td>
        <td>
          <VImg :src="pdf" height="60px"/>
        </td>
      </tr>
      </tbody>
    </VTable>
  </VCard>
</template>
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
      list: [],
      loading: 1,
      my_order_Product: [],
      userData: [],
      categoryId: '',
      totalPrice: 0,
      totalDiscount: 0,
      goToLocation: 0,
    }
  },
  async created() {
    axios.post(this.site_url, {
      action: 'MyOrder_details',
      lang_id: localStorage.lang_id,
      userId: 3,

    })
      .then(result => {
        this.my_order_Product = result.data
        // this.list = result.data;
        // console.log(result.data)
        // this.favoriteProduct = (JSON.parse(JSON.stringify(this.favoriteProduct)))
        // console.log(JSON.parse(JSON.stringify(this.favoriteProduct)))
      });
    // this.getDetails()
  },
  methods: {

  }
}
</script>
