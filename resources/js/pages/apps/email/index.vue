<script setup>
import {PerfectScrollbar} from 'vue3-perfect-scrollbar'
import ComposeDialog from '@/views/apps/email/ComposeDialog.vue'
import EmailLeftSidebarContent from '@/views/apps/email/EmailLeftSidebarContent.vue'
import EmailView from '@/views/apps/email/EmailView.vue'
import {useEmail} from '@/views/apps/email/useEmail'
import {useEmailStore} from '@/views/apps/email/useEmailStore'
import {useResponsiveLeftSidebar} from '@core/composable/useResponsiveSidebar'
import {formatDateToMonthShort} from '@core/utils/formatters'

const {isLeftSidebarOpen} = useResponsiveLeftSidebar()

// Composables
const route = useRoute()
const store = useEmailStore()
const {labels, resolveLabelColor, emailMoveToFolderActions, shallShowMoveToActionFor, moveSelectedEmailTo} = useEmail()

// Compose dialog
const isComposeDialogVisible = ref(false)

// Ref
const q = ref('')

// ------------------------------------------------
const selectedEmails = ref([])

const toggleSelectedEmail = emailId => {
  const emailIndex = selectedEmails.value.indexOf(emailId)
  if (emailIndex === -1)
    selectedEmails.value.push(emailId)
  else
    selectedEmails.value.splice(emailIndex, 1)
}

const selectAllEmailCheckbox = computed(() => store.emails.length && store.emails.length === selectedEmails.value.length)
const isSelectAllEmailCheckboxIndeterminate = computed(() => Boolean(selectedEmails.value.length) && store.emails.length !== selectedEmails.value.length)

const selectAllCheckboxUpdate = () => {
  selectedEmails.value = !selectAllEmailCheckbox.value ? store.emails.map(email => email.id) : []
}

// Email View
const openedEmail = ref(null)

const emailViewMeta = computed(() => {
  const returnValue = {
    hasNextEmail: false,
    hasPreviousEmail: false,
  }

  if (openedEmail.value) {
    const openedEmailIndex = store.emails.findIndex(e => e.id === openedEmail.value.id)

    returnValue.hasNextEmail = !!store.emails[openedEmailIndex + 1]
    returnValue.hasPreviousEmail = !!store.emails[openedEmailIndex - 1]
  }

  return returnValue
})

// Fetch emails
const fetchEmails = async () => {
  selectedEmails.value = []
  await store.fetchEmails({
    q: q.value,
    filter: route.params.filter,
    label: route.params.label,
  })
}

const handleActionClick = async (action, emailIds = selectedEmails.value) => {
  if (!emailIds.length)
    return
  if (action === 'trash')
    store.updateEmails(emailIds, {isDeleted: true})
  else if (action === 'spam')
    store.updateEmails(emailIds, {folder: 'spam'})
  else if (action === 'unread')
    store.updateEmails(emailIds, {isRead: false})
  else if (action === 'read')
    store.updateEmails(emailIds, {isRead: true})
  else if (action === 'star')
    store.updateEmails(emailIds, {isStarred: true})
  else if (action === 'unstar')
    store.updateEmails(emailIds, {isStarred: false})
  await fetchEmails()
}

watch([
  q,
  () => route.params.filter,
  () => route.params.label,
], fetchEmails, {immediate: true})
watch([
  () => route.params.filter,
  () => route.params.label,
], () => {
  openedEmail.value = null
})

const handleMoveMailsTo = action => {
  moveSelectedEmailTo(action, selectedEmails.value)
  fetchEmails()
}

const updateLabel = label => {
  store.updateEmailLabels(selectedEmails.value, label)
  fetchEmails()
}

const changeOpenedEmail = dir => {
  if (!openedEmail.value)
    return
  const openedEmailIndex = store.emails.findIndex(e => e.id === openedEmail.value.id)
  const newEmailIndex = dir === 'previous' ? openedEmailIndex - 1 : openedEmailIndex + 1

  openedEmail.value = store.emails[newEmailIndex]
}

const openEmail = email => {
  openedEmail.value = email
  handleActionClick('read', [email.id])
}

const refreshOpenedEmail = async () => {
  await fetchEmails()
  if (openedEmail.value) {
    openedEmail.value = store.emails.find(e => e.id === openedEmail.value.id)
  }
}
</script>

<template>
  <VLayout class="email-app-layout">
    <EmailView
      :email="openedEmail"
      :email-meta="emailViewMeta"
      @refresh="refreshOpenedEmail"
      @navigated="changeOpenedEmail"
      @close="openedEmail = null"
      @remove="handleActionClick('trash', openedEmail ? [openedEmail.id] : [])"
      @unread="handleActionClick('unread', openedEmail ? [openedEmail.id] : [])"
      @star="handleActionClick('star', openedEmail ? [openedEmail.id] : [])"
      @unstar="handleActionClick('unstar', openedEmail ? [openedEmail.id] : [])"
    />
    <VRow>
