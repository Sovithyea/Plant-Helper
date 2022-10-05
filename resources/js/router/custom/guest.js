

export default [
    {
        name: 'login',
        path: '/login',
        component: () => import('../../views/auth/Login.vue')
    },
    {
        path: '/forget',
        name: 'forget',
        component: () => import('../../views/auth/ForgetPassword.vue')
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../../views/auth/Register.vue')
    },
    {
        path: '/reset-password/:token',
        name: 'password.reset',
        component: () => import('../../views/auth/ResetPassword.vue')
    },
    {
        name: '404',
        path: '/404',
        component: () => import('./../../views/errors/PageNotFound.vue')
    },
    {
        name: 'error',
        path: '/error',
        component: () => import('./../../views/errors/PageNotFound.vue')
    },
    // page not found handler
    { path: "*", component: () => import('./../../views/errors/PageNotFound.vue') }
]
