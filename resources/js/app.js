require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import routes from './routes';
import VueClazyLoad from 'vue-clazy-load' ;
Vue.use(VueRouter);

Vue.use(VueClazyLoad) ;
// ES6 (Babel and others)
Vue.component('course-component', require('./components/CourseComponent.vue').default);
Vue.component('search-filed', require('./components/SearchField.vue').default);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes)
});
