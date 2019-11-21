<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">TOTAL OF WALLETS</div>

                    <div class="card-body">
                        {{totalWallets}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function(){
            return {
                totalWallets : null,
            }
        },
        methods:{
        getWallets: function(){
            axios.get('api/wallets/total')
                .then(response=>{this.totalWallets = response.data;});
        }
    },
        mounted() {
            this.getWallets();
        }
    }
</script>
<style scoped>
</style>