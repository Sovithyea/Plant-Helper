export default [
    {
        path: '/activity',
        name: 'activity.index',
        component: () => import('./../../views/activity/Index.vue')
    },
    {
        path: '/activity/create',
        name: 'activity.create',
        component: () => import('./../../views/activity/Create.vue')
    },
    {
        path: '/activity/:activity/edit',
        name: 'activity.edit',
        component: () => import('./../../views/activity/Edit.vue')
    },
    {
        path: '/activity/:activity/show',
        name: 'activity.show',
        component: () => import('./../../views/activity/Show.vue')
    },
    // {
    //     path: '/setting',
    //     name: 'setting',
    //     component: () => import('./../../views/Setting.vue')
    // },
]
