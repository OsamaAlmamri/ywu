require('./bootstrap');
import router from './routes';
import VueClazyLoad from 'vue-clazy-load' ;
window.Vue = require('vue');
Vue.use(VueClazyLoad) ;
Vue.component('course-component', require('./components/CourseComponent.vue').default);
Vue.component('search-filed', require('./components/SearchField.vue').default);
Vue.component('course-questions', require('./components/Question.vue').default);

const app = new Vue({
    el: '#app',
    router
});
