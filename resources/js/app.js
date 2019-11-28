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

import TotalComponent from "./components/total.vue";
const total = Vue.component("total-component", TotalComponent);

import LoginComponent from "./components/login.vue";
const login = Vue.component("login-component", LoginComponent);

import RegisterComponent from "./components/register.vue";
const register = Vue.component("register-component", RegisterComponent);

import NavbarComponent from "./components/navbar.vue";
const navbar = Vue.component("navbar-component", NavbarComponent);

const routes = [
    {
        path: "/",
        component: total
    },
    {
        path: "/login",
        component: login
    },
    {
        path: "/register",
        component: register
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
}).$mount('#app')
