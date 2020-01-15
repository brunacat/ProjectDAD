<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">TOTAL OF WALLETS</div>
                    <div class="card-body">
                        {{ totalWallets }}
                        <p/>
                        {{ totalSum }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            totalWallets: null,
            totalSum:null
        };
    },
    methods: {
        getWallets: function() {
            axios.get("api/wallets/total").then(response => {
                this.totalWallets = response.data;
            });
             axios.get("api/wallets/totalSum").then(response => {
                this.totalSum = response.data;
            });
        },
        getTotalSum : function(){
            axios.get("api/wallets/totalSum").then(response => {
                this.totalSum = response.data;
            });
        }
    },
    mounted() {
        this.getWallets();
        this.getTotalSum();

    }
};
</script>

<style lang="scss">
@import "./resources/sass/app.scss";
</style>
