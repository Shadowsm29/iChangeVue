<template>
  <div>
    <button class="btn ing-btn btn-sm" @click="addNewUser">Add New User</button>
    <div class="d-flex justify-content-center">
      <spinner-app v-if="loadingData" colorClass="ing-text mt-5" />
    </div>
    <bootstrap-table-app
      v-if="!loadingData"
      class="bt-table"
      :columns="columns"
      :data="users"
      :options="options"
    />
    <modal-app id="modal" title="Delete User" :text="modalText">
      <button class="btn btn-danger" @click="deleteUser">
        <span>Delete</span>
        <spinner-app v-if="deleting" :small="true" />
      </button>
    </modal-app>
  </div>
</template>

<script>
import Modal from "../../components/Modal";
import Spinner from "../../components/Spinner";
import * as $ from "jquery";
import axios from "axios";
import * as handler from "../../plugins/response-handler";

export default {
  components: {
    ModalApp: Modal,
    SpinnerApp: Spinner
  },
  data() {
    return {
      modalText: "",
      deleting: false,
      rowToDelete: null,
      columns: [
        {
          title: "Name",
          field: "name",
          sortable: true
        },
        {
          title: "Email",
          field: "email",
          sortable: true
        },
        {
          title: "Role",
          field: "role",
          sortable: false
        },
        {
          field: "Actions",
          title: "Actions",
          align: "center",
          clickToSelect: false,
          events: {
            "click .edit": (e, value, row, index) => {
              console.log("data -> id: row.id", row.id);
              this.$router.push({
                name: "iam.users-edit",
                params: { id: row.id }
              });
            },
            "click .delete": (e, value, row, index) => {
              this.modalText = `Are you sure you would like to user ${row.name}?`;
              this.rowToDelete = row;
              $("#modal").modal("show");
            }
          },
          formatter: function(value, row, index) {
            return [
              `<button class='btn btn-primary btn-sm mr-2 edit'>Edit</button>`,
              `<button class='btn btn-danger btn-sm delete'>Delete</button>`
            ].join("");
          }
        }
      ],
      options: {
        search: true,
        classes: "table",
        sortName: "name",
        sortOrder: "asc",
        pagination: true
      },
      data: null,
      loadingData: true,
      users: null
    };
  },

  created() {
    this.loadingData = true;

    let usersPromise = axios
      .get("/api/users")
      .then(({ data }) => {
        this.users = data.map(user => {
          return {
            id: user.id,
            name: user.name,
            email: user.email,
            role: user.roles[0].name
          };
        });
        this.loadingData = false;
      })
      .catch(() => {
        alert("Something went wrong while loading users");
      });
  },
  methods: {
    addNewUser() {
      this.$router.push({
        name: "iam.users-new"
      });
    },
    deleteUser() {
      this.deleting = true;
      axios.delete(`/api/users/${this.rowToDelete.id}/delete`, this.rowToDelete).then(
        res => {
          const deletedUser = this.users.filter( u => u.id == this.rowToDelete.id);
          this.users.splice(this.users.indexOf(deletedUser), 1);
          this.deleting = false;
          $("#modal").modal("hide");
          handler.handleSuccessResponse("User deleted successfully", this.$store.commit);
        },
        error => {
          this.deleting = false;
          $("#modal").modal("hide");
        }
      );
    }
  }
};
</script>

<style scoped>
/deep/ .page-item.active .page-link {
  background-color: rgb(255, 98, 0) !important;
  border-color: rgb(255, 98, 0) !important;
  color: white !important;
}

/deep/ .page-link {
  color: rgb(255, 98, 0) !important;
}

/deep/ .dropdown-item.active {
  background-color: rgb(255, 98, 0) !important;
}

/deep/ .btn-secondary {
  background-color: rgb(255, 98, 0) !important;
  border-color: rgb(255, 98, 0) !important;
  color: white !important;
}
</style>