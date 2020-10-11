import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    namespace:true,
    state: {
        isLoggedIn: !!localStorage.getItem('token')
    },
    // getters()
    // {
    //     authenticated()
    //     {
    //         return  !!localStorage.getItem('token')
    //     },
    //     user()
    //     {
    //         return localStorage.getItem('user_data');
    //     }
    // }
    mutations: {
        loginUser (state) {
            state.isLoggedIn = true
        },
        logoutUser (state) {
            state.isLoggedIn = false
        },
    }
})
