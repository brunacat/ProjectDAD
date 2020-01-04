<template>
    <GChart
    type="ColumnChart"
    :data="chartData"
    :options="chartOptions"
  />
</template>


<script>
export default {
    props:["pchart"],
  data () {
    return {

      chartData:null,
      chartOptions: {
        chart: {
          title: 'Expenses per category'
        }
      }
    }
  },
  mounted(){
      this.chartData= this.pchart;
  }
}
</script>
