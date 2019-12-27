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
    <div v-if="type=='Transfer'" class="form-group">
      <label  for="valueExpenseT">Value of the Expense</label>
      <input
        type="number"
        class="form-control"
        v-model="transfer.value"
        name="valueExpT"
        id="valueExpenseT"
        placeholder="Value of  the Expense"
      />
    </div>
    <div v-if="type=='Payment'" class="form-group">
      <label for="valueExpenseP">Value of the Expense</label>
      <input
        type="number"
        class="form-control"
        v-model="payment.value"
        name="valueExpP"
        id="valueExpenseP"
        placeholder="Value of  the Expense"
      />
    </div>

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
    
    <input type="radio" id="mb" value="Mb" v-if=" type == 'Payment'" v-model="typeP" />
    <label v-if=" type == 'Payment'" for="mb">MB payment</label>
    <br />
    <input type="radio" id="bt" value="Bt" v-if=" type == 'Payment'" v-model="typeP" />
    <label v-if=" type == 'Payment'" for="bt">Bank Transfer</label>
    <br />
    <p>
    </p>
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
      transfer:{
          value:0,
          email:"",
          description:"",
      },
      payment:{
          value:0,
      }
    };
  },
  methods: {
    addExpense: function() {
      if (this.input.newPass == this.input.confNewPass) {
        axios
          .put("api/users/pass/" + this.user.id, this.input)
          .then(response => {
            this.$emit("expense-added");
          });
      } else {
        this.$toasted.error(
          "New Password must match with password confirmation"
        );
      }
    },
    cancelExpense: function() {
      this.$emit("expense-canceled");
    }
  },
  mounted() {}
};
</script>

<style scoped></style>
