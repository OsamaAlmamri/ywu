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
import store from './storage';

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

    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
        // redirect to login page
        next({ name: 'login' })
        return
    }

    // if logged in redirect to dashboard
    if(to.path === '/login' && store.state.isLoggedIn) {
        next({ name: 'dashboard' })
        return
    }

    next()
});

export default router

