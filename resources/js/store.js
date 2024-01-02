// store.js

import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    userRules: null,
    userName: null
  },
  mutations: {
    updateUserRules(state, value) {
      state.userRules = value;
    },
    updateUserName(state, value){
        state.userName = value;
    }
  },

  plugins: [createPersistedState()],
});

export default store;