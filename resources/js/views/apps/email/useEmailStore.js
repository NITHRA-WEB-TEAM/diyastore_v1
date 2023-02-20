import axios from '@axios'

export const useEmailStore = defineStore('email', {
  // ℹ️ arrow function recommended for full type inference
  state: () => ({
    emails: [],
    cartData: [],
    emailsMeta: {
      draft: 0,
      inbox: 0,
      spam: 0,
    },
  }),
  actions: {
    async fetchEmails(payload) {
      const response = await axios.get('/apps/email/emails', { params: payload })
      const { emails, emailsMeta } = response.data

      this.emails = emails
      this.emailsMeta = emailsMeta
      console.log(response.data)

      const result = await axios.post('http://192.168.58.42:3000/api/site/action', {
        action: 'ProductsList',
        lang_id: localStorage.lang_id
      })
      console.log(result.data)
      // const { cartData} = result.data
      this.cartData = result.data
      // console.log(this.cartData)

    },
    async updateEmails(ids, data) {
      return axios.post('/apps/email/update-emails/', {
        ids,
        data,
      })
    },
    async updateEmailLabels(ids, label) {
      return axios.post('/apps/email/update-emails-label', {
        ids,
        label,
      })
    },
  },
  created () {
    alert()
  }
})
