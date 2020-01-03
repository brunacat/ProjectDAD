<template>
    <div>
        <div v-if="!this.$store.state.user">
            <b-jumbotron>
                <h1>401 (Unauthorized)</h1>
            </b-jumbotron>
        </div>
        <div v-else-if="this.$store.state.user.type == 'u'">
            <b-jumbotron>
                <template v-slot:header>Welcome!</template>

                <p>Current balance: {{ user.balance }}</p>

                <b-button
                    v-if="!editingUser"
                    v-on:click.prevent="editingUser = true"
                    >Edit Profile</b-button
                >
                <b-button
                    v-if="!changePass"
                    v-on:click.prevent="changePass = true"
                    >Change Password</b-button
                >
                <b-button
                    v-if="!addingExpense"
                    v-on:click.prevent="addingExpense = true"
                    >Add Expense</b-button
                >

                <movements
                    :movements="movements"
                    @get-movements="getMovements"
                />
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
        </div>
        <div v-else>
            <b-jumbotron>
                <h1>401 (Unauthorized)</h1>
            </b-jumbotron>
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
            email: "",
            movements: [],
            editingUser: null,
            changePass: null,
            addingExpense: null
        };
    },
    components: {
        movements: Movements,
        "user-edit": UserEdit,
        "change-pass": ChangePass,
        expense: Expense
    },
    methods: {
        getMovements() {
            axios.get("api/wallet/me/movements").then(response => {
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
        addExpense: function(transfer) {
            this.addingExpense = null;
            this.$toasted.success("Expense added");
            this.getMovements();
            this.$store.commit("setUser", this.user);
            this.email = transfer;
        },
        cancelExpense: function() {
            this.addingExpense = null;
        },
        sendmail: function() {
            axios
                .post("api/sendEmail", this.email)
                .then(response => {
                    console.log(this.email.email);
                    this.$toasted.success(response.data.message);
                })
                .catch(error => {
                    this.$toasted.error("Notification email failed");
                });
        }
    },
    sockets: {
        privateMessage() {
            this.$toasted.success(
                "Movement received! Movements are being updated"
            );
            this.getMovements();
        },
        privateMessage_unavailable() {
            this.sendmail();
        }
    },
    mounted() {
        console.log(this.$store.state.user);
        this.getMovements();
        this.user = this.$store.state.user;
        console.log("Component mounted.");
        this.renderChart(this.chartdata, this.options)
    }
};
</script>
