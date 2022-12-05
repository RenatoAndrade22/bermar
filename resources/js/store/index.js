
import Vue from "vue"
import Vuex from "vuex"

Vue.use(Vuex)

export const store = new Vuex.Store({
    state:{
        users: {
            name: 'RENATO TESTANDO'
        }
    },
    getters: {
        users: (state) => {
            return state.users
        }
    },
    mutations: {
        set_users: (state, data) => {
            state.users = data
        }
    },
    actions: {
        get_users: (context) => {
            context.commit('set_users', {name: 'jailson'})
        }
    },

})

