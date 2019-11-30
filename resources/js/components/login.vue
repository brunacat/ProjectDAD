<template>
    <div id="login">
        <h1>Login</h1>
        <b-form>
            <b-form-group
                id="input-group-1"
                label="Email address:"
                label-for="email"
            >
                <b-form-input
                    id="email"
                    v-model="input.email"
                    type="email"
                    required
                    placeholder="Email"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-2"
                label="Your Password:"
                label-for="password"
            >
                <b-form-input
                    id="input-2"
                    v-model="input.password"
                    type="password"
                    required
                    placeholder="Password"
                ></b-form-input>
            </b-form-group>
            <b-button type="submit" variant="primary" v-on:click="login()"
                >Login</b-button
            >
        </b-form>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            input: {
                email: "",
                password: ""
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
        console.log("Component mounted.");
    }
};
</script>

<style lang="scss">
     @import "./resources/sass/app.scss";
     h4.hidden {
         visibility: hidden;
     }
</style>
