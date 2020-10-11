<template>

</template>

<script>
    import store from '../storage'
    export default {
        mounted () {
            localStorage.removeItem('token')
            store.commit('logoutUser')
            this.$router.push({ name: 'login' })
        }

    }
</script>
