<template>
    <div>
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
            <tr v-for="movement in movements.data" :key="movement.id">
                <td>{{ movement.type }}</td>
                <td>{{ movement.transfer }}</td>
                <td>{{ movement.category }}</td>
                <td>{{ formatDate(movement.date) }}</td>
                <td>{{ movement.start_balance }}</td>
                <td>{{ movement.end_balance }}</td>
                <td>{{ movement.value }}</td>
            </tr>
            </tbody>
        </table>
        <pagination :data="movements" v-bind:limit="6" @pagination-change-page="getResults"></pagination>
    </div>

</template>

<script type="text/javascript">
    // Component code (not registered)
    export default {
        data: function () {
            return {
                movements: {}
            }
        },

        created() {
            this.getResults();
            this.formatDate();
        },

        methods: {

            formatDate(date) {

                var moment = require('moment');
                return moment(date).format('llll');

            },

            getResults(page) {

                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get('api/wallet/me/movements?page=' + page)
                    .then(response=>{
                        this.movements = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }

    }
</script>

<style scoped>
    /*	  Specific style applied only on the component*/
</style>
