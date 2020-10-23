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
import ConsultantComponent from './components/ConsultantComponent';
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
            requiresAuth: true
        }
    },
    {
        path: '/women_details/:id',
        component: WomenDeatails,
        name: "women_details",
        meta: {
            requiresAuth: false
        }
    },   {
        path: '/post_details/:id',
        component: WomenDeatails,
        name: "post_details",
        meta: {
            requiresAuth: true
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
        component: Course,
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
        component: Course,
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
        },

        beforeEnter: (to, form, next) => {
            // window.scrollTo(0, 0);
            axios.post('/api/user').then(() => {
                next()
            }).catch(() => {
                return next({name: 'login'})
            })
        }

    }

];
const router = new VueRouter({
    routes
})


router.beforeEach((to, from, next) => {
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

