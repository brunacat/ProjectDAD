<template>
    <div>
        <b-navbar toggleable="sm" type="light" variant="light">
            <b-navbar-toggle target="nav-text-collapse"></b-navbar-toggle>
            <router-link to="/">
                <b-navbar-brand>iWallet</b-navbar-brand>
            </router-link>
            <b-navbar-nav class="ml-auto">
                <b-nav-form>
                    <div v-if="!this.$store.state.user">
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
                    <div v-if="this.$store.state.user">
                        {{ this.$store.state.user.name }}
                        <b-button size="sm" class="my-2 my-sm-0" type="submit" v-on:click.prevent="logout()"
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
                    this.$socket.emit("user_exit", this.$store.state.user);
                    this.$store.commit("clearUserAndToken");
                    this.$store.commit("clearUserAndToken");  
                    this.$router.push({ path: "/" });

                })
                .catch(error => {
                    this.$socket.emit("user_exit", this.$store.state.user);
                    this.$store.commit("clearUserAndToken");
                    this.typeofmsg = "alert-danger";
                    this.message = "Logout incorrect. But local credentials were discarded";
                    this.showMessage = true;
                });
        }
    },
    mounted() {
        console.log("Component mounted.");
    },
};
</script>

<style lang="scss">
    @import "./resources/sass/app.scss";
</style>
