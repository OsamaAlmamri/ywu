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
        name: "Courses",
        meta: {
            requiresAuth: false
        }

    }, {
        path: '/course_details/:id',
        component: CourseDetails,
        name: "course_details",
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/privacy',
        component: Privacy,
        name: "Privacy",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/',
        component: Home,
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
        component: Home,
        name: "Home",
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/about',
        component: About,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/register',
        component: Register,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'Login',
        meta: {
            requiresAuth: false
        }
    },

    {
        path: '/logout',
        name: 'logout',
        component: LogoutComponent,
        meta: {
            requiresAuth: false
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
            axios.get('/api/athenticated').then(() => {
                next()
            }).catch(() => {
                return next({name: 'Login'})
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

