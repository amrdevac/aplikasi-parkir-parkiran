require("./bootstrap");
require("../sass/app.scss");

window.bootstrap = require("bootstrap/dist/js/bootstrap.bundle.js");

window.btn_kelola = (bol) => {
    let button = document.getElementsByClassName("btn-submit-data");
    [].slice
        .bind(button)()
        .forEach(function (element) {
            if (bol) {
                element.classList.add("disabled");
            } else {
                element.classList.remove("disabled");
            }
        });
};

window.Vue = require("vue").default;
import Vue from "vue";

import VueDayjs from "vue-dayjs-plugin";
Vue.use(VueDayjs);

Vue.filter("number_format", function (value) {
    let data = parseInt(value);
    return data.toLocaleString("id-ID");
});

Vue.filter("parking_status", function (value) {
    if (value == 1) {
        return '<span class="badge bg-secondary">Keluar</span>';
    }
    if (value == 0) {
        return '<span class="badge bg-success">Aktif</span>';
    }
});

Vue.filter("status_karyawan", function (value) {
    if (value == 1) {
        return '<span class="badge bg-success">Aktif</span>';
    }
    if (value == 0) {
        return '<span class="badge bg-secondary">Suspend</span>';
    }
});

Vue.filter("role_status", function (value) {
    if (value == 1) {
        return '<span class="badge bg-primary">Admin</span>';
    }
    if (value == 0) {
        return '<span class="badge bg-secondary">Users</span>';
    }
});

import VueRouter from "vue-router";
Vue.use(VueRouter);

import "sweetalert2/dist/sweetalert2.min.css";
import VueSweetalert2 from "vue-sweetalert2";
Vue.use(VueSweetalert2);

import { Form } from "vform";
window.Form = Form;

import router from "./routeConfig.js";
window.router = router;

import VueSidebarMenuAkahon from "vue-sidebar-menu-akahon";
Vue.component("vue-sidebar-menu-akahon", VueSidebarMenuAkahon);

import generalUtils from "./config/utils/generalUtils";
Vue.prototype.$utils = new generalUtils();

import toast from "./config/alert/toast";
Vue.prototype.$toast = new toast();

import konfirmasiPembayaran from "./config/utils/konfirmasiUtis";
window.konfirmasiPembayaran = konfirmasiPembayaran;

import emitUtils from "./config/utils/emitUtils";
Vue.prototype.$emitUtils = new emitUtils();
window.emitBy = new Vue();

import money from "v-money";
Vue.use(money, {
    decimal: ",",
    thousands: ".",
    prefix: "Rp ",
    suffix: " ",
    precision: 0,
});

const app = new Vue({
    el: "#app",
    router,
});
