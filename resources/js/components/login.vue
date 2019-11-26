<template>
    <div id="login">
        <h1>Login</h1>
        <input type="text" name="email" v-model="input.email" placeholder="Email" />
        <input type="password" name="password" v-model="input.password" placeholder="Password" />
        <button type="button" v-on:click="login()">Login</button>
    </div>
</template>

<script>
    export default {
        name: 'Login',
        data() {
            return {
                input: {
                    email: "",
                    password: ""
                }
            }
        },
        methods: {
            login() {
                axios.post('api/login', this.input)
                .then(response=>{
                    console.log(response.data.access_token);
                })
                .catch(error=>{
                    console.log(error);
                    console.log("user errado");
                });
            }
        }
    }
</script>

<style lang="scss">
     @import "./resources/sass/app.scss";
</style>