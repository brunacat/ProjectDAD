<template>
    <div class="jumbotron">
        <h2>Edit User</h2>
        <picture-input
            v-model="user.photo"
            ref="photo"
            size="10"
            buttonClass="btn"
            radius="50"
            :prefill="'storage/fotos/' + user.photo"
            :hideChangeButton="true"
            :customStrings="{
                drag: 'Click here to upload photo'
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
            <b-button
                type="save"
                variant="primary"
                v-on:click.prevent="saveUser()"
                >Save</b-button
            >
            <b-button
                type="cancel"
                variant="light"
                v-on:click.prevent="cancelEdit()"
                >Cancel</b-button
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
            console.log(this.user);
            axios
                .put("api/users/" + this.user.id, this.user)
                .then(response => {
                    // Copy object properties from response.data.data to this.user
                    // without creating a new reference
                    Object.assign(this.user, response.data.data);
                    this.$emit("user-saved", this.user);
                });
        },
        cancelEdit: function() {
            this.$emit("user-canceled");
        }
    },
    mounted() {}
};
</script>

<style scoped></style>
