<script setup>
import Notifications from '@core/components/Notifications.vue'

// Images
import avatar3 from '@images/avatars/avatar-3.png'
import avatar4 from '@images/avatars/avatar-4.png'
import avatar5 from '@images/avatars/avatar-5.png'
import paypal from '@images/svg/paypal.svg'

// const a = cart.$state.cartCount= 4;
// // console.log(cart)
// const cartCount = a
const notifications = [
  {
    img: avatar4,
    title: 'Congratulation Flora! 🎉',
    subtitle: 'Won the monthly best seller badge',
    time: 'Today',
  },
  {
    text: 'Tom Holland',
    title: 'New user registered.',
    subtitle: '5 hours ago',
    time: 'Yesterday',
  },
  {
    img: avatar5,
    title: 'New message received 👋🏻',
    subtitle: 'You have 10 unread messages',
    time: '11 Aug',
  },
  {
    img: paypal,
    title: 'Paypal',
    subtitle: 'Received Payment',
    time: '25 May',
    color: 'error',
  },
  {
    img: avatar3,
    title: 'Received Order 📦',
    subtitle: 'New order received from john',
    time: '19 Mar',
  },
]
</script>

<template>
  <Notifications :notifications="notifications" :cartCount="useTodosStore().$state.cartCount" />
</template>
<script>
import axios from "axios";
import {useTodosStore} from "@/store/store1"

export default {
  data(){
    return{
      cartCounts: [],
      userData1: [],
      cartCount:0,
      cartCount1:0,
      useTodosStore
    }
  },
  created() {

    if (localStorage.userData) {
      this.userData1 = JSON.parse(localStorage.getItem("userData") || '[]')
      axios.post(this.site_url, {
        action: 'getCartCount',
        userId: this.userData1.id,
      })
        .then(result => {
          this.cartCount = result.data
          useTodosStore().$state.cartCount=result.data;
        });
    } else {
      if (localStorage.cartItem) {
        this.cartCounts = JSON.parse(localStorage.getItem("cartItem") || '[]')
        this.cartCount = this.cartCounts.length
        useTodosStore().$state.cartCount=this.cartCounts.length;
        // this.cartCount = this.cartCounts.length
      } else {
        this.cartCount = 0;
        useTodosStore().$state.cartCount=0;
      }
    }
  }
}
</script>
