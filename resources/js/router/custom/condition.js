export default [
    {
        path: '/condition',
        name: 'condition.index',
        component: () => import('./../../views/condition/Index.vue')
    },
    {
        path: '/condition/create',
        name: 'condition.create',
        component: () => import('./../../views/condition/Create.vue')
    },
    {
        path: '/condition/:condition/edit',
        name: 'condition.edit',
        component: () => import('./../../views/condition/Edit.vue')
    },
    {
        path: '/condition/:condition/show',
        name: 'condition.show',
        component: () => import('./../../views/condition/Show.vue')
    },
    // {
    //     path: '/setting',
    //     name: 'setting',
    //     component: () => import('./../../views/Setting.vue')
    // },
]
