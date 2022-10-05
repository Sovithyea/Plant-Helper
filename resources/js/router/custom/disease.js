export default [
    {
        path: '/disease',
        name: 'disease.index',
        component: () => import('./../../views/disease/Index.vue')
    },
    {
        path: '/disease/create',
        name: 'disease.create',
        component: () => import('./../../views/disease/Create.vue')
    },
    {
        path: '/disease/:disease/edit',
        name: 'disease.edit',
        component: () => import('./../../views/disease/Edit.vue')
    },
    {
        path: '/disease/:disease/show',
        name: 'disease.show',
        component: () => import('./../../views/disease/Show.vue')
    },
    // {
    //     path: '/setting',
    //     name: 'setting',
    //     component: () => import('./../../views/Setting.vue')
    // },
]
