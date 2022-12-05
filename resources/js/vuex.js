import Vue from "vue"
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state:{
        token: 'ESSE É O TOKEN'
    }
})

export { store }