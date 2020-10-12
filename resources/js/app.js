require('./bootstrap');
import router from './routes';
import VueClazyLoad from 'vue-clazy-load' ;

window.Vue = require('vue');
Vue.use(VueClazyLoad);

Vue.component('course-component', require('./components/CourseComponent.vue').default);
Vue.component('search-filed', require('./components/SearchField.vue').default);
Vue.component('course-questions', require('./components/Question.vue').default);
Vue.component('nav-header', require('./components/navHeader.vue').default);
Vue.component('toast-success', require('./components/ToastSuccess.vue').default);
Vue.component('toast-error', require('./components/ToastError.vue').default);
Vue.component('toast-stack', require('./components/ToastStack.vue').default);

import Axios from 'axios'

Vue.prototype.$http = Axios;
import store from "./store";
var api_url = process.env.MIX_APP_URL;
Axios.defaults.baseURL = api_url;
Axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

const token = localStorage.getItem('token')
if (token) {
    Vue.prototype.$http.defaults.headers.common['Authorization'] = 'Bearer ' + token
}


const app = new Vue({
    el: '#app',
    // methods:
    //     {
    //         is_login: function () {
    //             return this.$store.isLoggedIn;
    //         }
    //     },
    computed: {
        isLoggedIn: function () {
            return store.getters.isLoggedIn
        },
        authUser: function () {
            return store.getters.authUser
        }
    },
    methods: {
        logout: function () {
            this.$store.dispatch('logout')
                .then(() => {
                    this.$router.push('/login')
                })
        }
    },
    created: function () {
        this.$http.interceptors.response.use(undefined, function (err) {
            return new Promise(function (resolve, reject) {
                if (err.status === 401 && err.config && !err.config.__isRetryRequest) {
                    this.$store.dispatch(logout)
                }
                throw err;
            });
        });
    },
    // created() {
    //     if (store.state.isLoggedIn) {
    //         axios.post('api/user')
    //             .then(response => {
    //                 this.$store.commit('setUser', response.data);
    //             })
    //             .catch(error => {
    //                 this.$store.commit('logoutUser');
    //                 this.$router.push({name: 'login'});
    //             });
    //     }
    // },

    router
});
