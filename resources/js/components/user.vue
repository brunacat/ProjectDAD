<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>
        <b-button
            v-if="!addingUser"
            v-on:click.prevent="addingUser = true"
            >Add admin or operator</b-button
        >
        <create-ao
            v-if="addingUser"
            @ao-created="createdAO"
            @create-canceled="cancelCreate"
            ref="createAORef"
        ></create-ao>
        <user-list
            :users="users"
            @edit-click="editUser"
            @delete-click="deleteUser"
            ref="usersListRef"
        ></user-list>
        <user-edit
            :user="currentUser"
            @user-saved="savedUser"
            @user-canceled="cancelEdit"
            v-if="currentUser"
        ></user-edit>
    </div>
</template>
<script type="text/javascript">
import UserList from "./userList.vue";
import UserEdit from "./userEdit.vue";
import CreateAO from "./createAO.vue";

export default {
    data: function() {
        return {
            title: "List Users",
            currentUser: null,
            addingUser: null,
            users: []
        };
    },
    methods: {
        editUser: function(user) {
            this.currentUser = user;
        },
        deleteUser: function(user) {
            axios.delete("api/users/" + user.id).then(response => {
                this.showSuccess = true;
                this.$toasted.success("User deleted");
                this.getUsers();
            });
        },
        savedUser: function(user) {
            this.currentUser = null;
            this.$refs.usersListRef.editingUser = null;
            this.$toasted.success("User saved");
            //this.$socket.emit("user_changed", user);
        },
        cancelEdit: function() {
            this.currentUser = null;
            this.$refs.usersListRef.editingUser = null;
        },
        createdAO: function() {
            this.$toasted.success("New admin or operator registered");
        },
        cancelCreate: function() {
            this.addingUser = false;
            this.$refs.createAORef.addingUser = null;
        },
        getUsers: function() {
            axios.get("api/users").then(response => {
                this.users = response.data.data;
            });
        }
    },
    components: {
        "create-ao": CreateAO,
        "user-list": UserList,
        "user-edit": UserEdit
    },
    mounted() {
        this.getUsers();
        this.addingUser = false;
    }
};
</script>

<style lang="scss">
@import "./resources/sass/app.scss";
</style>
