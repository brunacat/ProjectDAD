<template>
  <div class="jumbotron">
    <h2>Add Expense</h2>

    <input type="radio" id="payment" value="Payment" v-model="type" />
    <label for="one">Payment</label>
    <br />
    <input type="radio" id="trasfer" value="Transfer" v-model="type" />
    <label for="two">Transfer</label>
    <br />
    <p></p>
    <div class="form-group">
      <label for="valueExpense">Value of the Expense</label>
      <input
        type="number"
        class="form-control"
        v-model="value"
        name="valueExp"
        id="valueExpense"
        placeholder="Value of  the Expense"
      />
    </div>
    <div>
      <select v-model="category">
        <option disabled value>Category</option>
        <option
          v-for="category in categories"
          v-bind:value="category.id"
          v-if="category.type=='e'"
        >{{category.name}}</option>
      </select>
    </div>
    <p />
    <p />

    <div v-if="type=='Transfer'" class="form-group">
      <label for="emailDestination">Destination Email</label>
      <input
        type="email"
        class="form-control"
        v-model="transfer.email"
        name="valueExp"
        id="emailDestination"
      />
    </div>
    <div v-if="type=='Transfer'" class="form-group">
      <label for="valueExpense">Description of the Expense</label>
      <b-form-textarea
        class="form-control"
        v-model="transfer.description"
        name="valueExp"
        id="valueExpense"
      />
    </div>

    <input type="radio" id="mb" value="mb" v-if=" type == 'Payment'" v-model="typeP" />
    <label v-if=" type == 'Payment'" for="mb">MB payment</label>
    <br />
    <input type="radio" id="bt" value="bt" v-if=" type == 'Payment'" v-model="typeP" />
    <label v-if=" type == 'Payment'" for="bt">Bank Transfer</label>
    <br />
    <p></p>
    <div v-if=" typeP == 'bt'" class="form-group">
      <label for="iban">IBAN</label>
      <input type="text" class="form-control" v-model="payment.iban" name="iban" id="iban" />
    </div>
    <div v-if=" typeP == 'mb'" class="form-group">
      <label for="mbECode">MB Entity Code</label>
      <input
        type="number"
        class="form-control"
        v-model="payment.mbECode"
        name="mbECode"
        id="mbECode"
      />
    </div>
    <div v-if=" typeP == 'mb'" class="form-group">
      <label for="mbRef">MB Payment Reference</label>
      <input type="number" class="form-control" v-model="payment.mbRef" name="mbRef" id="mbRef" />
    </div>
    <div class="form-group">
      <b-button type="save" variant="primary" v-on:click.prevent="addExpense()">Save</b-button>
      <b-button type="cancel" variant="light" v-on:click.prevent="cancelExpense()">Cancel</b-button>
    </div>
  </div>
</template>

<script type="text/javascript">
export default {
  props: ["user"],
  data() {
    return {
      type: "Payment",
      typeP: 0,
      categories: null,
      category: "",
      value: 0,
      transfer: {
        category: "",
        value: 0,
        email: "",
        description: ""
      },
      payment: {
        category: "",
        value: 0,
        type: "",
        iban: null,
        mbECode: null,
        mbRef: null
      }
    };
  },
  methods: {
    getCategories: function() {
      axios.get("api/categories").then(response => {
        this.categories = response.data.data;
      });
    },
    addExpense: function() {
      if (this.type == "Transfer") {
        this.transfer.category = this.category;
        this.transfer.value = this.value;
        axios
          .post("api/transfer/" + this.user.id, this.transfer)
          .then(response => {
            this.user.balance = response.data;
            this.$emit("expense-added");
          });
      } else {
        this.payment.category = this.category;
        this.payment.value = this.value;
        this.payment.type = this.typeP;
        if (this.typeP == "mb") {
          axios
            .post("api/paymentMB/" + this.user.id, this.payment)
            .then(response => {
              this.user.balance = response.data;
              this.$emit("expense-added");
            });
        } else {
          axios
            .post("api/paymentBT/" + this.user.id, this.payment)
            .then(response => {
              this.user.balance = response.data;
              this.$emit("expense-added");
            });
        }
      }
    },
    cancelExpense: function() {
      this.$emit("expense-canceled");
    }
  },
  mounted() {
    this.getCategories();
  }
};
</script>

<style scoped></style>
