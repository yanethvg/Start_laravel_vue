<template>
    <div class="users-form">
        <form novalidate method="POST" v-on:submit.prevent="$emit('addUser')">
               <div class="row">
                    <div class="form-group col-xs-5 mx-2">
                        <label for="user">User</label>
                        <input
                            v-model="user.username"
                            name="user"
                            id="user"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="form-group col-xs-5 mx-2">
                        <label for="email">Email</label>
                        <input
                            v-model="user.email"
                            name="email"
                            id="email"
                            type="email"
                            class="form-control"
                        />
                    </div>
                    <div class="form-group col-xs-2 mx-2">
                        <button
                            style="margin-top: 25px"
                            type="submit"
                            class="btn btn-block btn-success"
                        >
                            Crear
                        </button>
                    </div>
               </div>
        </form>
    </div>
</template>

<script>
import Vue from 'vue';
export default {
    props: ['user']
}
</script>
