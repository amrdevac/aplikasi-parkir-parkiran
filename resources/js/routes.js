const home = () => import("../views/vue/page/homepage.vue");
const dashboard = () => import("../views/vue/page/dashboard.vue");
const parkingIn = () => import("../views/vue/page/parkingIn.vue");
const parkingOut = () => import("../views/vue/page/parkingOut.vue");
const parkingList = () => import("../views/vue/page/parkingList.vue");
const karyawan = () => import("../views/vue/page/karyawan.vue");
const karyawanTambah = () => import("../views/vue/page/karyawanTambah.vue");
const notFound = () => import("../views/vue/page/notFound.vue");

let routes = [
    {
        path: "/",
        component: home,
        name: "homepage",
    },
];

if (window.user) {
    routes = [];
    if (window.user.role == 1) {
        routes.push(
            {
                path: "/dashboard",
                component: dashboard,
                name: "dashboard",
            },

            {
                path: "/parking-in",
                component: parkingIn,
                name: "parking-in",
            },
            {
                path: "/parking-out",
                component: parkingOut,
                name: "parking-out",
            },
            {
                path: "/parking-list",
                component: parkingList,
                name: "parking-list",
            },
            {
                path: "/karyawan",
                component: karyawan,
                name: "parking-list",
            },
            {
                path: "/karyawan/tambah",
                component: karyawanTambah,
                name: "parking-list",
            }
        );
    }

    if (window.user.role == 0) {
        routes.push(
            {
                path: "/dashboard",
                component: dashboard,
                name: "dashboard",
            },

            {
                path: "/parking-in",
                component: parkingIn,
                name: "parking-in",
            },
            {
                path: "/parking-out",
                component: parkingOut,
                name: "parking-out",
            }
        );
    }
}

routes.push({
    path: "/*",
    component: notFound,
    name: "notfound",
});

export default routes;
