<template>
    <div>
    <div>
        {{balance}}
    </div>

    <Movements/>
    </div>

</template>

<script>

    import Movements from './Movements'

export default {
    data() {
        return {
            balance: ""

        };
    },
    components: {
        Movements
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
