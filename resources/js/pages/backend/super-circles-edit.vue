<template>
  <div>
    <div class="card">
      <div
        class="card-header ing-border ing-bg"
      >{{ mode === 'edit' ? 'Edit Super Circle' : 'Add New Super Circle' }}</div>
      <div class="card-body">
        <div class="row">
          <input-app
            v-if="mode === 'edit'"
            v-model="superCircle.name"
            label="Super Circle Name"
            type="text"
            :disabled="!$can(EDIT_SUPER_CIRCLES)"
          />
          <input-app
            v-if="mode === 'new'"
            v-model="newSuperCircle.name"
            label="Circle Name"
            type="text"
          />
          <div class="col-md-6">
            <div class="form-group">
              <label for="headOfUsers">Hed of Supercircle:</label>
              <vue-multiselect-app
                v-if="!loadingData"
                :options="headOfUsers"
                label="name"
                track-by="id"
                v-model="headOf"
              />
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-center mt-2">
          <button
            class="btn ing-btn mr-2"
            @click="submit"
            :disabled="disabled"
            v-if="(mode == 'edit' && $can(EDIT_SUPER_CIRCLES)) || (mode == 'new' && $can(CREATE_SUPER_CIRCLES)) "
          >
            <span>Submit</span>
            <spinner-app v-if="sendingData" :small="true" />
          </button>
          <router-link class="btn btn-primary" :to="{ name: 'backend.super-circles'}">Back</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Spinner from "../../components/Spinner";
import Input from "../../components/Input";
import Select from "../../components/Select";
import VueMultiselect from "vue-multiselect";

export default {
  data() {
    return {
      sendingData: false,
      mode: null,
      newSuperCircle: {
        name: ""
      },
      headOf: null,
      headOfUsers: null,
      loadingData: true
    };
  },

  created() {
    this.$http
      .get("/api/users")
      .then(({ data }) => {
        this.headOfUsers = data;
        this.loadingData = false;
      })
      .catch(err => {
        this.handleErrorResponse(err);
      });
  },

  computed: {
    superCircle() {
      const superCircles = this.$store.getters["backend-mgmt/superCircles"];
      const superCircle = superCircles.filter(
        sc => sc.id === this.$route.params.id
      )[0];
      this.headOf = superCircle.head_of;
      return Object.assign({}, superCircle);
    },
    disabled() {
      if (this.mode === "edit") {
        return !this.superCircle.name;
      } else if (this.mode === "new") {
        return !this.newSuperCircle.name;
      }
    }
  },

  methods: {
    submit() {
      this.sendingData = true;

      if (this.mode === "edit") {
        let form = Object.assign({}, this.superCircle);
        form.headOf = this.headOf.id;

        this.$store
          .dispatch("backend-mgmt/updateSuperCircle", form)
          .then(
            res => {
              this.$router.push({ name: "backend.super-circles" });
            },
            err => {
              this.sendingData = false;
            }
          );
      } else if (this.mode === "new") {
        let form = Object.assign({}, this.newSuperCircle);
        form.headOf = this.headOf.id;
        console.log("submit -> form", form)

        this.$store
          .dispatch("backend-mgmt/addNewSuperCircle", form)
          .then(
            res => {
              this.$router.push({ name: "backend.super-circles" });
            },
            err => {
              this.sendingData = false;
            }
          );
      }
    }
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      if (to.name === "backend.super-circles-new") {
        vm.mode = "new";
      } else if (to.name === "backend.super-circles-edit") {
        vm.mode = "edit";
      }
    });
  },

  components: {
    SpinnerApp: Spinner,
    InputApp: Input,
    SelectApp: Select,
    VueMultiselectApp: VueMultiselect
  }
};
</script>
