import bearer from '@websanova/vue-auth/drivers/auth/bearer';
import axios2 from '@websanova/vue-auth/drivers/http/axios.1.x';
import router2 from '@websanova/vue-auth/drivers/router/vue-router.2.x';
// Auth base configuration some of this options
// can be override in method calls
const config = {
    auth: bearer,
    http: axios2,
    router: router2,
    tokenDefaultName: 'laravel-vue-spa',
    tokenStore: ['localStorage'],
    rolesVar: 'role',
    registerData: {url: 'auth/register', method: 'POST', redirect: '/login'},
    loginData: {url: 'auth/login', method: 'POST', redirect: '', fetchUser: true},
    logoutData: {url: 'auth/logout', method: 'POST', redirect: '/', makeRequest: true},
    fetchData: {url: 'auth/user', method: 'GET', enabled: true},
    refreshData: {url: 'auth/refresh', method: 'GET', enabled: true, interval: 30}
}
export default config
