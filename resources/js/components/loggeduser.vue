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
                <pie-chart :pchart="pchart" v-if="showGraphs"></pie-chart>
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
import PieChart from "./pieChart.vue";

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
            graphs: {
                date: "",
                endBalance: ""
            },
            showGraphs: false,
            categories: null,
            pchart:{
                series:null,
                labels:null

            }
        };
    },
    components: {
        movements: Movements,
        "user-edit": UserEdit,
        "change-pass": ChangePass,
        expense: Expense,
        "pie-chart": PieChart
    },
    methods: {
        getMovements() {
            axios.get("api/wallet/me/movements").then(response => {
                this.movements = response.data.data;

                //this.barChartData = this.movements.end_balance;
                let arrEndBalance = [];
                this.movements.forEach((value, index) => {
                    arrEndBalance.push(value.end_balance);
                    //console.log(value);
                    //console.log(index);
                });

                let arrDate = [];
                this.movements.forEach((value, index) => {
                    arrDate.push(value.date);
                    //console.log(value);
                    //console.log(index);
                });

                this.graphs.endBalance = arrEndBalance;
                this.graphs.date = arrDate;
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
        getCategories: function(){
             axios.get("api/categories").then(response => {
                this.categories = response.data.data;
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
            console.log(this.categories);
            let arrDate = [];
            this.categories.forEach((value, index) => {
                arrDate.push(value.name);
            });

            let arr = [];
            this.movements.forEach(m => {
                this.categories.forEach(c => {
                    if (c.name == m.category) {
                        if (arr[c.id - 1]) {
                            arr[c.id - 1] += parseInt(m.value);
                        } else {
                            arr[c.id - 1] = parseInt(m.value);
                        }
                    } else {
                        if (arr[29]) {
                            arr[29] += parseInt(m.value);
                        } else {
                            arr[29] = parseInt(m.value);
                        }
                    }
                });
            });
           /* let matrix = [];
            arrDate.forEach((v,index)=>{
                matrix[index]= [v,arr[index]];
            })
            this.pchart = matrix;
            */
           this.pchart.series =arr;
           this.pchart.labels =arrDate;
           console.log(this.pchart);


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
