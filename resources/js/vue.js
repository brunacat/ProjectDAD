/*jshint esversion: 6 */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("../../../../../Users/ZenBook/Downloads/05_Laravel_Vue_Updated_Base/resources/js/bootstrap");

window.Vue = require("resources/js/vue");
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Users from "../../../../../Users/ZenBook/Downloads/05_Laravel_Vue_Updated_Base/resources/js/components/user";
import Departments from "../../../../../Users/ZenBook/Downloads/05_Laravel_Vue_Updated_Base/resources/js/components/department";

Vue.component("user", Users);

const routes = [
    {
        path: "./",
        component: Users
    },
    {
        path: "./",
        component: Departments
    }
];

const router = new VueRouter({
    routes
});

const app = new Vue({
    el: "#app",
    router,
    data: {},
    methods: {}
});
