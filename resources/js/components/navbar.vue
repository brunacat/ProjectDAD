<template>
    <div>
        <b-navbar toggleable="sm" type="light" variant="light">
            <b-navbar-toggle target="nav-text-collapse"></b-navbar-toggle>
            <router-link to="/">
                <b-navbar-brand>iWallet</b-navbar-brand>
            </router-link>
            <b-navbar-nav class="ml-auto">
                <b-nav-form>
                    <div v-if="this.$store.state.token === ''">
                        <router-link to="/login">
                            <b-button
                                size="sm"
                                class="my-2 my-sm-0"
                                type="submit"
                                >Login</b-button
                            >
                        </router-link>
                        <router-link to="/register">
                            <b-button
                                size="sm"
                                class="my-2 my-sm-0"
                                type="submit"
                                >Register</b-button
                            >
                        </router-link>
                    </div>
                    <div v-if="this.$store.state.token !== ''">
                        <b-button size="sm" class="my-2 my-sm-0" type="submit" v-on:click="logout()"
                            >Logout</b-button
                        >
                    </div>
                </b-nav-form>
            </b-navbar-nav>
        </b-navbar>
        <br />
    </div>
</template>

<script>
export default {
    data() {
        return {
            currentUser: "",
        };
    },
    methods: {
        logout() {
            axios
                .post(
                    "api/logout",
                    {
                        headers: {
                            Authorization: "Bearer " + this.$store.state.token
                        }
                    }
                )
                .then(response => {
                    this.$store.commit("clearUserAndToken");
                    this.$router.push({ path: "/" });
                })
                .catch(error => {
                    this.errorMessage = error.response.data.msg;
                    this.showError = true;
                });
        }
    },
    mounted() {
        console.log("Component mounted.");
    },
    onChanged() {

    }
};
</script>

<style lang="scss">
@import "./resources/sass/app.scss";
</style>
