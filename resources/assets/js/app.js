import Vue from 'vue'
import Vuetify from 'vuetify'
import VeeValidate from 'vee-validate'
import 'vuetify/dist/vuetify.min.css'
import router from './router'
import App from './components/App'
import './plugins/vee-validation'
import axios from './plugins/axios'
import i18n from './plugins/vue-i18n'
import store from './stores'

Vue.use(Vuetify)

Vue.config.productionTip = false
Vue.prototype.axios = axios;

new Vue({
  el: '#app',
  router,
  i18n,
  store,
  axios,
  ...App
})

