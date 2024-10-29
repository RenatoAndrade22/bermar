// store.js

import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    enterpriseType: null,
    userName: null,
    pages: []
  },
  mutations: {
    updateEnterpriseType(state, value) {
      state.enterpriseType = value;
    },
    updateUserName(state, value){
        state.userName = value;
    },
    updatePages(state, value){
      state.pages = value;
  }
  },

  plugins: [createPersistedState()],
});

export default store;