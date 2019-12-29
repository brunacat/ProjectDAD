<template>
    <div id="register">
        <h1>Register</h1>
        <picture-input
            ref="photo"
            @change="onChange"
            accept="image/jpeg,image/png"
            size="5"
            buttonClass="btn"
            radius="50"
            :hideChangeButton="true"
            :customStrings="{
                drag: 'Click here to upload photo'
            }"
        ></picture-input>

        <b-form>
            <b-form-group id="input-group-1" label="Name: " label-for="name">
                <b-form-input
                    id="name"
                    v-model="input.name"
                    type="text"
                    required
                    placeholder="Name"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-2" label="Email: " label-for="email">
                <b-form-input
                    id="email"
                    v-model="input.email"
                    type="email"
                    required
                    placeholder="Email"
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-4" label="NIF: " label-for="nif">
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

            <b-button type="reset" variant="danger"
                >Reset</b-button
            >
            <b-button type="submit" variant="primary" v-on:click.prevent="register"
                >Register</b-button
            >
        </b-form>
    </div>
</template>

<script>
import PictureInput from "vue-picture-input";
export default {
    name: "Register",
    data: function() {
        return {
            input: {
                name: "",
                email: "",
                password: "",
                nif: "",
                photo: null
            }
        };
    },
    components: {
        PictureInput
    },
    methods: {
        register: function() {
            axios
                .post("api/user/register", this.input)
                .then(response => {
                    if (this.input.photo != null) {
                        this.submitFile();
                    }
                    this.$toasted.success("Register successful");
                    this.$router.push({ path: "/login" });

                })
                .catch(error => {
                    this.$toasted.error(error.response.data.errors.email);
                    this.$toasted.error(error.response.data.errors.nif);
                    this.$toasted.error(error.response.data.errors.password);
                });
        },
        submitFile() {
            let formData = new FormData();
            formData.append("photo", this.$refs.photo.file);
            axios
                .post("api/upload-image", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(function() {
                    console.log("SUCCESS!!");
                })
                .catch(function() {
                    console.log("FAILURE!!");
                });
        },
        onChange(photo) {
            if (photo) {
                this.input.photo = this.$refs.photo.file.name;
                console.log(this.input.photo);
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