<!--      <VCol-->
<!--        cols="12"-->
<!--        md="1"-->
<!--        class=""-->
<!--      ></VCol>-->
      <VCol
        cols="12"
        md="7"
        offset="1"
        class="d-print-none"
      >
        <VMain>
          <VCard
            flat
            class="h-100 d-flex flex-column"
          >
            <div class="d-flex align-center">
              <VBtn
                variant="text"
                color="default"
                icon
                size="small"
                class="d-lg-none ms-3"
                @click="isLeftSidebarOpen = true"
              >
                <VIcon
                  size="24"
                  icon="tabler-menu-2"
                />
              </VBtn>
              <!-- 👉 Search -->
              <VTextField
                v-model="q"
                density="default"
                class="email-search px-1 flex-grow-1"
                prepend-inner-icon="tabler-search"
                placeholder="Search email"
              />
            </div>

            <VDivider/>

            <!--          <VDivider/>-->

            <!-- 👉 Emails list -->
<!--            <h1 v-for="email in store.cartData">{{ email.titles }}</h1>-->
            <PerfectScrollbar
              tag="ul"
              :options="{ wheelPropagation: false }"
              class="email-list"
            >
              <li
                v-for="email in store.cartData"
                v-show="store.cartData.length"
                :key="email.id"
                class="email-item d-flex align-center py-2 px-5 cursor-pointer"
                              >
                <!--              @click="openEmail(email)"-->

                <VAvatar
                  class="my-4"
                  size="60"
                  style="border-radius: unset;height: 120px;width: 120px"
                >
                  <VImg
                    :src="email.images[0].src"
                    :alt="email.titles"
                  />
                </VAvatar>
                <div class="d-flex flex-column">
                  <h6 class="mx-2 text-body-1 font-weight-medium text-high-emphasis">
                    {{ email.titles }}
                  </h6>
<!--                  <span class="truncate mx-2">{{ email.subject }}</span>-->
                  <span class="truncate mx-2">M.R.P : ₹ {{ email.price - email.discount_amt }}</span>
                </div>
                <VSpacer/>
                <!-- 👉 Email actions -->
                <div class="email-actions" style="margin: 25px 0px 0px -25px">
                  <VBtn
                    variant="text"
                    color="default"
                    icon
                    size="small"
                    @click.stop="handleActionClick('trash', [email.id])"
                  >
                    <VIcon
                      size="22"
                      icon="tabler-trash"
                    />
                  </VBtn>
                </div>
              </li>
              <li
                v-show="!store.emails.length"
                class="py-4 px-5 text-center"
              >
                <span class="text-high-emphasis">No items found.</span>
              </li>
            </PerfectScrollbar>
          </VCard>
<!--          <ComposeDialog-->
<!--            v-show="isComposeDialogVisible"-->
<!--            @close="isComposeDialogVisible = false"-->
<!--          />-->
        </VMain>
      </VCol>

      <VCol
        cols="12"
        md="3"
        class="d-print-none"
      >
        <VCard>
          <VCardText>
            <!-- 👉 Send Invoice Trigger button -->
            <span class="truncate ml-16">PRICE DETAILS</span>
            <VDivider/><br>
            <p><span class="mb-4 mr-2">Price(20 Items)</span><span class="ml-16">₹ 2000</span></p>
            <p><span class="mb-4 mr-16">Discount</span><span class="ml-16">₹ 450</span></p>
            <VDivider/>
            <p class="mt-4"><span class=" mr-12 font-weight-bold text-black">Total Amount</span><span class="ml-8 font-weight-bold text-black">₹ 2000</span></p>
            <VDivider/><br>

            <!-- 👉  Add Payment trigger button  -->
            <VBtn
              block
              prepend-icon="tabler-currency-rupee"
            >
              Check Out
            </VBtn>
          </VCardText>
        </VCard>
      </VCol>
    </VRow>
  </VLayout>
</template>

<route lang="yaml">
meta:
layoutWrapperClasses: layout-content-height-fixed
</route>

<style lang="scss">
@use "@styles/variables/_vuetify.scss";
@use "@core-scss/base/_mixins.scss";
@use "vuetify/lib/styles/tools/elevation" as elevation;

// ℹ️ Remove border. Using variant plain cause UI issue, caret isn't align in center
.email-search {
  .v-field__outline {
    display: none;
  }
}

.email-app-layout {
  border-radius: vuetify.$card-border-radius;

  @include elevation.elevation(vuetify.$card-elevation);

  $sel-email-app-layout: &;

  @at-root {
    .skin--bordered {
      @include mixins.bordered-skin($sel-email-app-layout);
    }
  }
}

.email-list {
  white-space: nowrap;

  .email-item {
    transition: all 0.2s ease-in-out;
    will-change: transform, box-shadow;

    &.email-read {
      background-color: rgba(var(--v-theme-on-surface), var(--v-hover-opacity));
    }

    & + .email-item {
      border-block-start: 1px solid rgba(var(--v-border-color), var(--v-border-opacity));
    }
  }

  .email-item:hover {
    transform: translateY(-2px);

    @include elevation.elevation(3);

    .email-actions {
      display: block !important;
    }

    .email-meta {
      display: none;
    }

    + .email-item {
      border-color: transparent;
    }
  }
}

.email-compose-dialog {
  position: absolute;
  inset-block-end: 0;
  inset-inline-end: 0;
  min-inline-size: 100%;

  @media only screen and (min-width: 800px) {
    min-inline-size: 712px;
  }
}

.v-layout {
  display: unset;
}
</style>

