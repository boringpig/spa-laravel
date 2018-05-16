import Vue from 'vue'
import routes from './routes'
import Router from 'vue-router'
// import { sync } from 'vuex-router-sync'

Vue.use(Router)

const router = make(
    routes({ authGuard, guestGuard })
)

// sync(store, router)

export default router

/**
 * Create a new router instance.
 *
 * @param  {Array} routes
 * @return {Router}
 */
function make(routes) {
    const router = new Router({
        mode: 'history',
        routes
    })

    // Register before guard.
    // router.beforeEach(async (to, from, next) => {
    //     if (!store.getters.authCheck && store.getters.authToken) {
    //         try {
    //             await store.dispatch('fetchUser')
    //         } catch (e) { }
    //     }

    //     setLayout(router, to)
    //     next()
    // })

    // Register after hook.
    // router.afterEach((to, from) => {
    //     router.app.$nextTick(() => {
    //         router.app.$loading.finish()
    //     })
    // })

    return router
}

/**
 * Redirect to login if guest.
 *
 * @param  {Array} routes
 * @return {Array}
 */
function authGuard(routes) {
    return beforeEnter(routes, (to, from, next) => {
        // if (!store.getters.authCheck) {
        //     next({
        //         name: 'login',
        //         query: { redirect: to.fullPath }
        //     })
        // } else {
            next()
        // }
    })
}

/**
 * Redirect home if authenticated.
 *
 * @param  {Array} routes
 * @return {Array}
 */
function guestGuard(routes) {
    return beforeEnter(routes, (to, from, next) => {
        // if (store.getters.authCheck) {
        //     next({ name: 'home' })
        // } else {
            next()
        // }
    })
}

/**
 * Apply beforeEnter guard to the routes.
 *
 * @param  {Array} routes
 * @param  {Function} beforeEnter
 * @return {Array}
 */
function beforeEnter(routes, beforeEnter) {
    return routes.map(route => {
        return { ...route, beforeEnter }
    })
}