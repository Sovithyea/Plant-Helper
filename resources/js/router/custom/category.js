export default [
    {
        path: '/category',
        name: 'category.index',
        component: () => import('./../../views/category/Index.vue')
    },
    {
        path: '/category/create',
        name: 'category.create',
        component: () => import('./../../views/category/Create.vue')
    },
    {
        path: '/category/:category/edit',
        name: 'category.edit',
        component: () => import('./../../views/category/Edit.vue')
    },
    {
        path: '/category/:category/show',
        name: 'category.show',
        component: () => import('./../../views/category/Show.vue')
    },
    // {
    //     path: '/setting',
    //     name: 'setting',
    //     component: () => import('./../../views/Setting.vue')
    // },
]
