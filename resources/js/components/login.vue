<template>
    <div id="login">
        <h1>Login</h1>
        <input type="text" name="email" v-model="email" placeholder="Email" />
        <input type="password" name="password" v-model="password" placeholder="Password" />
        <button type="button" v-on:click="login(email, password)">Login</button>
        <h4 class="hidden" id="error">Wrong Email or Password</h4>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                email:null, password:null
            }
        },
        methods: {
            login(email, password) {
                axios.post('api/login', {'email':email, 'password':password})
                .then(response=>{
                    this.$root.token = response.data.access_token;
                    this.$router.push({path: '/wallet'});
                    document.getElementById("error").classList.add("hidden");
                })
                .catch(error=>{
                    this.errorMessage = error.response.data.msg;
                    this.showError = true;
                    document.getElementById("error").classList.remove("hidden");
                });
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style lang="scss">
     @import "./resources/sass/app.scss";
     h4.hidden {
         visibility: hidden;
     }
</style>
