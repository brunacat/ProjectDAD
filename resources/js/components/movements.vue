<template>
    <div>
        <b-container fluid>
            <!-- User Interface controls -->
            <b-row>
                <b-col lg="6" class="my-1">
                    <b-form-group
                        label="Filter"
                        label-cols-sm="3"
                        label-align-sm="left"
                        label-size="sm"
                        label-for="filterInput"
                        class="mb-0"
                    >
                        <b-input-group size="sm">
                            <b-form-input
                                v-model="filter"
                                type="search"
                                id="filterInput"
                                placeholder="Type to Search"
                            ></b-form-input>
                            <b-input-group-append>
                                <b-button
                                    :disabled="!filter"
                                    @click="filter = ''"
                                    >Clear</b-button
                                >
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col sm="5" md="6" class="my-1">
                    <b-form-group
                        label="Per page"
                        label-cols-sm="6"
                        label-cols-md="4"
                        label-cols-lg="3"
                        label-align-sm="left"
                        label-size="sm"
                        label-for="perPageSelect"
                        class="mb-0"
                    >
                        <b-form-select
                            v-model="perPage"
                            id="perPageSelect"
                            size="sm"
                            :options="pageOptions"
                        ></b-form-select>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col lg="9" class="my-1">
                    <b-form-group
                        label="Filter On"
                        label-cols-sm="3"
                        label-align-sm="left"
                        label-size="sm"
                        description="Leave all unchecked to filter on all data"
                        class="mb-0"
                    >
                        <b-form-checkbox-group v-model="filterOn" class="mt-1">
                            <b-form-checkbox value="id">ID</b-form-checkbox>
                            <b-form-checkbox value="type">Type</b-form-checkbox>
                            <b-form-checkbox value="category"
                                >Category</b-form-checkbox
                            >
                            <b-form-checkbox value="type_payment"
                                >Type Of Payment</b-form-checkbox
                            >
                            <b-form-checkbox value="email"
                                >Transfer Email</b-form-checkbox
                            >
                        </b-form-checkbox-group>
                    </b-form-group>
                </b-col>
            </b-row>
            <!-- Main table element -->
            <b-table
                show-empty
                small
                stacked="md"
                :items="movements"
                :fields="fields"
                :current-page="currentPage"
                :per-page="perPage"
                :filter="filter"
                :filterIncludedFields="filterOn"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :sort-direction="sortDirection"
                @filtered="onFiltered"
            >
                <template v-slot:cell(actions)="row">
                    <b-button v-if="!toggleEdit" size="sm" @click="edit(row.item)">Edit</b-button>
                    <b-button size="sm" @click="row.toggleDetails"
                        >{{
                            row.detailsShowing ? "Hide" : "Show"
                        }}
                        Details</b-button
                    >
                </template>

                <template v-slot:row-details="row">
                    <b-card>
                        <ul>
                            <li v-for="(value, key) in row.item" :key="key">
                                {{ key }} : {{ value }}
                                <img
                                    v-if="
                                        key == 'photo' &&
                                            value != 'Not a transfer' &&
                                            value != 'No image'
                                    "
                                    :src="'storage/fotos/' + value"
                                    width="50"
                                    height="50"
                                />
                            </li>
                        </ul>
                    </b-card>
                </template>
            </b-table>
            <b-row>
                <b-col sm="7" md="6" class="my-1">
                    <b-pagination
                        v-model="currentPage"
                        :total-rows="movements.length"
                        :per-page="perPage"
                        align="fill"
                        size="sm"
                        class="my-0"
                    ></b-pagination>
                </b-col>
            </b-row>
        </b-container>
        <edit-movement
            v-if="toggleEdit"
            :movement="movement"
            @movement-saved="movementSaved"
            @edit-canceled="editCanceled"
        >
        </edit-movement>
    </div>
</template>

<script type="text/javascript">
import EditMovement from "./editMovement.vue";

export default {
    props: ["movements"],
    data: function() {
        return {
            fields: [
                { key: "id" },
                { key: "type" },
                { key: "email" },
                { key: "type_payment" },
                { key: "category" },
                { key: "date" },
                { key: "start_balance" },
                { key: "end_balance" },
                { key: "value" },
                { key: "actions", label: "Actions" }
            ],
            currentPage: 1,
            perPage: 5,
            pageOptions: [5, 10, 15],
            sortBy: "date",
            sortDesc: true,
            sortDirection: "desc",
            filter: null,
            filterOn: [],
            infoModal: {
                id: "info-modal",
                title: "",
                content: ""
            },
            toggleEdit: false,
            movement: []
        };
    },
    created() {
        this.formatDate();
    },
    methods: {
        formatDate(date) {
            var moment = require("moment");
            return moment(date).format("llll");
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        movementSaved() {
            this.$emit('get-movements');
        },
        editCanceled() {
          this.toggleEdit = false;
        },
        edit(item){
          this.toggleEdit = true;
          this.movement = item;
        }
    },
    components: {
        "edit-movement": EditMovement
    }
};
</script>

<style scoped>
/*	  Specific style applied only on the component*/
</style>
