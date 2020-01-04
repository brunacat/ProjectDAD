<template>
    <div>
      <apexchart width="380" type="donut" :series="series"></apexchart>
    </div>
  </template>


<script>
import VueApexCharts from 'vue-apexcharts'
export default {
    props:["pchart"],
  data () {
    return {
      options: {},
      series: []

 

    }
},
components: {
        apexchart: VueApexCharts
    },
  methods: {
    getdata: function(){
      console.log(this.pchart.series);
      console.log(this.pchart.labels)
      
     this.series =this.pchart.series;
    }
  },
  mounted(){
      this.getdata();


  }
}
</script>