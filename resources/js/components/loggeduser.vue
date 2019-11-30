<template>
    <div >
        <h1>LOGGED, BITCH...</h1>
        <button type="button" v-on:click="logout()">Logout</button>
    </div>
</template>

<script>

    export default {

        data() {
            return {}
        },
        methods: {
            logout() {
                axios.post('api/logout',{}, {headers:{'Authorization':"Bearer " + this.$root.token}})
                    .then(response=>{
                        this.$root.token = '';
                        this.$router.push({path: '/'})
                    })
                    .catch(error=>{
                        this.errorMessage = error.response.data.msg;
                        this.showError = true;
                    });
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
