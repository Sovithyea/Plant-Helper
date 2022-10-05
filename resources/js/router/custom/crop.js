export default [
    {
        path: '/crop',
        name: 'crop.index',
        component: () => import('./../../views/crop/Index.vue')
    },
    {
        path: '/crop/create',
        name: 'crop.create',
        component: () => import('./../../views/crop/Create.vue')
    },
    {
        path: '/crop/:crop/edit',
        name: 'crop.edit',
        component: () => import('./../../views/crop/Edit.vue')
    },
    {
        path: '/crop/:crop/show',
        name: 'crop.show',
        component: () => import('./../../views/crop/Show.vue'),
    },
    {
        path: '/crop/:crop/createDisease',
        name: 'crop.createDisease',
        component: () => import('./../../views/crop/createDisease.vue')
    },
    {
        path: '/crop/:crop/createCondition',
        name: 'crop.createCondition',
        component: () => import('./../../views/crop/createCondition.vue')
    },
    {
        path: '/crop/:crop/createActivity',
        name: 'crop.createActivity',
        component: () => import('./../../views/crop/createActivity.vue')
    },
    {
        path: '/crop/:crop/condition/:condition/edit',
        name: 'cropCondition.edit',
        component: () => import('./../../views/crop/cropConditionEdit.vue')
    },
    // {
    //     path: '/setting',
    //     name: 'setting',
    //     component: () => import('./../../views/Setting.vue')
    // },
]
