<template>
  <div class="container">
    <div v-if="loadingData" class="d-flex justify-content-center mt-5">
      <spinner-app colorClass="ing-text" />
    </div>
    <div v-else class="card ing-border">
      <div class="card-header ing-bg">Register Idea</div>
      <div class="card-body">
        <div class="row">
          <input-app label="Title" columnClass="col-md-12" v-model="form.title" />
          
          <select-app v-if="$can('create advanced ideas')" label="Change Type" :options="changeTypes" v-model="form.changeType" />
          <div v-else class="col-md-6">
            <div class="form-group">
              <label for="change-type">Change Type</label>
              <select id="change-type" class="form-control" v-model="justDoItId" disabled>
                <option :value="justDoIt.id">{{justDoIt.name}}</option>
              </select>
            </div>
          </div>

          <select-app label="Justification" :options="justifications" v-model="form.justification" />
          <select-app
            label="Impacted Supercircle"
            :options="superCircles"
            v-model="form.superCircle"
          />
          <select-app label="Impacted Circle" :options="filteredCircles" v-model="form.circle" />
          <input-app
            label="Expected benefit (Hours per Week)"
            type="number"
            v-model="form.expectedBenefit"
          />
          <input-app
            v-if="form.changeType == justDoItId"
            label="Expected effort"
            type="number"
            v-model="form.expectedEffort"
          />
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="description">SME:</label>
              <vue-multiselect-app :options="users" track-by="id" label="name" v-model="form.sme" />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="description">Line Manager:</label>
              <input type="text" class="form-control" disabled v-model="user.manager.name" />
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="description">Head of Supercircle:</label>
              <input type="text" class="form-control" disabled v-model="headOf" />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="description">Description:</label>
              <textarea name="description" class="form-control" rows="5" v-model="form.description"></textarea>
            </div>
          </div>

          <div class="col-md-12">
            <div class="d-flex justify-content-center">
              <button class="btn ing-btn mr-2" :disabled="disabled" @click="submit">Submit</button>
              <button class="btn btn-primary" @click="$router.go(-1)">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Input from "../../components/Input";
import Select from "../../components/Select";
import Spinner from "../../components/Spinner";
import VueMultiselect from "vue-multiselect";

export default {
  components: {
    InputApp: Input,
    SelectApp: Select,
    SpinnerApp: Spinner,
    VueMultiselectApp: VueMultiselect
  },

  data() {
    return {
      form: {
        title: "",
        changeType: "",
        justification: "",
        superCircle: "",
        circle: "",
        expectedBenefit: "",
        expectedEffort: "",
        description: "",
        sme: null,
      },
      loadingData: true,
      changeTypes: [],
      justifications: [],
      superCircles: [],
      circles: [],
      filteredCircles: [],
      justDoItId: null,
      justDoIt: null,
      users: [],
      user: this.$store.getters["auth/user"],
      headOf: ""
    };
  },

  computed: {
    disabled() {
      if (
        this.form.title == "" ||
        this.form.changeType == "" ||
        this.form.justification == "" ||
        this.form.circle == "" ||
        this.form.superCircle == "" ||
        this.form.expectedBenefit == "" ||
        this.form.description == "" ||
        (this.form.expectedEffort == "" &&
          this.form.changeType == this.justDoItId) ||
        this.form.sme == null
      ) {
        return true;
      } else return false;
    }
  },

  watch: {
    "form.superCircle"() {
      this.filteredCircles = this.circles.filter(
        c => c.super_circle_id == this.form.superCircle
      );
      this.form.circle = this.filteredCircles[0].id;

      this.headOf = this.superCircles.filter(
        sc => sc.id == this.form.superCircle
      )[0].head_of.name;
    }
  },

  created() {
    this.loadingData = true;

    let changeTypesPromise = this.$http
      .get("/api/change-types")
      .then(({ data }) => {
        this.changeTypes = data;
        this.justDoItId = this.changeTypes.filter(
          ct => ct.name == "Just Do It"
        )[0].id;
        if(!this.$can("create advanced ideas")) {
          this.justDoIt = this.changeTypes.find(ct => ct.name == "Just Do It");
          this.form.changeType = this.justDoItId;
        }
      })
      .catch(err => {
        this.handleErrorResponse(err);
      });

    let justificationsPromise = this.$http
      .get("/api/justifications")
      .then(({ data }) => {
        this.justifications = data;
      })
      .catch(err => {
        this.handleErrorResponse(err);
      });

    let superCirclesPromise = this.$http
      .get("/api/super-circles")
      .then(({ data }) => {
        this.superCircles = data;
      })
      .catch(err => {
        this.handleErrorResponse(err);
      });

    let circlesPromise = this.$http
      .get("/api/circles")
      .then(({ data }) => {
        this.circles = data;
      })
      .catch(err => {
        this.handleErrorResponse(err);
      });

    let usersPromise = this.$http
      .get("/api/users")
      .then(({ data }) => {
        this.users = data;
      })
      .catch(err => {
        this.handleErrorResponse(err);
      });

    Promise.all([
      changeTypesPromise,
      justificationsPromise,
      superCirclesPromise,
      circlesPromise,
      usersPromise
    ]).then(() => {
      this.loadingData = false;
    });
  },

  mounted() {
    console.log(this.$can('create advanced ideas'));
  },

  methods: {
    submit() {
      let form = Object.assign({}, this.form);
      form.sme = form.sme.id;
      this.$http
        .post("/api/ideas/create", form)
        .then(() => {
          this.handleSuccessResponse("Idea registered successfully");
          this.$router.push({name: "ideas.all"});
        })
        .catch(err => {
          this.handleErrorResponse(err);
        });
    }
  }
};
</script>