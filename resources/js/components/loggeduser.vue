<template>
    <div >
        <h1>LOGGED</h1>
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
                axios.post('api/logout',{}, {headers:{'Authorization':"Bearer " + this.$root.$data.token}})
                    .then(response=>{
                        this.$root.$data.token = '';
                        this.$root.$data.user=null;
                        localStorage.clear();
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
