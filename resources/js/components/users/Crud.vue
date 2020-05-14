<template>
    <div class="list-users">
        <div v-if="errors" class="alert alert-danger">
            <p v-for="error in errors.email" :key="error">{{ error }}</p>
            <p v-for="error in errors.username" :key="error">{{ error }}</p>
        </div>

        <div class="row">
            <div class="col-md-8">
                <users-form
                    v-on:addUser="addUser()"
                    v-bind:user="user"
                />
            </div>

            <div class="form-group col-md-4">
                <label for="searchUsers">Buscar</label>
                <input
                    v-model="searchUsers"
                    id="searchUsers"
                    name="searchUsers"
                    type="text"
                    class="form-control"
                />
            </div>
        </div>

        <div v-if="users.length">
            <table class="table table-stripped table-bordered">
                <thead>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </thead>
                <tbody>
                    <user
                        v-for="user_data in filteredUsers(users)"
                        v-bind:user="user_data"
                        v-on:edit="edit(user_data)"
                        v-on:remove="remove(user_data.id)"
                        :key="user_data.id"
                    />
                </tbody>
            </table>
        </div>
        <div v-else>
            No existen usuarios
        </div>
    </div>
</template>

<script>
import Vue from 'vue';
import API from '../services/api';
import User from './User.vue';
import UsersForm from './Form.vue';

export default {
    components: {
        User, UsersForm
    },
    data() {
        return {
            users: [],
            user: {
                email: '',
                username: ''
            },
            errors: null,
            searchUsers: ''
        }
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        filteredUsers() {
            return this.users.filter(user =>
                user.email.indexOf(this.searchUsers) > -1
            )
        },
        fetchUsers() {
            API.resource(this).get().then(response => {
                this.users = response.data;
            })
        },
        addUser() {
            API.resource(this).save(this.user).then(
                response => {
                    this.users.push(response.data);
                    this.user = {
                        email: '',
                        username: ''
                    }
                    this.errors = null;
                },
                errors => {
                    this.errors = errors.data.errors;
                    console.log(errors.data.errors);
                }
            )
        },
        edit(user) {
            API.resource(this).update({id: user.id}, user).then(response => {
                console.log(response.data);
            })
        },
        remove(id) {
            API.resource(this).delete({id: id}).then(response => {
                this.fetchUsers();
            })
        }
    }
}
</script>
