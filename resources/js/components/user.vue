<template>
    <div>
        <div v-if="!this.$store.state.user">
            <b-jumbotron>
                <h1>401 (Unauthorized)</h1>
            </b-jumbotron>
        </div>
        <div v-else-if="this.$store.state.user.type == 'a'">
            <b-jumbotron>
                <template v-slot:header>{{ title }}</template>
                <b-button
                    v-if="!addingUser"
                    v-on:click.prevent="addingUser = true"
                    >Add New Admin Or Operator</b-button
                >
            </b-jumbotron>

            <create-ao
                v-if="addingUser"
                @ao-created="createdAO"
                @create-canceled="cancelCreate"
                ref="createAORef"
            ></create-ao>
            <user-list
                :users="users"
                @delete-click="deleteUser"
                ref="usersListRef"
            ></user-list>
        </div>
        <div v-else>
            <b-jumbotron>
                <h1>401 (Unauthorized)</h1>
            </b-jumbotron>
        </div>
    </div>
</template>
<script type="text/javascript">
import UserList from "./userList.vue";
import CreateAO from "./createAO.vue";

export default {
    data: function() {
        return {
            title: "List Users",
            addingUser: null,
            users: []
        };
    },
    methods: {
        deleteUser: function(id) {
            axios.delete("api/users/" + id).then(response => {
                this.$toasted.success(response.data);
                this.getUsers();
            });
        },
        savedUser: function(user) {
            this.currentUser = null;
            this.$refs.usersListRef.editingUser = null;
            this.$toasted.success("User saved");
            //this.$socket.emit("user_changed", user);
        },
        createdAO: function(type) {
            if (type == "a") {
                this.$toasted.success("New administrator registered");
            } else {
                this.$toasted.success("New operator registered");
            }
            this.addingUser = false;
            this.getUsers();
        },
        cancelCreate: function() {
            this.addingUser = false;
            this.$refs.createAORef.addingUser = null;
        },
        getUsers: function() {
            axios
                .get("api/users")
                .then(response => {
                    this.users = response.data.data;
                })
                .catch(error => {
                    this.$toasted.error("Reload the page to get USERS");
                });
        }
    },
    components: {
        "create-ao": CreateAO,
        "user-list": UserList
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
