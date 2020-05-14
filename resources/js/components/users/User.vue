<template>
    <tr class="user">
        <td width="400">
            <span v-if="!editable">
                {{ user.name }}
            </span>
            <input
                v-else
                v-model="user.name"
                name="user_editable"
                type="text"
                class="form-control"
            />
        </td>
        <td width="400">
            <span v-if="!editable">
                {{ user.email }}
            </span>
            <input
                v-else
                v-model="user.email"
                name="email_editable"
                type="email"
                class="form-control"
            />
        </td>
        <td width="50">
            <a
                v-if="editable"
                class="btn btn-sm btn-info"
                v-on:click="toggleEditable(); $emit('edit', user)"
            >
                Editar
            </a>
            <a
                v-else
                class="btn btn-sm btn-warning"
                v-on:click="toggleEditable()"
            >
                Modo edición
            </a>
        </td>
        <td width="50">
            <a
                class="btn btn-sm btn-danger"
                v-on:click="$emit('remove', user.id)"
            >
                Eliminar
            </a>
        </td>
    </tr>
</template>

<script>
import Vue from 'vue';
export default {
    props: ['user'],
    data() {
        return {
            editable: false
        }
    },
    methods: {
        toggleEditable() {
            this.editable = !this.editable;
        }
    }
}
</script>
