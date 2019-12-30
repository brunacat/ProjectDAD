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
            <b-button type="submit" variant="primary" v-on:click.prevent="login()"
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
            },
            };
    },
    methods: {
       login() {
            axios
                .post("api/login", this.input)
                .then(response => {
                    this.$store.commit("setToken", response.data.access_token);
                    return axios.get("api/users/me");
                })
                .then(response => {
                    this.$store.commit("setUser", response.data.data);
                    this.$socket.emit("user_enter", response.data.data);
                    this.$toasted.success("Login successful");
                    if (response.data.data.type =="u") {
                        this.$router.push({ path: '/wallet' });
                    }else if (response.data.data.type =="a") {
                        this.$router.push({ path: '/users' });
                    }else if (response.data.data.type =="o") {
                        this.$router.push({ path: '/operator' });
                    }
                })
                .catch(error => {
                    this.$store.commit("clearUserAndToken");
                    this.$toasted.error("Invalid Credentials");
                    console.log(error);
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
