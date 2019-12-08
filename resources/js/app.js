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

Vue.use(BootstrapVue);

import store from "./stores/global-store";

import TotalComponent from "./components/total.vue";
const total = Vue.component("total-component", TotalComponent);

import LoginComponent from "./components/login.vue";
const login = Vue.component("login-component", LoginComponent);

import RegisterComponent from "./components/register.vue";
const register = Vue.component("register-component", RegisterComponent);

import NavbarComponent from "./components/navbar.vue";
const navbar = Vue.component("navbar-component", NavbarComponent);

import LoggedUserComponent from "./components/loggeduser";
const logged = Vue.component("logged-component", LoggedUserComponent);

import UsersComponent from "./components/user";
const users = Vue.component("users-component", UsersComponent);

import Vuex from 'vuex'
Vue.use(Vuex);
import 'es6-promise/auto'

import Toasted from 'vue-toasted';
Vue.use(Toasted);


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
    },
    {
        path: "/wallet",
        component: logged
    },
    {
        path: "/users",
        component: users
    }
];

const router = new VueRouter({
    routes
});

const app = new Vue({
    el: "#app",
    router,
    store,
    data: {
        user:null,
        token:''
    },
    methods: {
        persist() {
            localStorage.user = this.user;
            localStorage.token = this.token;

            console.log(this.token);
        }


    },
    mounted() {
        if (localStorage.user) {
            this.user = localStorage.user;
        }
        if (localStorage.token) {
            this.token = localStorage.token;
        }
    },
    created() {
        console.log("Starting APP");
        console.log(this.$store.state.user);
        //this.$store.commit("loadDepartments");
        this.$store.commit("loadTokenAndUserFromSession");
        console.log(this.$store.state.user);
    }
}).$mount('#app');
