<template>
  <div>
    <button class="btn ing-btn btn-sm" :disabled="!$can(CREATE_SUPER_CIRCLES)" @click="addNewSuperCircle">Add New Super Circle</button>
    <bootstrap-table-app class="bt-table" :columns="columns" :data="data" :options="options" />
    <modal-app id="modal" title="Delete Circle" :text="modalText">
      <button class="btn btn-danger" @click="deleteSuperCircle">
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

export default {
  components: {
    ModalApp: Modal,
    SpinnerApp: Spinner,
  },
  data() {
    return {
      modalText: "",
      deleting: false,
      rowToDelete: null,
      columns: [
        {
          title: "Super Circle",
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
                name: "backend.super-circles-edit",
                params: { id: row.id }
              });
            },
            "click .delete": (e, value, row, index) => {
              this.modalText = `Are you sure you would like to delete super circle ${row.name}?`;
              this.rowToDelete = row;
              $("#modal").modal("show");
            }
          },
          formatter: (value, row, index) => {
            return [
              `<button class='btn btn-primary btn-sm mr-2 edit'>${this.$can(this.EDIT_SUPER_CIRCLES) ? "Edit" : "Open"}</button>`,
              `<button class='btn btn-danger btn-sm delete' ${this.$can(this.DELETE_SUPER_CIRCLES) ? "" : "disabled"}>Delete</button>`
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
      }
    };
  },
  computed: {
    superCircles() {
      return this.$store.getters["backend-mgmt/superCircles"];
    },
    data() {
      return this.superCircles.map(c => {
        return {
          id: c.id,
          name: c.name,
        };
      });
    }
  },
  methods: {
    addNewSuperCircle() {
      this.$router.push({
        name: "backend.super-circles-new"
      });
    },
    deleteSuperCircle() {
      this.deleting = true;
      this.$store.dispatch("backend-mgmt/deleteSuperCircle", this.rowToDelete).then(
        res => {
          this.deleting = false;
          $("#modal").modal("hide");
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