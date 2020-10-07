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


export default {
    mode: 'history',
    history: true,
    linkActiveClass: 'font-semibold',
    routes: [
        {
            path: '*',
            component: NotFound
        },
        {
            path: '/courses',
            component: Course,
            name: "Courses",
            meta: {
                auth: false
            }
        }, {
            path: '/course_details/:id',
            component: CourseDetails,
            name: "course_details",
            meta: {
                auth: true
            }
        },
        {
            path: '/privacy',
            component: Privacy,
            name: "Privacy",
            meta: {
                auth: false
            }
        },
        {
            path: '/',
            component: Home,
            name: "Home",
            meta: {
                auth: false
            }
        },
        {
            path: '/concatUs',
            component: concatUs,
            name: "concatUs",
            meta: {
                auth: false
            }
        },
        {
            path: '/home',
            component: Home,
            name: "Home",
            meta: {
                auth: false
            }
        },
        {
            path: '/about',
            component: About,
            meta: {
                auth: false
            }
        },
        {
            path: '/register',
            component: Register,
            meta: {
                auth: false
            }
        },
        {
            path: '/login',
            component: Login,
            name: 'Login',
            meta: {
                auth: false
            }
        },
        {
            path: "/dashboard",
            name: "Dashboard",

            component: Dashboard,
            meta: {
                auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/403'}},

                beforeEnter: (to, form, next) => {
                    axios.get('/api/athenticated').then(() => {
                        next()
                    }).catch(() => {
                        return next({name: 'Login'})
                    })
                }

            }

    ]
}
