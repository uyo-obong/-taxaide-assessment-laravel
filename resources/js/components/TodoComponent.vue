<template>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                        <div class="card-body py-4 px-4 px-md-5">

                            <p class="h1 text-center mt-3 mb-4 pb-3 text-primary">
                                <i class="fas fa-check-square me-1"></i>
                                <u>My Todo-s</u>
                            </p>

                            <div class="pb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-center">
                                            <input type="text" class="form-control form-control-lg" id="exampleFormControlInput1"
                                                   placeholder="Add new...">
                                            <a href="#!" data-mdb-toggle="tooltip" title="Set due date"><i
                                                class="fas fa-calendar-alt fa-lg me-3"></i></a>
                                            <div>
                                                <button type="button" class="btn btn-primary">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div v-if="todos.length > 0">
                            <ul class="list-group list-group-horizontal rounded-0 bg-transparent" v-for="todo in todos">
<!--                                <li-->
<!--                                    class="list-group-item d-flex align-items-center ps-0 pe-3 py-1 rounded-0 border-0 bg-transparent">-->
<!--                                    <div class="form-check">-->
<!--                                        <input class="form-check-input me-0" type="checkbox" value="" id="flexCheckChecked1"-->
<!--                                               aria-label="..." checked />-->
<!--                                    </div>-->
<!--                                </li>-->
                                <li
                                    class="list-group-item px-3 py-1 d-flex align-items-center flex-grow-1 border-0 bg-transparent">
                                    <p class="lead fw-normal mb-0">{{ todo.title }}</p>
                                </li>
                                <li class="list-group-item ps-3 pe-0 py-1 rounded-0 border-0 bg-transparent">
                                    <div class="d-flex flex-row justify-content-end mb-1">
                                        <a href="#!" class="text-info" data-mdb-toggle="tooltip" title="Edit todo"><i
                                            class="fas fa-pencil-alt me-3"></i></a>
                                        <a href="#!" class="text-danger" data-mdb-toggle="tooltip" title="Delete todo" @click="deleteTodo(todo._id)"><i
                                            class="fas fa-trash-alt"></i></a>
                                    </div>
                                    <div class="text-end text-muted">
                                        <a href="#!" class="text-muted" data-mdb-toggle="tooltip" title="Created date">
                                            <p class="small mb-0"><i class="fas fa-info-circle me-2"></i>{{ getFormattedDate(todo.createdAt)  }} by
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
    </section>
</template>

<script>
import moment from 'moment';

export default {
    data() {
        return {
            todos: [],
            data: {
                title: '',
            }
        }
    },

    computed: {
        header() {
            return  {
                'Content-Type': 'application/json',
                'auth-token': localStorage.getItem('token')
            }
        },
    },

    methods: {
        getFormattedDate(date) {
            return moment(date).format("YYYY-MM-DD")
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

        }

        deleteTodo(id) {
            axios.delete(`http://localhost:8089/api/v1/todo/delete/${id}`, {headers: this.header}).then(response => {
                this.fetchTodos()
                alert('Item deleted successfully')
            }).catch(error => {
                console.log(error)
                this.loginError = true
            });
        }


    },

    mounted() {
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
