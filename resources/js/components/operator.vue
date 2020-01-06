<template>
    <div>
        <div v-if="!this.$store.state.user">
            <b-jumbotron>
                <h1>401 (Unauthorized)</h1>
            </b-jumbotron>
        </div>
        <div v-else-if="this.$store.state.user.type == 'o'" class="jumbotron">
            <div>
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
            </div>
            <p />
            <h2>Add Expense</h2>
            <input type="radio" id="cash" value="c" v-model="income.type" />
            <label for="one">Cash</label>
            <br />
            <input
                type="radio"
                id="transfer"
                value="bt"
                v-model="income.type"
            />
            <label for="two">Transfer</label>
            <br />
            <p />

            <div class="form-group">
                <label for="valueCredit">Value of the Credit</label>
                <input
                    type="number"
                    class="form-control"
                    v-model="income.value"
                    name="valueCrd"
                    id="valueCredit"
                    placeholder="Value of the Credit"
                />
            </div>
            <div class="form-group">
                <label for="emailDestination">Destination Email</label>
                <input
                    type="email"
                    class="form-control"
                    v-model="income.email"
                    name="valueExp"
                    id="emailDestination"
                />
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <b-form-textarea
                    class="form-control"
                    v-model="income.description"
                    name="desc"
                    id="description"
                />
            </div>

            <div v-if="income.type == 'bt'" class="form-group">
                <label for="iban">IBAN</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="income.iban"
                    name="iban"
                    id="iban"
                />
            </div>
            <div class="form-group">
                <b-button
                    type="save"
                    variant="primary"
                    v-on:click.prevent="addIncome()"
                    >Save</b-button
                >
                <b-button
                    type="reset"
                    variant="light"
                    v-on:click.prevent="reset()"
                    >Reset</b-button
                >
            </div>
        </div>
        <div v-else>
            <b-jumbotron>
                <h1>401 (Unauthorized)</h1>
            </b-jumbotron>
        </div>
    </div>
</template>

<script type="text/javascript">
import EditAO from "./editAO";
import ChangePass from "./changePass";
export default {
    props: ["user"],
    data() {
        return {
            income: {
                type: "c",
                value: 0,
                email: "",
                description: "",
                iban: ""
            },
            editingSelf: false,
            changePass: false
        };
    },
    components: {
        "edit-ao": EditAO,
        "change-pass": ChangePass
    },
    methods: {
        messageUser: function() {
            axios.get("api/userByEmail/" + this.income.email).then(response => {
                this.$socket.emit(
                    "privateMessage",
                    "A movement was added to your wallet",
                    this.$store.state.user,
                    response.data.data
                );
            });
        },
        reset: function() {
            this.income.value = 0;
            this.income.email = "";
            this.income.description = "";
            this.income.iban = "";
        },
        addIncome: function() {
            if (this.income.type == "c") {
                axios.post("api/incomeC", this.income).then(response => {
                    this.messageUser();
                    this.$toasted.success("Income added");
                    this.reset();
                });
            } else {
                axios.post("api/incomeBT", this.income).then(response => {
                    this.messageUser();
                    this.$toasted.success("Income added");
                    this.reset();
                });
            }
        },
        savedUser: function() {
            this.editingUser = false;
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
        sendmail: function() {
            axios
                .post("api/sendEmail", this.income)
                .then(response => {
                    this.$toasted.success(response.data.message);
                })
                .catch(error => {
                    this.$toasted.error("Notification email failed");
                });
        }
    },
    sockets: {
        privateMessage_unavailable() {
            this.sendmail();
        }
    }
};
</script>

<style lang="scss">
@import "./resources/sass/app.scss";
</style>