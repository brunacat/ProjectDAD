<template>
<div>
<div v-if="!this.$store.state.user" >
        <b-jumbotron>
        <h1>401 (Unauthorized)</h1>
        </b-jumbotron>
  </div>
  <div v-else-if="this.$store.state.user.type=='o'" class="jumbotron">
    <h2>Add Expense</h2>

    <input type="radio" id="cash" value="c" v-model="income.type" />
    <label for="one">Cash</label>
    <br />
    <input type="radio" id="transfer" value="bt" v-model="income.type" />
    <label for="two">Transfer</label>
    <br />
    <p></p>

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
      <input type="text" class="form-control" v-model="income.iban" name="iban" id="iban" />
    </div>
    <div class="form-group">
      <b-button type="save" variant="primary" v-on:click.prevent="addIncome()">Save</b-button>
      <b-button type="reset" variant="light">Reset</b-button>
    </div>
  </div>
  <div v-else >
        <b-jumbotron>
        <h1>401 (Unauthorized)</h1>
        </b-jumbotron>
  </div>
  </div>
</template>

<script type="text/javascript">
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
      }
    };
  },
  methods: {
    addIncome: function() {
      if (this.income.type == "c") {
        axios
          .post("api/incomeC", this.income)
          .then(response => {

          });
      } else {
          axios
          .post("api/incomeBT", this.income)
          .then(response => {

          });
      }
    }
  },
  mounted() {
  }
};
</script>

<style scoped></style>
