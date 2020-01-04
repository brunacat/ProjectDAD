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
                <b-button v-if="!showGraphs" v-on:click.prevent="showGraph()"
                    >Show Graphs</b-button
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
                <zoomable :graphs="graphs" v-if="showGraphs"></zoomable>
                <pie-chart-exp
                    :pchart="pchart"
                    v-if="showGraphs"
                ></pie-chart-exp>
                <pie-chart-inc
                    :pchart="pchart"
                    v-if="showGraphs"
                ></pie-chart-inc>
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
import PieChartExp from "./pieChartExp.vue";
import PieChartInc from "./pieChartInc.vue";
import Zoomable from "./zoomable.vue";

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
            addingExpense: null,
            graphs: [],
            showGraphs: false,
            categories: null,
            pchart: {
                seriesE: null,
                labelsE: null,
                seriesI: null,
                labelsE: null,
                otherE: null,
                otherI: null,
                countE: 0,
                countI: 0
            }
        };
    },
    components: {
        movements: Movements,
        "user-edit": UserEdit,
        "change-pass": ChangePass,
        expense: Expense,
        "pie-chart-exp": PieChartExp,
        "pie-chart-inc": PieChartInc,
        zoomable: Zoomable
    },
    methods: {
        getMovements() {
            axios
                .get("api/wallet/me/movements")
                .then(response => {
                    this.movements = response.data.data;
                })
                .catch(error => {
                    this.$toasted.error("Reload the page to get MOVEMENTS");
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
        getCategories: function() {
            axios
                .get("api/categories")
                .then(response => {
                    this.categories = response.data.data;
                })
                .catch(error => {
                    this.$toasted.error("Reload the page to get CATEGORIES");
                });
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
        },
        showGraph: function() {
            //PIE CHARTS
            let catNameE = [];
            let catNameI = [];
            this.categories.forEach((value, index) => {
                if (value.type == "e") {
                    catNameE.push(value.name);
                } else {
                    catNameI.push(value.name);
                }
            });

            let catTotalE = [];
            let catTotalI = [];
            let numMovE = 0;
            let numMovI = 0;
            this.movements.forEach(m => {
                this.categories.forEach(c => {
                    if (m.type == "Expense") {
                        if (c.name == m.category && c.type == "e") {
                            if (catTotalE[c.id - 1]) {
                                catTotalE[c.id - 1] += parseInt(m.value);
                            } else {
                                catTotalE[c.id - 1] = parseInt(m.value);
                            }
                        } else {
                            if (catTotalE[19]) {
                                catTotalE[19] += parseInt(m.value);
                                numMovE++;
                            } else {
                                catTotalE[19] = parseInt(m.value);
                                numMovE++;
                            }
                        }
                    } else {
                        if (c.name == m.category && c.type == "i") {
                            if (catTotalI[c.id - 20]) {
                                catTotalI[c.id - 20] += parseInt(m.value);
                            } else {
                                catTotalI[c.id - 20] = parseInt(m.value);
                            }
                        } else {
                            if (catTotalI[10]) {
                                catTotalI[10] += parseInt(m.value);
                                numMovI++;
                            } else {
                                catTotalI[10] = parseInt(m.value);
                                numMovI++;
                            }
                        }
                    }
                });
            });
            /* let matrix = [];
            catName.forEach((v,index)=>{
                matrix[index]= [v,catTotal[index]];
            })
            this.pchart = matrix;
            */
            this.pchart.countE = numMovE;
            this.pchart.countI = numMovI;

            this.pchart.otherE = catTotalE[19];
            this.pchart.otherI = catTotalI[10];

            catTotalE.splice(19);
            catTotalI.splice(10);

            this.pchart.seriesE = catTotalE;
            this.pchart.labelsE = catNameE;

            this.pchart.seriesI = catTotalI;
            this.pchart.labelsI = catNameI;

            //ZOOMABLE
            let arrEndBalance = [];
            let arrDate = [];
            this.movements.forEach((value, index) => {
                arrEndBalance.push(value.end_balance);
                arrDate.push(value.date);
            });

            let matrix = [];
            arrDate.forEach((v, index) => {
                matrix[index] = [v, parseInt(arrEndBalance[index])];
            });
            this.graphs = matrix;
            console.log(this.graphs);

            this.showGraphs = true;
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
        this.getCategories();
        this.user = this.$store.state.user;
        console.log("Component mounted.");
    }
};
</script>

<style lang="scss">
@import "./resources/sass/app.scss";
</style>
