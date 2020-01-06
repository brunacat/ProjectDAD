<template>
    <div class="jumbotron">
        <h2>Edit Movement</h2>

        <div class="form-group">
            <select v-model="movement.category">
                <option v-for="category in categories" :value="category.id">{{
                    category.name
                }}</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <b-form-textarea
                class="form-control"
                v-model="movement.description"
                name="desc"
                id="description"
            />
        </div>

        <div class="form-group">
            <b-button
                type="save"
                variant="primary"
                v-on:click.prevent="saveMovement()"
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
export default {
    props: ["movement"],
    data() {
        return {
            categories: []
        };
    },
    methods: {
        saveMovement: function() {
            axios.put("api/movementsEdit", this.movement).then(response => {
                this.$emit("movement-saved");
            });
        },
        cancelEdit: function() {
            this.$emit("edit-canceled");
        },
        getCategories: function() {
            axios
                .get("api/categories")
                .then(response => {
                    let arrI = [];
                    let arrE = [];
                    response.data.data.forEach(element => {
                        if (element.type == "i") {
                            arrI.push(element);
                        } else {
                            arrE.push(element);
                        }
                    });

                    if (this.movement.type == "Income") {
                        this.categories = arrI;
                    } else {
                        this.categories = arrE;
                    }
                })
                .catch(error => {
                    this.$toasted.error("Reload the page to get CATEGORIES");
                });
        }
    },
    mounted() {
        this.getCategories();
    }
};
</script>

<style lang="scss">
@import "./resources/sass/app.scss";
</style>