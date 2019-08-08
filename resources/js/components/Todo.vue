<template>
    <div class="col-md-6 mx-auto">
        <form v-on:submit.prevent = "addNewTask">
            <label for="tasknameinput"><b>Task name</b></label>
            <input v-model = "taskname" type="text" id="tasknameinput" class="form-control" placeholder="Enter the task name...">
            <button v-if = "this.edit == false" type="submit" class="btn btn-success btn-block mt-3">Add</button>
            <button v-else type="button" v-on:click = "updateTask()" class="btn btn-primary btn-block mt-3">Update</button>
        </form>

        <table class="table">
            <tr v-for="(todo) in todos" v-bind:key="todo.id" v-bind:title="todo.title">
                <td class="text-left">{{todo.title}}</td>
                <td class="text-right">
                    <button v-on:click = "editTask(todo.title, todo.id)" class="btn btn-info">Edit</button>
                    <button v-on:click = "deleteTask(todo.id)" class="btn btn-danger">Delete</button>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            todos: [],
            id: '',
            taskname: '',
            edit: false
        }
    },
    mounted() {
        this.getTasks()
    },
    methods: {
        getTasks(){
        axios({method: 'GET', url: '/api/tasks'}).then(
                res =>  {
                this.todos = res.data
            },
                error => {
                console.error(error)
            })
        },
        addNewTask(){
            axios.post('/api/task', {title: this.taskname}).then(res => {
                this.taskname=''
                this.getTasks()
            })
        },
        editTask(title, id){
            this.id = id
            this.taskname = title
            this.edit = true
        },
        updateTask(){
            axios.put(`/api/task/${this.id}`,
            {title: this.taskname})
            .then(res => {
                this.taskname = ''
                this.edit = true
                this.getTasks()
            })
            .catch(err => {
                console.log(err)
            })
        },
        deleteTask(id){
            axios.delete(`/api/task/${id}`)
            .then(res => {
                this.taskname = ''
                this.getTasks()
            })
            .catch(err => {
                console.log(err)
            })
        }
    }
}
</script>