<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Type</th>
            <th>Transfer</th>
            <th>Category</th>
            <th>Date</th>
            <th>StartBalance</th>
            <th>EndBalance</th>
            <th>Value</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="movement in movements"  :key="movement.id">
            <td>{{ movement.type }}</td>
            <td>{{ movement.transfer }}</td>
            <td>{{ movement.category_id }}</td>
            <td>{{ movement.date }}</td>
            <td>{{ movement.start_balance }}</td>
            <td>{{ movement.end_balance }}</td>
            <td>{{ movement.value }}</td>


        </tr>
        </tbody>
    </table>
</template>

<script type="text/javascript">
    // Component code (not registered)
    export default {
        data: function () {
            return {
                movements: []
            }
        },
        mounted() {
            axios.get('api/wallet/me/movements')
                .then(response=>{
                    this.movements = response.data.data;
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
</script>

<style scoped>
    /*	  Specific style applied only on the component*/
</style>
