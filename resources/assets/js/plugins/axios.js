import axios from 'axios'
import store from '../stores'
import router from '../router'
import i18n from './vue-i18n'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// 請求攔截器
axios.interceptors.request.use(
    config => {
        if (store.getters.authToken) {
            config.headers.common['Authorization'] = `Bearer ${store.getters.authToken}`
        }
        return config;
    },
    err => {
        return Promise.reject(err)
    }
)

// 回應攔截器
axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        const { status } = error.response
        if(status == 401) {
            if(store.getters.authCheck) {
                logout: async() => {
                    store.dispatch('responseMessage', {
                        type: 'error',
                        text: i18n.t('token_expired_alert_text'),
                        title: i18n.t('token_expired_alert_title'),
                        modal: true
                    }).then(async () => {
                        await store.dispatch('logout')
    
                        router.push({ name: 'login' })
                    })
                }
            } else {
                store.dispatch('responseMessage', {
                    type: 'error',
                    text: i18n.t('no-username'),
                    title: i18n.t('login-fail'),
                    modal: true
                })
            }
        }
        
        return Promise.reject(error.response.data)
    }
)

export default axios;