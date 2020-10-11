require('./bootstrap');
import router from './routes';
import VueClazyLoad from 'vue-clazy-load' ;

window.Vue = require('vue');
Vue.use(VueClazyLoad);
import storege from './storage' ;

Vue.component('course-component', require('./components/CourseComponent.vue').default);
Vue.component('search-filed', require('./components/SearchField.vue').default);
Vue.component('course-questions', require('./components/Question.vue').default);
import mapGetter from 'vuex'

const app = new Vue({
    el: '#app',
    data() {
        return {
            loginUser: store.state.isLoggedIn,

        }
    },
    // computed: {
    //     mapGetter({
    //                   authenticated:'storege/authenticated',
    //                   user:'storege/user'
    //               })
    //
    // },
    router
});
