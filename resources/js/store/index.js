import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate'

// base store
import state from './state'
import getters from './getters'
import mutations from './mutations'
import actions from './actions'

// modules
import auth from '../store/modules/auth.module'

Vue.use(Vuex);

export default new Vuex.Store({
    plugins: [
        createPersistedState()
    ],
    state,
    getters,
    mutations,
    actions,
    modules: {
        auth,
    }
})
