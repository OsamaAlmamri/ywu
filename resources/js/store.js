import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user: JSON.parse(localStorage.getItem('user'))  || {}
    },
    mutations: {
        auth_request(state) {
            state.status = 'loading'
        },
        auth_success(state, token, user) {
            state.status = 'success'
            state.token = token
            state.user = user
        },
        auth_error(state) {
            state.status = 'error'
        },
        auth_pending(state) {
            state.status = 'pending'
        },
        logout(state) {
            state.status = ''
            state.token = ''
        },
    },
    actions: {
        login({commit}, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request')
                axios({url: '/api/login', data: user, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            commit('auth_error');
                            toastStack('   خطاء ', resp.data.msg, 'error');
                            reject(err)
                        } else {
                            const token = resp.data.data.token
                            const user = JSON.stringify(resp.data.data.userData)
                            console.log(user)
                            localStorage.setItem('user',user);
                            localStorage.setItem('token', token)
                            axios.defaults.headers.common['Authorization'] = token
                            commit('auth_success', token, user)
                            resolve(resp)
                        }
                    })
                    .catch(err => {
                        commit('auth_error')
                        localStorage.removeItem('token')
                        localStorage.removeItem('user')
                        reject(err)
                    })
            })
        }, register({commit}, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request')
                axios({url: '/api/register', data: user, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                            commit('auth_error');
                        } else if (resp.data.status == true &&
                            user.userType == 'share_user') {
                            toastStack(resp.data.msg, '', 'success');
                            commit('auth_pending');
                            resolve(resp)
                        } else {
                            const token = resp.data.data.token
                            const user = resp.data.data.userData
                            localStorage.setItem('token', token)
                            localStorage.setItem('user', user)
                            axios.defaults.headers.common['Authorization'] = token
                            commit('auth_success', token, user)
                            resolve(resp)
                        }
                    })
                    .catch(err => {
                        commit('auth_error', err)
                        localStorage.removeItem('token')
                        reject(err)
                    })
            })
        }, logout({commit}) {
            return new Promise((resolve, reject) => {
                commit('logout')
                localStorage.removeItem('token')
                delete axios.defaults.headers.common['Authorization']
                resolve()
            })
        }
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
        authUser: state => state.user,
    }
})
