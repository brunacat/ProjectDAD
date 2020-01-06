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
                <b-button
                    v-if="!editingSelf"
                    v-on:click.prevent="editingSelf = true"
                    >Edit Profile</b-button
                >
                <b-button
                    v-if="!changePass"
                    v-on:click.prevent="changePass = true"
                    >Change Password</b-button
                >
                <b-button v-if="!showStats" v-on:click.prevent="showStat()"
                    >Show Statistics</b-button
                >
                <b-button
                    v-if="showStats"
                    v-on:click.prevent="showStats = false"
                    >Hide Statistics</b-button
                >
                <create-ao
                    v-if="addingUser"
                    @ao-created="createdAO"
                    @create-canceled="cancelCreate"
                    ref="createAORef"
                ></create-ao>
                <edit-ao
                    :user="this.$store.state.user"
                    @user-saved="savedUser"
                    @user-canceled="cancelEdit"
                    v-if="editingSelf"
                >
                </edit-ao>
                <change-pass
                    :user="this.$store.state.user"
                    @pass-saved="savedPass"
                    @pass-canceled="cancelPass"
                    v-if="changePass"
                >
                </change-pass>
                <p />
                <user-statistics
                    v-if="showStats"
                    :statistics="statistics"
                ></user-statistics>
                <user-list
                    :users="users"
                    @delete-click="deleteUser"
                    ref="usersListRef"
                ></user-list>
            </b-jumbotron>
        </div>
        <div v-else>
            <b-jumbotron>
                <h1>401 (Unauthorized)</h1>
            </b-jumbotron>
        </div>
    </div>
    <div v-else-if="this.$store.state.user.type == 'a'">
      <b-jumbotron>
        <template v-slot:header>{{ title }}</template>
        <b-button
          v-if="!addingUser"
          v-on:click.prevent="addingUser = true"
        >Add New Admin Or Operator</b-button>
        <b-button v-if="!showStats" v-on:click.prevent="showStat()">Show Statistics</b-button>
        <b-button v-if="showStats" v-on:click.prevent="showStats=false">Hide Statistics</b-button>
        <create-ao
          v-if="addingUser"
          @ao-created="createdAO"
          @create-canceled="cancelCreate"
          ref="createAORef"
        ></create-ao>
        <p/>
        <user-statistics v-if="showStats" :statistics="statistics"></user-statistics>
        <user-list :users="users" @delete-click="deleteUser" ref="usersListRef"></user-list>
      </b-jumbotron>
    </div>
    <div v-else>
      <b-jumbotron>
        <h1>401 (Unauthorized)</h1>
      </b-jumbotron>
    </div>
  </div>
</template>
<script type="text/javascript">
import UserStatistics from "./userStatistics.vue";
import UserList from "./userList.vue";
import CreateAO from "./createAO.vue";
import EditAO from "./editAO";
import ChangePass from "./changePass";

export default {
    data: function() {
        return {
            title: "List Users",
            addingUser: false,
            showStats: false,
            users: [],
            statistics: {
                userCount: 0,
                hasMoney: 0,
                noMoney: 0,
                inactive: 0
            },
            editingSelf: false,
            changePass: false
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
            this.currentUser = false;
            this.$refs.usersListRef.editingUser = null;
            this.$toasted.success("User saved");
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
        savedUser: function() {
            this.editingUser = null;
            this.$toasted.success("User saved");
        },
        cancelEdit: function() {
            this.editingSelf = false;
        },
        savedPass: function() {
            this.changePass = false;
            this.$toasted.success("Password saved");
        },
        cancelPass: function() {
            this.changePass = false;
        },
        showStat: function() {
            this.users.forEach(u => {
                if (u.type == "User") {
                    this.statistics.userCount++;
                    if (u.balance == "Has money") {
                        this.statistics.hasMoney++;
                    } else {
                        this.statistics.noMoney++;
                        if (u.active == "Inactive") {
                            this.statistics.inactive++;
                        }
                    }
                }
            });
            console.log(this.statistics);
            this.showStats = true;
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
        "user-list": UserList,
        "user-statistics": UserStatistics,
        "edit-ao": EditAO,
        "change-pass": ChangePass
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
