<template>
  <div>
    <div class="card">
      <div
        class="card-header ing-border ing-bg"
      >{{ mode === 'edit' ? 'Edit Justification' : 'Add New Justification' }}</div>
      <div class="card-body">
        <div class="row">
          <input-app
            v-if="mode === 'edit'"
            v-model="justification.name"
            label="Justification Name"
            type="text"
            :disabled="!$can(EDIT_JUSTIFICATIONS)"
          />
          <input-app
            v-if="mode === 'new'"
            v-model="newJustification.name"
            label="Justification"
            type="text"
          />
        </div>

        <div class="d-flex justify-content-center mt-2">
          <button
            class="btn ing-btn mr-2"
            @click="submit"
            :disabled="disabled"
            v-if="(mode=='edit' && $can(EDIT_JUSTIFICATIONS)) || (mode=='new' && $can(CREATE_JUSTIFICATIONS))"
          >
            <span>Submit</span>
            <spinner-app v-if="sendingData" :small="true" />
          </button>
          <router-link class="btn btn-primary" :to="{ name: 'backend.justifications'}">Back</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Spinner from "../../components/Spinner";
import Input from "../../components/Input";
import Select from "../../components/Select";

export default {
  data() {
    return {
      sendingData: false,
      mode: null,
      newJustification: {
        name: ""
      }
    };
  },

  computed: {
    justification() {
      const justifications = this.$store.getters["backend-mgmt/justifications"];
      const justification = justifications.filter(
        sc => sc.id === this.$route.params.id
      )[0];
      return Object.assign({}, justification);
    },
    disabled() {
      if (this.mode === "edit") {
        return !this.justification.name;
      } else if (this.mode === "new") {
        return !this.newJustification.name;
      }
    }
  },

  methods: {
    submit() {
      this.sendingData = true;

      if (this.mode === "edit") {
        this.$store
          .dispatch("backend-mgmt/updateJustification", this.justification)
          .then(
            res => {
              this.$router.push({ name: "backend.justifications" });
            },
            err => {
              this.sendingData = false;
            }
          );
      } else if (this.mode === "new") {
        this.$store
          .dispatch("backend-mgmt/addNewJustification", this.newJustification)
          .then(
            res => {
              this.$router.push({ name: "backend.justifications" });
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
      if (to.name === "backend.justifications-new") {
        vm.mode = "new";
      } else if (to.name === "backend.justifications-edit") {
        vm.mode = "edit";
      }
    });
  },

  components: {
    SpinnerApp: Spinner,
    InputApp: Input,
    SelectApp: Select
  }
};
</script>