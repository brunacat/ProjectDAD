<template>
    <div id="register">
        <h1>Register</h1>
        <picture-input
            ref="photo"
            @change="onChange"
            accept="image/jpeg,image/png"
            size="10"
            buttonClass="btn"
            radius="50"
            :hideChangeButton="true"
            :customStrings="{
                upload: '<h1>Bummer!</h1>',
                drag: 'Optional'
            }"
        ></picture-input>

        <b-form>
            <b-form-group
                id="input-group-1"
                label="Name: "
                label-for="name"
            >
                <b-form-input
                    id="name"
                    v-model="input.name"
                    type="text"
                    required
                    placeholder="Name"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-2"
                label="Email: "
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
                id="input-group-4"
                label="NIF: "
                label-for="nif"
            >
                <b-form-input
                    id="nif"
                    v-model="input.nif"
                    type="number"
                    required
                    placeholder="NIF"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-4"
                label="Password:"
                label-for="password"
            >
                <b-form-input
                    id="password"
                    v-model="input.password"
                    type="password"
                    required
                    placeholder="Password"
                ></b-form-input>
            </b-form-group>

            <b-button type="reset" variant="danger" v-on:click="cancel()"
                >Reset</b-button
            >
            <b-button type="submit" variant="primary" v-on:click="register()"
                >Register</b-button
            >
        </b-form>
    </div>
</template>

<script>
import PictureInput from "vue-picture-input";
export default {
    name: "Register",
    data() {
        return {
            input: {
                name: "",
                email: "",
                password: "",
                nif: "",
                photo: ""
            }
        };
    },
    components: {
        PictureInput
    },
    methods: {
        register() {},
        cancel() {},
        onChange(image) {
            console.log("New picture selected!");
            if (image) {
                console.log("Picture loaded.");
                this.image = image;
            } else {
                console.log("FileReader API not supported: use the <form>");
            }
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
