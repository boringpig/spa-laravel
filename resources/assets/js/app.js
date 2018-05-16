import Vue from 'vue'
import Vuetify from 'vuetify'
import VeeValidate from 'vee-validate'
import 'vuetify/dist/vuetify.min.css'
import router from './router'
import App from './components/App'
import i18n from './plugins/vue-i18n'

Vue.use(Vuetify)
Vue.use(VeeValidate, { 
  locale: 'cn',
  dictionary: {
    cn: {
      attributes: {
        username: '帐号'
      },
      messages: {
        required: () => '不能為空'
      }
    },
  }
})

Vue.config.productionTip = false

new Vue({
  el: '#app',
  router,
  i18n,
  ...App
})

