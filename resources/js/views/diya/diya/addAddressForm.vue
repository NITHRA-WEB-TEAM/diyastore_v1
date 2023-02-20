<script setup>
import {PerfectScrollbar} from 'vue3-perfect-scrollbar'
import {
  emailValidator, requiredValidator, integerValidator,
  lengthValidator
} from '@validators'

const props = defineProps({
  isDrawerOpen: {
    type: Boolean,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDrawerOpen',
  'submit',
])

// const name = ref('')
// const mobile = ref('')
// const login_mobile = ref('')
// const email = ref('')
// const state = ref('')
// const address = ref('')
// const pincode = ref()

// const onSubmit = () => {
//   alert('hii')
//   emit('update:isDrawerOpen', false)
//   emit('submit', {
//     name: name.value,
//     mobile: mobile.value,
//     login_mobile: login_mobile.value,
//     email: email.value,
//     state: state.value,
//     address: address.value,
//     pincode: pincode.value,
//   })
//   console.log(emit)
// }

const handleDrawerModelValueUpdate = val => {
  emit('update:isDrawerOpen', val)
}

</script>

<template>
  <VNavigationDrawer
    temporary
    location="end"
    :width="400"
    :model-value="props.isDrawerOpen"
    class="scrollable-content"
    @update:model-value="handleDrawerModelValueUpdate"
  >
    <!-- 👉 Header -->
    <div class="d-flex align-center pa-6 pb-1">
      <h6 class="text-h6">
        Add Address
      </h6>

      <VSpacer/>

      <VBtn
        icon
        size="32"
        color="default"
        variant="tonal"
        class="rounded"
        @click="handleDrawerModelValueUpdate(false)"
      >
        <VIcon
          size="18"
          icon="tabler-x"
        />
      </VBtn>
    </div>

    <PerfectScrollbar :options="{ wheelPropagation: false }">
      <VCard flat>
        <VCardText>
          <!--          <VForm @submit.prevent="onSubmit">-->
          <VForm
            ref="addressForm"
            @submit.prevent="() => { onSubmit() }"
          >
            <VRow>
              <VCol cols="12">
                <VTextField
                  v-model="userAddress.name"
                  label="Enter Your Name"
                  :rules="[requiredValidator]"
                />
              </VCol>

              <VCol cols="12">
                <VTextField
                  v-model="userAddress.mobile"
                  label="Delivery Mobile Number"
                  type="number"
                  :rules="[requiredValidator, lengthValidator(userAddress.mobile , 10)]"
                />
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="userData.mobileno"
                  disabled
                  label="Login Mobile Number"
                  :rules="[requiredValidator, lengthValidator(userAddress.login_mobile , 10)]"
                />
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="userAddress.email"
                  label="Enter Email (Optional)"
                  :rules="[emailValidator]"
                />
              </VCol>

              <VCol cols="12">
                <VSelect
                  v-model="userAddress.state"
                  :items="stateList"
                  item-title="english"
                  item-value="id"
                  label="Select State"
                  :rules="[requiredValidator]"
                />
              </VCol>

              <VCol cols="12">
                <VTextarea
                  v-model="userAddress.address"
                  label="Enter Your Address"
                  :rules="[requiredValidator]"
                />
              </VCol>
              <VCol cols="12">
                <VTextField
                  v-model="userAddress.pincode"
                  label="Enter Pincode"
                  type="number"
                  :rules="[requiredValidator,integerValidator, lengthValidator(userAddress.pincode , 6)]"
                />
              </VCol>

              <VCol cols="12">
                <VBtn
                  type="submit"
                  class="me-3"
                  @click="addressForm?.validate()"
                >
                  Send
                </VBtn>

                <VBtn
                  type="reset"
                  color="secondary"
                  variant="tonal"
                  @click="$emit('update:isDrawerOpen', false)"
                >
                  Cancel
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </PerfectScrollbar>
  </VNavigationDrawer>
</template>
<script>
import axios from "axios";
// const route = useRoute()
export default {
  data() {
    return {
      userAddress: [],
      // addressArray: [],
      stateList: [],
      userData: [],
      // stateList: [{ id : 1, english: 'test State'}],
      // address: [],
      // id: $route.params.id
    }
  },
  async created() {
    this.userData = JSON.parse(localStorage.getItem("userData") || '[]')

    await axios.post('http://192.168.58.42:3000/api/site/action', {
      action: 'getStateList',
    })
      .then(result => {
        this.stateList = result.data
        // console.log(JSON.parse(JSON.stringify(this.stateList)))
        // console.log('here 12')
        // alert(this.categoryId)
      });
  },
  methods: {
    onSubmit() {
      this.$refs.addressForm.validate().then(async success => {
        if (success.valid) {
          // alert(success.valid)

          let addressArray = [];
          // addressArray.push({
          //   name: this.userAddress.name,
          //   mobile: this.userAddress.mobile,
          //   login_mobile: this.userAddress.login_mobile,
          //   email: this.userAddress.email,
          //   state: this.userAddress.state,
          //   address: this.userAddress.address,
          //   pincode: this.userAddress.pincode,
          //   user_id: 1
          // });

          // console.log(JSON.stringify(addressArray))
          await axios.post('http://192.168.58.42:3000/api/site/action', {
            action: 'addUserAddress',
            name: this.userAddress.name,
            mobile: this.userAddress.mobile,
            login_mobile: this.userAddress.login_mobile,
            email: this.userAddress.email,
            state: this.userAddress.state,
            address: this.userAddress.address,
            pincode: this.userAddress.pincode,
            user_id: this.userData.id,
          })
            .then(result => {
              this.userAddress = result.data
              // console.log(JSON.parse(JSON.stringify(this.userAddress)))
              if(this.userAddress.status === 'success'){
                location.reload();
              }

            });

        } else {
          // alert("Validation error!")
        }
      })
    }
  }
}
</script>
