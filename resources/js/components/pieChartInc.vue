<template>
    <div align="center">
        <apexcharts
            width="700"
            type="pie"
            :options="chartOptions"
            :series="series"
        ></apexcharts>
        <p></p>
    </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";

export default {
    name: "Chart",
    components: {
        apexcharts: VueApexCharts
    },
    props: ["pchart"],
    data: function() {
        return {
            chartOptions: {
                labels: this.pchart.labelsI,
                chart: {
                    id: "vuechart-example"
                },
                legend: {
                    show: false
                },
                title: {
                    text: "Income Value per Category",
                    align: "center",
                    margin: 10,
                    offsetX: 0,
                    offsetY: 0,
                    floating: false,
                    style: {
                        fontSize: "25px",
                        color: "#263238"
                    }
                },
                subtitle: {
                    text:
                        "There are " +
                        this.pchart.countI +
                        " uncategorized incomes with a total value of " +
                        this.pchart.otherI +
                        "€ that are not included in the chart.",
                    align: "center",
                    style: {
                        fontSize: "15px",
                        color: "#263238"
                    }
                }
            },
            series: this.pchart.seriesI
        };
    }
};
</script>

<style lang="scss">
</style>