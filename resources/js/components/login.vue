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
        };
    },
    methods: {
        login() {
            axios
                .post("api/login", this.input)
                .then(response => {
                    console.log(response.data.access_token);
                })
                .catch(error => {
                    console.log(error);
                    console.log("user errado");
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
</style>
