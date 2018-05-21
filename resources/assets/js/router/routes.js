export default ({ authGuard, guestGuard }) => [
  
    // Authenticated routes.
    ...authGuard([
        { path: '/', name: 'home', component: require('../pages/home.vue') },
        { path: '/user-manage', 
            component: require('../pages/user-manage/users.vue'),
            children: [
                { path: '', redirect: {name: 'users'}},
                { path: 'users', name: 'users', component: require('../pages/user-manage/users.vue') },
                { path: 'roles', name: 'roles', component: require('../pages/user-manage/roles.vue') },
            ]
        },
    ]),
  
    // Guest routes.
    ...guestGuard([
      { path: '/login', name: 'login', component: require('../pages/auth/login.vue') },
      { path: '/register', name: 'register', component: require('../pages/auth/register.vue') },
    //   { path: '/password/reset', name: 'password.request', component: require('~/pages/auth/password/email.vue') },
    //   { path: '/password/reset/:token', name: 'password.reset', component: require('~/pages/auth/password/reset.vue') }
    ]),
  
    { path: '*', component: require('../pages/errors/404.vue') }
]
  