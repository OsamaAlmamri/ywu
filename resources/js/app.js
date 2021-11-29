require('./bootstrap');
import Axios from 'axios'
import router from './routes';
import VueClazyLoad from 'vue-clazy-load' ;
import store from "./store";
import SweetModal from 'sweet-modal-vue/src/plugin.js'
import VueLazyLoad from 'vue-lazyload'
import i18n from "./plugins/vue-i18n";

window.Vue = require('vue');
Vue.use(VueClazyLoad);
Vue.use(VueLazyLoad)
Vue.component('course-component', require('./components/CourseComponent.vue').default);
Vue.component('search-filed', require('./components/SearchField.vue').default);
Vue.component('course-questions', require('./components/Question.vue').default);
Vue.component('toast-stack', require('./components/ToastStack.vue').default);
Vue.component('recent-posts', require('./components/RecentPosts.vue').default);
Vue.component('dropdown', require('./components/dropdown.vue').default);
Vue.component('ShopCategory', require('./components/ShopCategory.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));


var api_url = process.env.MIX_APP_URL;

Vue.prototype.$http = Axios;
Vue.use(SweetModal)

Axios.defaults.baseURL = api_url;
Axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

const token = localStorage.getItem('token')
if (token) {
    Vue.prototype.$http.defaults.headers.common['Authorization'] = 'Bearer ' + token
}
Vue.prototype.$scrollToTop = () => window.scrollTo(0, 0);
// if (process.env.MIX_ENV_MODE === 'production') {
//     Vue.config.devtools = false;
//     Vue.config.debug = false;
//     Vue.config.silent = true;
// }

Vue.mixin({
    data() {
        return {
            BaseImagePath: 'https://yemenwe.com/'
            // BaseImagePath: '/assets/images/'
        };
    },
    methods: {
        countWords: function (text, no_words) {
            var str = text.replace(/(^\s*)|(\s*$)/gi, "");
            str = str.replace(/[ ]{2,}/gi, " ");
            str = str.replace(/\n /, "\n");
            var words = str.split(' ').length;
            return {
                'words': words,
                'newText': str.split(" ").splice(0, no_words).join(" "),
                'isMore': (words > no_words)
            };
        },
        scrollToTop: function () {
            window.scrollTo(0, 0);
            var div = document.querySelector('body');
            div.classList.remove('mobile-menu-visible');

        },
        getImageType: function (type) {
            switch (type) {
                case 1:
                    return "site/images/t/phsycho.png";
                    break;
                case 2:
                    return "site/images/t/issue.png";
                    break;
                case 3:
                    return "site/images/t/law.png";
                    break;
                default :
                    return "site/images/t/phsycho.png";

            }
        }
    },
    computed: {
        ShowPublickSearchFiled: function () {
            if ((this.$route.name == 'shop_seller') || (this.$route.name == 'shop_search') || (this.$route.name == 'shop') || (this.$route.name == 'home') || (this.$route.name == 'home2') || (this.$route.name == 'courses') || (this.$route.name == 'women') || (this.$route.name == 'consultant'))
                return false;

            return true;
        }

    }
});
const MyPlugin = {
    install(Vue, options) {
        Vue.prototype.getFirst20Word = (text) => {
            text = text.replace(/<(.|\n)*?>/g, '');
            return text.substr(0, 100) + ' ...';
        };


    },

}
Vue.use(MyPlugin)
const app = new Vue({
    el: '#my_site_app',

    computed: {
        isLoggedIn: function () {
            return store.getters.isLoggedIn
        },
        authUser: function () {
            return store.getters.authUser
        },
        currentPage: function () {
            return this.$route.name
        }
    },
    methods: {
        // scrollToTop: function () {
        //     window.scrollTo(0, 0);
        //     const div =  document.querySelector('body');
        //     div.classList.remove('mobile-menu-visible');
        //
        // },
        logout: function () {
            this.$store.dispatch('logout')
                .then(() => {
                    this.$router.push('/home')
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
    i18n,
    router
});
