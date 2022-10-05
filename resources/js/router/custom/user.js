export default [
    {
        path: "/user",
        name: "user.index",
        component: () => import("./../../views/user/Index.vue"),
    },
    {
        path: "/user/create",
        name: "user.create",
        component: () => import("./../../views/user/Create.vue"),
    },
    {
        path: "/user/:user/edit",
        name: "user.edit",
        component: () => import("./../../views/user/Edit.vue"),
    },
    {
        path: "/user/:user/show",
        name: "user.show",
        component: () => import("./../../views/user/Show.vue"),
    },
    {
        path: "/user/trash",
        name: "user.trash",
        component: () => import("./../../views/user/Trash.vue"),
    },
    {
        path: "/setting",
        name: "setting",
        component: () => import("./../../views/Setting.vue"),
    },
    {
        path: "/comment",
        name: "comment.index",
        component: () => import("./../../views/comment/Index.vue"),
    },
    {
        path: "/comment/:comment/show",
        name: "comment.show",
        component: () => import("./../../views/comment/Show.vue"),
    },
];
