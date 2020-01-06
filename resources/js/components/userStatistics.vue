<template>
  <div>
    <p> {{ l1 }} </p>
    <p>{{ l2 }} </p>
  </div>
</template>
<script type="text/javascript">
export default {
  props: ["statistics"],
  data() {
    return {
      l1: "The aplication has " + this.statistics.userCount +" users, " + this.statistics.hasMoney +" of them have money.",
      l2: "From the " + this.statistics.noMoney + " that do not have money " + this.statistics.inactive +" are inactive"
    };
  }
};
</script>