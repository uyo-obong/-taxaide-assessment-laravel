<template>
    <div></div>
</template>

<script>
export default {
    methods: {
        logout() {
            localStorage.removeItem('token')
            this.$router.push({path: '/dashboard'})
        }
    },

    mounted() {
        this.logout()
    }
}
</script>
