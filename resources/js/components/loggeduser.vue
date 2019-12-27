<template>
    <div>
        <b-jumbotron>
            <template v-slot:header>Welcome!</template>

            <p>Current balance: {{ user.balance }}</p>

            <b-button
                v-if="!editingUser"
                v-on:click.prevent="editingUser = true"
                >Edit Profile</b-button
            >
            <b-button v-if="!changePass" v-on:click.prevent="changePass = true"
                >Change Password</b-button
            >
        </b-jumbotron>
        <user-edit
            :user="user"
            @user-saved="savedUser"
            @user-canceled="cancelEdit"
            v-if="editingUser"
        >
        </user-edit>
        <change-pass
            :user="user"
            @pass-saved="savedPass"
            @pass-canceled="cancelPass"
            v-if="changePass"
        >
        </change-pass>
        <movements />
    </div>
</template>

<script>
import Movements from "./movements";
import UserEdit from "./loggedUserEdit";
import ChangePass from "./changePass";

export default {
    data() {
        return {
            user: {
                balance: "",
                name: "",
                password: "",
                nif: "",
                photo: null
            },
            editingUser: null,
            changePass: null
        };
    },
    components: {
        movements: Movements,
        "user-edit": UserEdit,
        "change-pass": ChangePass
    },
    methods: {
        savedUser: function() {
            this.editingUser = null;
            this.$toasted.success("User saved");
        },
        cancelEdit: function() {
            this.editingUser = null;
        },
        savedPass: function() {
            this.changePass = null;
            this.$toasted.success("Password saved");
        },
        cancelPass: function() {
            this.changePass = null;
        }
    },
    mounted() {
        this.user = this.$store.state.user;
        console.log("Component mounted.");
    }
};
</script>
