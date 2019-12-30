<template>
  <div>
    <b-container fluid>
      <!-- User Interface controls -->
      <b-row>
        <b-col lg="6" class="my-1">
          <b-form-group
            label="Filter"
            label-cols-sm="3"
            label-align-sm="right"
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
                <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </b-col>

        <b-col sm="5" md="6" class="my-1">
          <b-form-group
            label="Per page"
            label-cols-sm="6"
            label-cols-md="4"
            label-cols-lg="3"
            label-align-sm="right"
            label-size="sm"
            label-for="perPageSelect"
            class="mb-0"
          >
            <b-form-select v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-form-select>
          </b-form-group>
        </b-col>

        <b-col sm="7" md="6" class="my-1">
          <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
            align="fill"
            size="sm"
            class="my-0"
          ></b-pagination>
        </b-col>
      </b-row>

      <!-- Main table element -->
      <b-table
        show-empty
        small
        stacked="md"
        :items="users"
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
          <b-button size="sm" @click="deleteUser(row.item)">Delete/Deactivate</b-button>
        </template>
      </b-table>
    </b-container>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Photo</th>
          <th>Name</th>
          <th>Email</th>
          <th>Type</th>
          <th>Balance</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id" :class="{ activerow: editingUser === user }">
          <td>
            <img :src="'storage/fotos/' + user.photo" contain height="51px" width="50px" />
          </td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.type }}</td>
          <td>{{ user.balance }}</td>
          <td>{{ user.active }}</td>
          <td>
            <!-- <a
                        class="btn btn-sm btn-success"
                        v-on:click.prevent="sendMessageTo(user)"
                        >Msg</a
            >-->
            <!-- <b-button
                        size="sm"
                        type="edit"
                        variant="primary"
                        v-on:click.prevent="editUser(user)"
                        >Edit</b-button
            >-->
            <b-button
              size="sm"
              type="delete"
              variant="danger"
              v-on:click.prevent="deleteUser(user)"
            >Delete</b-button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script type="text/javascript">
// Component code (not registered)
export default {
  props: ["users"],
  data: function() {
    return {
      fields: [
        {
          key: "photo",
          sortable: false
        },
        { key: "name", sortable: true },
        { key: "email", sortable: true },
        { key: "type", sortable: true },
        { key: "balance", sortable: true },
        { key: "active", sortable: true, label: "Status" },
        { key: "actions", label: "Actions" }
      ],
      totalRows: 304,
      currentPage: 1,
      perPage: 5,
      pageOptions: [5, 10, 15, 100],
      sortBy: "",
      sortDesc: false,
      sortDirection: "asc",
      filter: null,
      filterOn: [],
      infoModal: {
        id: "info-modal",
        title: "",
        content: ""
      }
    };
  },
  computed: {
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter(f => f.sortable)
        .map(f => {
          return { text: f.label, value: f.key };
        });
    }
  },
  mounted() {},
  methods: {
    deleteUser: function(user) {
      if (user.balance != "Has money") {
        this.$emit("delete-click", user.id);
      } else {
        if (user.id == this.$store.state.user.id) {
          this.$toasted.error("Cant Delete your Self");
        } else {
          this.$toasted.error("Cant Deactivate users with balance");
        }
      }
    },
    onFiltered(filteredItems) {
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    }
  }
};
</script>

<style scoped>
tr.activerow {
  background: #123456 !important;
  color: #fff !important;
}
</style>
