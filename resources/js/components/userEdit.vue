<template>
    <div class="jumbotron">
        <h2>Edit User</h2>
        <picture-input
            v-model="user.photo"
            ref="photo"
            accept="image/jpeg,image/png"
            size="10"
            buttonClass="btn"
            radius="50"
            :hideChangeButton="true"
            :customStrings="{
                upload: '<h1>Bummer!</h1>',
                drag: 'Click here to upload photo',
            }"
        ></picture-input>
        <div class="form-group">
            <label for="inputName">Name</label>
            <input
                type="text"
                class="form-control"
                v-model="user.name"
                name="name"
                id="inputName"
                placeholder="Fullname"
            />
        </div>
        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input
                type="email"
                class="form-control"
                v-model="user.email"
                name="email"
                id="inputEmail"
                placeholder="Email address"
            />
        </div>

        <div class="form-group">
            <label for="inputNif">NIF</label>
            <input
                type="number"
                class="form-control"
                v-model="user.nif"
                name="nif"
                id="inputNif"
                placeholder="NIF"
            />
        </div>

        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()"
                >Cancel</a
            >
        </div>
    </div>
</template>

<script type="text/javascript">
import PictureInput from "vue-picture-input";
export default {
    props: ["user"],
    components: {
        PictureInput
    },
    methods: {
        saveUser: function() {
            axios.put("api/users/" + this.user.id, this.user).then(response => {
                // Copy object properties from response.data.data to this.user
                // without creating a new reference
                Object.assign(this.user, response.data.data);
                this.$emit("user-saved", this.user);
            });
        },
        cancelEdit: function() {
            axios.get("api/users/" + this.user.id).then(response => {
                // Copy object properties from response.data.data to this.user
                // without creating a new reference
                Object.assign(this.user, response.data.data);
                this.$emit("user-canceled", this.user);
            });
        }
    }
};
</script>

<style scoped></style>
