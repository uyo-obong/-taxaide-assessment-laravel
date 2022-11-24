<template>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                        <div class="card-body py-4 px-4 px-md-5">
                            <a href="#" @click="logout">Logout</a>

                            <p class="h1 text-center mt-3 mb-4 pb-3 text-primary">
                                <i class="fas fa-check-square me-1"></i>
                                <u>My Todo-s</u>
                            </p>

                            <form @submit.prevent="createTodo">
                                <div class="pb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-row align-items-center">
                                                <input type="text" v-model="form.title" class="form-control form-control-lg"
                                                       id="exampleFormControlInput1"
                                                       placeholder="Add new...">
                                                <a href="#!" data-mdb-toggle="tooltip" title="Set due date"><i
                                                    class="fas fa-calendar-alt fa-lg me-3"></i></a>
                                                <div>
                                                    <button type="submit" class="btn btn-primary">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <hr class="my-4">

                            <div v-if="todos.length > 0">
                                <ul class="list-group list-group-horizontal rounded-0 bg-transparent"
                                    v-for="todo in todos">
                                    <li
                                        class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 border-0 bg-transparent">
                                        <span v-if="update_form && todo._id === updatedId">
                                            <form  @submit.prevent="updateTodo(todo._id)">
                                            <input type="text" v-model="update.title"  class="form-control form-control-sm">
                                            </form>
                                        </span>

                                        <span v-else>
                                            <p class="lead fw-normal mb-0">{{ todo.title }}</p>
                                        </span>


                                    </li>
                                    <li class="list-group-item ps-3 pe-0 py-1 rounded-0 border-0 bg-transparent">
                                        <div class="d-flex flex-row justify-content-end mb-1">
                                            <a href="#!" @click="updateTodo(todo._id)" class="text-info" data-mdb-toggle="tooltip"
                                               title="Edit todo"><i
                                                class="fas fa-pencil-alt me-3"></i></a>
                                            <a href="#!" class="text-danger" data-mdb-toggle="tooltip"
                                               title="Delete todo" @click="deleteTodo(todo._id)"><i
                                                class="fas fa-trash-alt"></i></a>
                                        </div>


                                        <div class="text-end text-muted">
                                            <a href="#!" class="text-muted" data-mdb-toggle="tooltip"
                                               title="Created date">
                                                <p class="small mb-0"><i class="fas fa-info-circle me-2"></i>{{
                                                        getFormattedDate(todo.createdAt)
                                                    }} by
                                                    {{ todo.posted_by }}</p>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div v-else>
                                <h2>No data available</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!--        Update modal-->
    </section>
</template>

<script>
import moment from 'moment';

export default {
    data() {
        return {
            todos: [],
            auth: {},
            updatedId: '',
            update_form: false,
            update: {
                title: ''
            },
            form: {
                title: '',
            }
        }
    },

    computed: {
        header() {
            return {
                'Content-Type': 'application/json',
                'auth-token': localStorage.getItem('token')
            }
        },
    },

    methods: {
        updateTodo(id) {
            this.update_form = true
            this.updatedId = id

            console.log(this.update.title !== '')

            if (this.update.title !== '') {
                const data = {
                    title: this.update.title,
                }

                axios.patch(`http://localhost:8089/api/v1/todo/update/${id}`, data, {headers: this.header}).then(response => {
                    this.update.title = ''
                    this.update_form = false
                    this.updatedId = ''
                    this.fetchTodos()
                    alert('Todo Updated successfully')
                }).catch(error => {
                    console.log(error)
                    this.loginError = true
                });
            }
        },
        getFormattedDate(date) {
            return moment(date).format("YYYY-MM-DD")
        },

        fetchAuth() {
            const header = {
                'Content-Type': 'application/json',
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
            axios.get('http://127.0.0.1:8001/api/v1/auth', {headers: header}).then(response => {
                console.log(response.data)
                this.auth = response.data.data
            }).catch(error => {
                console.log(error)
                this.loginError = true
            });
        },

        fetchTodos() {
            axios.get('http://localhost:8089/api/v1/todo/fetch', {headers: this.header}).then(response => {
                console.log(response.data.data)
                this.todos = response.data.data
            }).catch(error => {
                console.log(error)
                this.loginError = true
            });
        },

        createTodo() {
            const data = {
                title: this.form.title,
                posted_by: this.auth.user.name,
                email: this.auth.user.email,
                description: this.form.title
            }

            axios.post('http://localhost:8089/api/v1/todo/create', data, {headers: this.header}).then(response => {
                this.fetchTodos()
                this.form.title = ''
                alert('Todo created successfully')
            }).catch(error => {
                console.log(error)
                this.loginError = true
            });
        },

        deleteTodo(id) {
            axios.delete(`http://localhost:8089/api/v1/todo/delete/${id}`, {headers: this.header}).then(response => {
                this.fetchTodos()
                alert('Item deleted successfully')
            }).catch(error => {
                console.log(error)
                this.loginError = true
            });
        },

        logout() {
            console.log('hello')
            localStorage.removeItem('token')
            this.$router.push('/login')
        }

    },

    mounted() {
        this.fetchAuth()
        this.fetchTodos()
    },

}
</script>

<style scoped>
#list1 .form-control {
    border-color: transparent;
}

#list1 .form-control:focus {
    border-color: transparent;
    box-shadow: none;
}

#list1 .select-input.form-control[readonly]:not([disabled]) {
    background-color: #fbfbfb;
}
</style>
