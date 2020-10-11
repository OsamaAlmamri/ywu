<template>

</template>

<script>
    import store from '../store'
    export default {
        mounted () {
            store.commit('logout')
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            delete axios.defaults.headers.common['Authorization']
            this.$router.push({ name: 'Login' })
        }

    }
</script>
