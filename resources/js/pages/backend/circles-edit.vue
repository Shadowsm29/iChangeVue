<template>
  <div>
    <div class="card">
      <div
        class="card-header ing-border ing-bg"
      >{{ mode === 'edit' ? 'Edit Circle' : 'Add New Circle' }}</div>
      <div class="card-body">
        <div class="row">
          <input-app v-if="mode === 'edit'" :disabled="!$can(EDIT_CIRCLES)" v-model="circle.name" label="Circle Name" type="text" />
          <input-app
            v-if="mode === 'new'"
            v-model="newCircle.name"
            label="Circle Name"
            type="text"
          />

          <select-app
            v-if="mode === 'edit'"
            :disabled="!$can(EDIT_CIRCLES)"
            v-model="circle.super_circle_id"
            :options="superCircles"
            label="Super Circle"
          />
          <select-app
            v-if="mode === 'new'"
            v-model="newCircle.super_circle_id"
            :options="superCircles"
            label="Super Circle"
          />
        </div>

        <div class="d-flex justify-content-center mt-2">
          <button class="btn ing-btn mr-2" @click="submit" :disabled="disabled" v-if="( mode == 'edit' && $can(EDIT_CIRCLES) ) || ( mode == 'new' && $can(CREATE_CIRCLES) )">
            <span>Submit</span>
            <spinner-app v-if="sendingData" :small="true" />
          </button>
          <router-link class="btn btn-primary" :to="{ name: 'backend.circles'}">Back</router-link>
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
      superCircles: this.$store.getters["backend-mgmt/superCircles"],
      sendingData: false,
      mode: null,
      newCircle: {
        name: "",
        super_circle_id: ""
      },
      test: ""
    };
  },

  computed: {
    circle() {
      const circles = this.$store.getters["backend-mgmt/circles"];
      const circle = circles.filter(c => c.id === this.$route.params.id)[0];
      return Object.assign({}, circle);
    },
    disabled() {
      if (this.mode === "edit") {
        return !this.circle.name || !this.circle.super_circle_id;
      } else if (this.mode === "new") {
        return !this.newCircle.name || !this.newCircle.super_circle_id;
      }
    }
  },

  methods: {
    submit() {
      this.sendingData = true;

      if (this.mode === "edit") {
        this.$store.dispatch("backend-mgmt/updateCircle", this.circle).then(
          res => {
            this.$router.push({ name: "backend.circles" });
          },
          err => {
            this.sendingData = false;
          }
        );
      } else if (this.mode === "new") {
        this.$store.dispatch("backend-mgmt/addNewCircle", this.newCircle).then(
          res => {
            this.$router.push({ name: "backend.circles" });
          },
          err => {
            this.sendingData = false;
          }
        );
      }
    },
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      if (to.name === "backend.circles-new") {
        vm.mode = "new";
      } else if (to.name === "backend.circles-edit") {
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