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

import VueSocketIO from "vue-socket.io";

import { Bar } from 'vue-chartjs';

Vue.use(
    new VueSocketIO({
        debug: true,
        connection: "http://127.0.0.1:8080"
    })
);

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

import OperatorComponent from "./components/operator";
const operator = Vue.component("operator-component", OperatorComponent);

require('moment/moment.js');

Vue.component('pagination', require('laravel-vue-pagination'));

import Vuex from 'vuex'
Vue.use(Vuex);
import 'es6-promise/auto'

import Toasted from 'vue-toasted';
Vue.use(Toasted, {
    position: "bottom-center",
    duration: 5000,
    type: "info"
});

import { BImg } from 'bootstrap-vue'
Vue.component('b-img', BImg)

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
    },
    {
        path: "/operator",
        component: operator
    }
];

const router = new VueRouter({
    routes
});

const app = new Vue({
    el: "#app",
    router,
    store,
    sockets: {
        privateMessage(dataFromServer) {
            let name =
                dataFromServer[1] === null ? "Unknown" : dataFromServer[1].name;
            this.$toasted.show(
                'Message "' + dataFromServer[0] + '" sent from "' + name + '"'
            );
        },
        privateMessage_unavailable(destUser) {
            this.$toasted.error(
                'User "' + destUser.name + '" is not available'
            );
        },
        privateMessage_sent(dataFromServer) {
            this.$toasted.success(
                'Message "' +
                    dataFromServer[0] +
                    '" was sent to "' +
                    dataFromServer[1].name +
                    '"'
            );
        },
    },
    created() {
        console.log("Starting APP");
        console.log(this.$store.state.user);
        this.$store.commit("loadTokenAndUserFromSession");
        console.log(this.$store.state.user);
    }
}).$mount('#app');
