/*jshint esversion: 6 */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'

// app.js
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue)

import Total from "./components/total";
import Navbar from "./components/navbar";

Vue.component("total", Total);
Vue.component("navbar", Navbar);

const routes = [
    {
        path: "/",
        component: Total
    },

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
