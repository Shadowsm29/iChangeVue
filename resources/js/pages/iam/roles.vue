<template>
  <div>
    <button class="btn ing-btn btn-sm" @click="addNewRole">Add New Role</button>
    <div class="d-flex justify-content-center">
      <spinner-app v-if="loadingData" colorClass="ing-text mt-5" />
    </div>
    <bootstrap-table-app
      v-if="!loadingData"
      class="bt-table"
      :columns="columns"
      :data="roles"
      :options="options"
    />
    <modal-app id="modal" title="Delete Role" :text="modalText">
      <button class="btn btn-danger" @click="deleteRole">
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
          field: "Actions",
          title: "Actions",
          align: "center",
          clickToSelect: false,
          events: {
            "click .edit": (e, value, row, index) => {
              this.$router.push({
                name: "iam.roles-edit",
                params: { id: row.id }
              });
            },
            "click .delete": (e, value, row, index) => {
              this.modalText = `Are you sure you would like to delete role ${row.name}?`;
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
      roles: null
    };
  },

  created() {
    this.loadingData = true;

    axios
      .get("/api/roles")
      .then(({ data }) => {
        this.roles = data.map(role => {
          return {
            id: role.id,
            name: role.name,
          };
        });
        this.loadingData = false;
      })
      .catch(() => {
        alert("Something went wrong while loading roles");
      });
  },
  methods: {
    addNewRole() {
      this.$router.push({
        name: "iam.roles-new"
      });
    },
    deleteRole() {
      this.deleting = true;
      axios.delete(`/api/roles/${this.rowToDelete.id}/delete`, this.rowToDelete).then(
        res => {
          const deletedRole = this.roles.filter( r => r.id == this.rowToDelete.id);
          this.roles.splice(this.roles.indexOf(deletedRole), 1);
          this.deleting = false;
          $("#modal").modal("hide");
          handler.handleSuccessResponse("Role deleted successfully");
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