<template>
    <div class="jumbotron">
        <h2>Edit Password</h2>
        
        <div class="form-group">
            <label for="inputOldPass">Old Password</label>
            <input
                type="password"
                class="form-control"
                v-model="input.oldPass"
                name="oldPass"
                id="inputOldPass"
                placeholder="Old Password"
            />
        </div>

        <div class="form-group">
            <label for="inputNewPass">New Password</label>
            <input
                type="password"
                class="form-control"
                v-model="input.newPass"
                name="newPass"
                id="inputNewPass"
                placeholder="New Password"
            />
        </div>

        <div class="form-group">
            <label for="inputConfPass">New Password Confirmation</label>
            <input
                type="password"
                class="form-control"
                v-model="input.confNewPass"
                name="confNewPass"
                id="inputConfPass"
                placeholder="New Password Confirmation"
            />
        </div>

        <div class="form-group">
            <b-button
                type="save"
                variant="primary"
                v-on:click.prevent="savePass()"
                >Save</b-button
            >
            <b-button
                type="cancel"
                variant="light"
                v-on:click.prevent="cancelPass()"
                >Cancel</b-button
            >
        </div>
    </div>
</template>

<script type="text/javascript">
import PictureInput from "vue-picture-input";

export default {
    props: ["user"],
    data() {
        return {
            input: {
                oldPass: "",
                newPass: "",
                confNewPass: ""
            }
        };
    },
    methods: {
        savePass: function() {
            if (this.input.newPass == this.input.confNewPass) {
                axios
                    .put("api/users/pass/" + this.user.id, this.input)
                    .then(response => {
                        this.$emit("pass-saved");
                    });
            } else {
                this.$toasted.error(
                    "New Password must match with password confirmation"
                );
            }
        },
        cancelPass: function() {
            this.$emit("pass-canceled");
        }
    },
    mounted() {}
};
</script>

<style lang="scss">
@import "./resources/sass/app.scss";
</style>