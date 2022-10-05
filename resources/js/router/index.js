import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../store';
import user from './custom/user';
import guest from './custom/guest';
import category from './custom/category'
import condition from './custom/condition';
import crop from './custom/crop';
import disease from './custom/disease';
import activity from './custom/activity';
// import guide from './custom/guide';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            component: () => import('./../views/layouts/App.vue'),
            children: [
                { path: '/', redirect: { name: 'home' } },
                {
                    path: '/dashboard',
                    name: 'home',
                    component: () => import('./../views/Dashboard.vue')
                },

                ...user,
                ...category,
                ...condition,
                ...crop,
                ...disease,
                ...activity,
                // ...guide
            ]
        },

        {
            path: '/',
            component: () => import('./../views/layouts/Guest.vue'),
            children: [
                ...guest,
            ]
        }

    ]
});

router.beforeEach((to, from, next) => {
    const guestRoute = ['login', 'register', 'forget', 'password.reset']
    if (store.state.auth.authenticated) {
        if (guestRoute.includes(to.name)) next({ name: 'home' })
        else next()
    } else {
        if (guestRoute.includes(to.name) || to.name == 'farm.monitoring') next()
        else next({ name: 'login' })
    }
})

export default router;
