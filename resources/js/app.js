/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue/dist/vue'
import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css' //Vuesax styles
import store from './store.js';
import axios from "axios"

window.axios = require('axios');

import LayoutFrontend from "./pages/LayoutFrontend.vue"
import { BootstrapVue } from 'bootstrap-vue'
import vmodal from 'vue-js-modal'
import VModal from 'vue-js-modal/dist/index.nocss.js'
import 'vue-js-modal/dist/styles.css'
Vue.use(vmodal)
import Vuex from 'vuex';

Vue.use(Vuex);

if (localStorage.token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.token}`;
} else {
    axios.defaults.headers.common['Authorization'] = null;
}

axios.defaults.maxContentLength = Infinity;
axios.defaults.maxBodyLength = Infinity;

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

Vue.prototype.$rules_user = []

Vue.use(VueRouter)

import VueSimpleSuggest from 'vue-simple-suggest';
import 'vue-simple-suggest/dist/styles.css'; // Importa os estilos do componente

Vue.component('vue-simple-suggest', VueSimpleSuggest);

const router = new VueRouter(routes);

router.beforeEach((to, from, next) => {

    if (to.meta.auth) {

        axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.token}`
        axios.get('/api/athenticated').then((item) => {
            store.commit('updateUserName', item.data.user.name)
            store.commit('updatePages', item.data.user.pages)
            store.commit('updateEnterpriseType', item.data.user.enterprise_type)
            next()
        }).catch((error)=>{ 
            return next({ name: 'login'})
        })
    } else {
        next()
    }
    
});

new Vue({
    el: '#app',
    router: router,
    render: h => h(LayoutFrontend),
    store
});
