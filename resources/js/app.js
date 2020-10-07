require('./bootstrap');
import 'es6-promise/auto';
import axios from 'axios';
import VueAuth from '@websanova/vue-auth';
import VueAxios from 'vue-axios'
import auth from './auth';
import VueRouter from 'vue-router';
import routes from './routes';
import VueClazyLoad from 'vue-clazy-load' ;
window.Vue = require('vue');
Vue.use(VueRouter);
Vue.use(VueAxios);
Vue.use( axios);
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api` ;
// Vue.use(VueAuth);
// Vue.use(VueAuth, auth);
Vue.use(VueClazyLoad) ;
// ES6 (Babel and others)
Vue.component('course-component', require('./components/CourseComponent.vue').default);
Vue.component('search-filed', require('./components/SearchField.vue').default);
Vue.component('course-questions', require('./components/Question.vue').default);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes)
});
