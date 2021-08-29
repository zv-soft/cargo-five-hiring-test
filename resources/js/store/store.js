import Vue from 'vue'
import Vuex from 'vuex'

import login from './login'
import contract from './contract'

Vue.use(Vuex)


export const store = new Vuex.Store({

    modules:{
        login,
        contract,
    }

})
