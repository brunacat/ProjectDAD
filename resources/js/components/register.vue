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
        <input
            type="text"
            name="name"
            v-model="input.name"
            placeholder="Name"
        />
        <input
            type="text"
            name="email"
            v-model="input.email"
            placeholder="Email"
        />
        <input
            type="password"
            name="password"
            v-model="input.password"
            placeholder="Password"
        />
        <input type="number" name="nif" v-model="input.nif" placeholder="NIF" />
        <button type="button" v-on:click="cancel()">Cancel</button>
        <button type="button" v-on:click="register()">Register</button>
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
                console.log(
                    "FileReader API not supported: use the <form>"
                );
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
