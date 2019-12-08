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
                    :state="isEmailValid"
                ></b-form-input>

                <b-form-invalid-feedback :state="isEmailValid">
                </b-form-invalid-feedback>
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

            <strong>{{ message }}</strong>

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
            typeofmsg: "alert-success",
            showMessage: false,
            message: "",
            reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
        };
    },
    methods: {
       login() {
            this.showMessage = false;
            axios
                .post("api/login", this.input)
                .then(response => {
                    this.$store.commit("setToken", response.data.access_token);
                    return axios.get("api/users/me");
                })
                .then(response => {
                    this.$store.commit("setUser", response.data.data);
                    //this.$socket.emit("user_enter", response.data.data);
                    this.typeofmsg = "alert-success";
                    this.message = "User authenticated correctly";
                    this.showMessage = true;
                    this.$router.push({ path: '/wallet' });
                })
                .catch(error => {
                    this.$store.commit("clearUserAndToken");
                    this.typeofmsg = "alert-danger";
                    this.message = "Invalid credentials";
                    this.showMessage = true;
                    console.log(error);
                });
        }
    },
    computed: {
        isEmailValid() {
            return this.reg.test(this.input.email);
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
