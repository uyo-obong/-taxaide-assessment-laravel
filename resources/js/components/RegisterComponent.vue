<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form v-on:submit.prevent="signup">

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" v-model="name" required autocomplete="name" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Register</button> |
                                    <a href="/login" class="btn btn-primary">Login</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import store from '../store'
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            loginError: false,
        }
    },
    methods: {
        signup() {
            this.loginError = false;
            axios.post('/api/v1/register', {
                name: this.name,
                email: this.email,
                password: this.password
            }).then(response => {
                store.commit('loginUser')
                localStorage.setItem('token', response.data.data.auth.token)
                this.$router.push({ name: 'dashboard' })
            }).catch(error => {
                console.log(error)
                this.loginError = true
            });
        },
    }
}

</script>
