/* eslint-disable import/order */
import '@/@fake-db/db'
import '@/@iconify/icons-bundle'
import App from '@/App.vue'
import commonJs from '@/common.js'
import ability from '@/plugins/casl/ability'
import i18n from '@/plugins/i18n'
import layoutsPlugin from '@/plugins/layouts'
import vuetify from '@/plugins/vuetify'
import { loadFonts } from '@/plugins/webfontloader'
import router from '@/router'
import { abilitiesPlugin } from '@casl/vue'
import '@core-scss/template/index.scss'
import '@styles/styles.scss'
import { createPinia } from 'pinia'
import { createApp } from 'vue'
import axios from "axios"
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

loadFonts()
// Create vue app
const app = createApp(App)
const btnoptions = {
  confirmButtonColor: '#41b882',
  cancelButtonColor: '#ff7674',
};

// Use plugins

app.mixin(commonJs)
app.use(VueSweetalert2,btnoptions)
app.use(vuetify)
app.use(createPinia())
app.use(router)
app.use(layoutsPlugin);
app.use(i18n)

app.use(abilitiesPlugin, ability, {
  useGlobalProperties: true,
})


// Mount vue app
app.mount('#app')
