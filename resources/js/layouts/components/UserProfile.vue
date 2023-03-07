<script setup>
import { initialAbility } from '@/plugins/casl/ability'
import { useAppAbility } from '@/plugins/casl/useAppAbility'

const router = useRouter()
const ability = useAppAbility()
const userData = JSON.parse(localStorage.getItem('userData') || 'null')
// console.log(userData)
const logout = () => {
  // Remove "userData" from localStorage
  localStorage.removeItem('userData')
  localStorage.removeItem('cartItem')
  localStorage.removeItem('favouriteList')
  // Remove "accessToken" from localStorage
  localStorage.removeItem('accessToken')
  router.push('/login').then(() => {
    // Remove "userAbilities" from localStorage
    localStorage.removeItem('userAbilities')
    // Reset ability to initial ability
    console.log(initialAbility);
    ability.update(initialAbility)
  })
}
const login = () => {
  // Remove "userData" from localStorage
  localStorage.removeItem('userData')
  // Remove "accessToken" from localStorage
  localStorage.removeItem('accessToken')
  router.push('/login').then(() => {
    // Remove "userAbilities" from localStorage
    localStorage.removeItem('userAbilities')
    // Reset ability to initial ability
    ability.update(initialAbility)
  })
}
</script>

<template>

  <VBadge v-if="userData"
    dot
    location="bottom right"
    offset-x="3"
    offset-y="3"
    bordered
    color="success"
  >
    <VAvatar
      class="cursor-pointer"
      color="primary"
      variant="tonal"
    >
      <VImg
        v-if="userData && userData.avatar"
        :src="userData.avatar"
      />
      <VIcon
        v-else
        icon="tabler-user"
      />

      <!-- SECTION Menu -->
      <VMenu
        activator="parent"
        width="230"
        location="bottom end"
        offset="14px"
      >
        <VList>
          <!-- 👉 User Avatar & Name -->
          <VListItem>
            <template #prepend>
              <VListItemAction start>
                <VBadge
                  dot
                  location="bottom right"
                  offset-x="3"
                  offset-y="3"
                  color="success"
                >
                  <VAvatar
                    color="primary"
                    variant="tonal"
                  >
                    <VImg
                      v-if="userData && userData.avatar"
                      :src="userData.avatar"
                    />
                    <VIcon
                      v-else
                      icon="tabler-user"
                    />
                  </VAvatar>
                </VBadge>
              </VListItemAction>
            </template>

            <VListItemTitle class="font-weight-semibold">
              {{ userData.name ?  userData.name : userData.mobileno}}
            </VListItemTitle>
            <VListItemSubtitle>{{ userData.name ?  userData.mobileno : '' }}</VListItemSubtitle>
          </VListItem>

          <!-- Divider -->
          <VDivider class="my-2" />

          <!-- 👉 Logout -->
          <VListItem
            link
            @click="logout"
          >
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-logout"
                size="22"
              />
            </template>

            <VListItemTitle>Logout</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VAvatar>
  </VBadge>
  <VAvatar v-else
    color="success"
    style="width: 75px;height: 32px"
    rounded
    class="me-2"
    role="button"
    @click="login">
    {{$router.currentRoute.name}}
    <VIcon
      size="17"
      icon="tabler-user"
    />
    Login
  </VAvatar>
</template>
