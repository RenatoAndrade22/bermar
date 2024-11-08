// store.js

import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    globalVariable: null,
  },
  mutations: {
    updateGlobalVariable(state, value) {
      state.globalVariable = value;
    },
  },
});
