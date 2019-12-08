<template>
    <div>
        {{balance}}
    </div>
</template>

<script>
export default {
    data() {
        return {
            balance: ""
        };
    },
    methods: {
        getBalance() {
            axios.get("api/wallet/me").then(response => {
                this.balance = response.data.data.balance;
            });
        }
    },
    mounted() {
        this.getBalance();
        console.log("Component mounted.");
    }
};
</script>
