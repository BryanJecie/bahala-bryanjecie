<template>
  <table class="table table-striped table-condensed">
    <thead>
      <tr>
        <th>Type</th>
        <th>Name</th>
        <th>E-mail</th>
        <th>Status</th>
        <th>action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in items" :key="item.id">
        <td scope="row">
          <strong class="text-uppercase">
            {{ item.type }}
          </strong>
        </td>
        <td>
          {{ item.name }}
        </td>
        <td>
          <a href="#"> {{ item.email }}</a>
        </td>
        <td>
          {{ item.active ? "Active" : "Inactive" }}
        </td>
        <td>
          <a :href="item.route_show" class="btn btn-sm btn-success"> View </a>
          <a :href="item.route_edit" class="btn btn-sm btn-info"> Edit </a>
          <button class="btn btn-sm btn-danger" @click="onDelete(item)">
            Delete
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      items: [],
    };
  },
  mounted() {
    this.loadUsers();
  },
  methods: {
    loadUsers() {
      axios.get("/admin/auth/user/all-users").then((resp) => {
        this.items = resp.data;
      });
    },

    onDelete(item) {
      let text = "Are you sure to delete this user?.";
      if (confirm(text) == true) {
        axios
          .delete("/admin/auth/user/delete-user", {
            params: {
              user_id: item.id,
            },
          })
          .then(() => {
            this.loadUsers();
          })
          .catch((error) => {
            alert(error.response.data.error);
          });
      }
    },
  },
};
</script>

<style>
</style>
