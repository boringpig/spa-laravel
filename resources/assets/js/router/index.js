import Vue from 'vue'
import routes from './routes'
import Router from 'vue-router'
// import { sync } from 'vuex-router-sync'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    routes
});

// sync(store, router)

export default router