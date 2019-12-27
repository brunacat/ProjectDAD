<template>
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
            <tr
                v-for="user in users"
                :key="user.id"
                :class="{ activerow: editingUser === user }"
            >
                <td>
                    <img
                        :src="'storage/fotos/' + user.photo"
                        contain
                        height="51px"
                        width="50px"
                    />
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
                    > -->
                    <!-- <b-button
                        size="sm"
                        type="edit"
                        variant="primary"
                        v-on:click.prevent="editUser(user)"
                        >Edit</b-button
                    > -->
                    <b-button
                        size="sm"
                        type="delete"
                        variant="danger"
                        v-on:click.prevent="deleteUser(user)"
                        >Delete</b-button
                    >
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script type="text/javascript">
// Component code (not registered)
export default {
    props: ["users"],
    data: function() {
        return {
            editingUser: null
        };
    },
    methods: {
        /*editUser: function(user) {
            this.editingUser = user;
            this.$emit("edit-click", user);
        },*/
        deleteUser: function(user) {
            this.editingUser = null;
            this.$emit("delete-click", user);
        }
        /*sendMessageTo: function(user) {
            let msg = window.prompt(
                'What do you want to say to "' + user.name + '"'
            );
            this.$socket.emit(
                "privateMessage",
                msg,
                this.$store.state.user,
                user
            );
        }*/
    }
    /*sockets: {
        user_changed(changedUser) {
            let idx = this.users.findIndex(user => user.id == changedUser.id);
            if (idx >= 0) {
                this.$set(this.users, idx, changedUser);
            }
        }

        // user_changed (changedUser) {
        //   let changedUserIdx = this.getChangedUserIdx(changedUser.id);
        //   if (changedUserIdx >= 0) {
        //     this.$set(this.users, changedUserIdx, changedUser);
        //   }
        // }
    }*/
};
</script>

<style scoped>
tr.activerow {
    background: #123456 !important;
    color: #fff !important;
}
</style>
