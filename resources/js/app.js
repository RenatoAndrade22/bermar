/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue/dist/vue'
import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css' //Vuesax styles

import axios from "axios"

window.axios = require('axios');

import LayoutFrontend from "./pages/LayoutFrontend.vue"
import { BootstrapVue } from 'bootstrap-vue'
import vmodal from 'vue-js-modal'
import VModal from 'vue-js-modal/dist/index.nocss.js'
import 'vue-js-modal/dist/styles.css'
Vue.use(vmodal)

if (localStorage.token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.token}`;
    let user = JSON.parse(localStorage.user)
    Vue.prototype.$user = user
} else {
    axios.defaults.headers.common['Authorization'] = null;
}

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import VueToast from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-sugar.css'
import 'material-icons/iconfont/material-icons.css'

Vue.use(Vuesax, {
    // options here
})

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
Vue.use(VueToast)

import collect from "collect.js";
Vue.prototype.$c = collect

window.Vue = Vue

import VueRouter from "vue-router";
import routes from "./routes";
// Vue.component('layout-frontend', require('./layout/Layout').default);

Vue.use(VueRouter)

app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    render: h => h(LayoutFrontend),
}).$mount('#app');
