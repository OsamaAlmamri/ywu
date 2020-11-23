import Home from './components/Home';
import About from './components/About';
import Register from './components/Register';
import Login from './components/Login';
import Dashboard from './components/Dashboard';
import NotFound from './components/NotFound';
import Course from './components/CourseComponent';
import concatUs from './components/ConcatUs';
import Privacy from './components/Privacy';
import CourseDetails from './components/CourseDeatailsComponent';
import LogoutComponent from './components/Logout';
import Profile from './components/Profile';
import women from './components/WomenComponent';
import shop from './components/Shop';
import shop_search from './components/ShopSearch';
import my_orders from './components/MyOrders';
import shop_like from './components/MyLikeProducts';
import cart from './components/CartComponent';
import CategoryProducts from './components/CategoryProducts';
import ConsultantComponent from './components/ConsultantComponent';
import ProductDeatailsComponent from './components/ProductDeatailsComponent';
// import Co from './components/';
import WomenDeatails from './components/WomenDeatails';
import store from './store';

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter)
const routes = [
    {
        path: '*',
        component: NotFound
    },
    {
        path: '/CategoryProducts/:id',
        component: CategoryProducts,
        name: "CategoryProducts",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/shop_search',
        component: shop_search,
        name: "shop_search",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/cart',
        component: cart,
        name: "cart",
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/shop_like',
        component: shop_like,
        name: "shop_like",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/my_orders',
        component: my_orders,
        name: "my_orders",
        meta: {
            requiresAuth: false
        }
    }, {
        path: '/shop',
        component: shop,
        name: "shop",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/courses',
        component: Course,
        name: "courses",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/women',
        component: women,
        name: "women",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/course_details/:id',
        component: CourseDetails,
        name: "course_details",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/women_details/:id',
        component: WomenDeatails,
        name: "women_details",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/product_details/:id',
        component: ProductDeatailsComponent,
        name: "product_details",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/post_details/:id',
        component: WomenDeatails,
        name: "post_details",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/privacy',
        component: Privacy,
        name: "privacy",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/consultant',
        component: ConsultantComponent,
        name: "consultant",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/',
        component: shop,
        name: "home2",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/concatUs',
        component: concatUs,
        name: "concatUs",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/home',
        component: shop,
        name: "home",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/about',
        component: About,
        name: "about",

        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/register',
        name: 'register',

        component: Register,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta: {
            requiresAuth: false
        }
    },

    {
        path: '/logout',
        name: 'logout',
        component: LogoutComponent,
        meta: {
            requiresAuth: true
        }

    },

    {
        path: '/profile',
        name: 'profile',
        component: Profile,
        meta: {
            requiresAuth: true
        }

    },
    {
        path: "/dashboard",
        name: "Dashboard",

        component: Dashboard,
        meta: {
            requiresAuth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/403'}
        }

    }

];
const router = new VueRouter({
    routes
})


router.beforeEach((to, from, next) => {
    window.scrollTo(0, 0);
    var div =  document.querySelector('body');
    div.classList.remove('mobile-menu-visible');
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next()
            return
        }
        next('/login')
    } else {
        next()
    }
})
export default router

