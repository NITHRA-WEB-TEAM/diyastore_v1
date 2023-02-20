<script setup>
import NavBarI18n from '@core/components/I18n.vue'
import {useThemeConfig} from '@core/composable/useThemeConfig'

const {isAppRtl} = useThemeConfig()

// const Languages = [
//   {
//     label: 'English',
//     lang_id: '1',
//   },
//   {
//     label: 'Tamil',
//     lang_id: '2',
//   },
//   {
//     label: 'Telugu',
//     lang_id: '3',
//   },
//   {
//     label: 'Hindi',
//     lang_id: '4',
//   },
//   {
//     label: 'Kannada',
//     lang_id: '5',
//   },
// ]

const handleLangChange = lang => {
  alert('hello')
  isAppRtl.value = lang === 'ar'
}
const props = defineProps({
  location: {
    type: null,
    required: false,
    default: 'bottom end',
  },
})

const emit = defineEmits(['change'])

const {locale} = useI18n({useScope: 'global'})
</script>

<template>
  <VBtn
    icon
    variant="text"
    color="default"
    size="small"
  >
    <img alt :src="limage" class="img-fluid"
         style="width: 25px">
    <!--    <VIcon-->
    <!--      icon="tabler-language"-->
    <!--      size="24"-->
    <!--    />-->

    <!-- Menu -->
    <VMenu
      activator="parent"
      offset="14px"
    >
      <!-- List -->
      <VList min-width="175px">
        <!-- List item -->
        <VListItem
          v-for="lang in this.languages"
          :key="lang.lang_id"
          :value="lang.lang_id"
          @click="siteLanguage(lang.id,lang.lname,lang.lang_image)"
        >
          <!--          @click="locale = lang.lang_id; $emit('change', lang.lang_id)"-->
          <!-- Language label -->
          <VListItemTitle><img alt :src="lang.lang_image" class="img-fluid"
                               style="width: 25px;margin: 0px 7px -7px 0px;">{{ lang.lname }}
          </VListItemTitle>
        </VListItem>
      </VList>
    </VMenu>
  </VBtn>
</template>
<script>
import axios from "axios";

export default {
  data() {
    return {
      languages: [],
      lang_id: '1',
      lname: 'English',
      limage: 'https://d3c16wgne86swu.cloudfront.net/images/language%20icon/fr.png'
    }
  },
  created() {
    if (localStorage.lang_id) {
      this.langid = localStorage.lang_id
    } else {
      localStorage.setItem("lang_id", JSON.stringify(1));
      this.langid = localStorage.lang_id
    }
    localStorage.lname ? this.lname = localStorage.lname.replaceAll('"', '') : 'English'
    localStorage.limage ? this.limage = localStorage.limage.replaceAll('"', '') : 'https://d3c16wgne86swu.cloudfront.net/images/language%20icon/fr.png'

    axios.post('http://192.168.58.42:3000/api/site/action', {action: 'LanguageList'})
      .then(result => {
        this.languages = result.data
        // console.log(result.data)
        // localStorage.setItem("lang_id", JSON.stringify(1));

      });
  },
  methods: {
    siteLanguage: function (lid, lname, limage) {
      if (localStorage.lang_id) {
        if (localStorage.lang_id == lid) {
          this.lang_id = localStorage.lang_id
          localStorage.setItem("lname", JSON.stringify(lname));
          localStorage.setItem("limage", JSON.stringify(limage));
        } else {
          localStorage.setItem("lang_id", JSON.stringify(lid));
          localStorage.setItem("lname", JSON.stringify(lname));
          localStorage.setItem("limage", JSON.stringify(limage));
        }
      } else {
        localStorage.setItem("lang_id", JSON.stringify(lid));
        localStorage.setItem("lname", JSON.stringify(lname));
        localStorage.setItem("limage", JSON.stringify(limage));
      }
      location.reload();
    },
  }
}
</script>
