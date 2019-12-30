<template>
<div>
    <div v-if="!this.$store.state.user" >
        <b-jumbotron>
        <h1>401 (Unauthorized)</h1>
        </b-jumbotron>
    </div>
    <div v-if="this.$store.state.user">
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
            <b-button v-if="!addingExpense" v-on:click.prevent="addingExpense = true"
                >Add Expense</b-button
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
        <expense
            :user="user"
            @expense-added="addExpense"
            @expense-canceled="cancelExpense"
            v-if="addingExpense"
        >
        </expense>
        <movements :movements="movements" />
        
    </div>
    </div>
</template>

<script>
import Movements from "./movements";
import UserEdit from "./loggedUserEdit";
import ChangePass from "./changePass";
import Expense from "./expense";

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
            movements:[],
            editingUser: null,
            changePass: null,
            addingExpense: null,
            key: 0,
        };
    },
    components: {
        movements: Movements,
        "user-edit": UserEdit,
        "change-pass": ChangePass,
        "expense": Expense
    },
    methods: {
        getMovements() {
      axios
        .get("api/wallet/me/movements")
        .then(response => {
          this.movements = response.data.data;
        });
    },
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
        },
        addExpense: function() {
            this.addingExpense = null;
            this.$toasted.success("Expense added");
            this.getMovements();
        },
        cancelExpense: function() {
            this.addingExpense = null;
        }
    },
    mounted() {
        console.log(this.$store.state.user)
        this.getMovements();
        this.user = this.$store.state.user;
        console.log("Component mounted.");
    }
};
</script>
