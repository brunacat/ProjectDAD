<template>
    <div>
        <b-navbar toggleable="sm" type="light" variant="light">
            <b-navbar-toggle target="nav-text-collapse"></b-navbar-toggle>
            <router-link to="/">
                <b-navbar-brand>iWallet</b-navbar-brand>
            </router-link>
            <b-navbar-nav class="ml-auto">
                <b-nav-form>
                    <div>
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
                </b-nav-form>
            </b-navbar-nav>
        </b-navbar>
        <br />
    </div>
</template>

<style lang="scss">
@import "./resources/sass/app.scss";
</style>
