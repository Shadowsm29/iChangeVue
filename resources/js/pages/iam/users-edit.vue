<template>
  <div>
    <div class="d-flex justify-content-center mt-5" v-if="loadingData">
      <spinner-app colorClass="ing-text" />
    </div>
    <div class="card" v-if="!loadingData">
      <div class="card-header ing-bg">
        <span v-if="mode == 'edit'">Edit User</span>
        <span v-if="mode == 'new'">Add New User</span>
      </div>
      <div class="card-body">
        <div class="row">
          <input-app label="User Name" v-model="form.name" />
          <input-app label="Email" type="email" v-model="form.email" />
          <input-app label="Password" type="password" v-model="form.password" />
          <input-app label="Repeat Password" type="password" v-model="form.passwordRepeat" />
          <select-app label="Role" :options="roles" v-model="form.role" />
          <div class="col-md-6">
            <div class="form-group">
              <Label>Line Manager:</Label>
              <vue-multiselect-app :options="users" label="name" track-by="id" v-model="form.manager" />
            </div>
          </div>
        </div>

        <div class="text-center">
          <button class="btn ing-btn" @click="submit" :disabled="savingData || disabled">
            Save
            <spinner-app v-if="savingData" :small="true" />
          </button>
          <router-link class="btn btn-primary" :to="{ name: 'iam.users' }">Back</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Input from "~/components/Input";
import Select from "~/components/Select";
import Spinner from "~/components/Spinner";
import axios from "axios";
import * as handler from "~/plugins/response-handler";
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
      mode: "",
      form: {
        name: "",
        email: "",
        password: "",
        passwordRepeat: "",
        role: "",
        manager: null,
      },
      roles: [],
      users: [],
      loadingData: true,
      savingData: false
    };
  },

  computed: {
    disabled() {
      return this.form.name.length == 0 || this.form.email.length == 0;
    }
  },

  mounted() {
    this.loadingData = true;

    if (this.$route.name === "iam.users-edit") this.mode = "edit";
    else this.mode = "new";

    let rolesPromise = axios
      .get("/api/roles")
      .then(({ data }) => {
        this.roles = data;
      })
      .catch(() => {
        alert("Something went wrong while loading roles");
      });

    let usersPromise = axios
      .get("/api/users")
      .then(({ data }) => {
        this.users = data;
      })
      .catch(() => {
        alert("Something went wrong while loading users");
      });

    let userPromise;
    if (this.mode == "edit") {
      userPromise = axios
        .get("/api/users/" + this.$route.params.id)
        .then(({ data }) => {
          console.log("created -> data", data);
          this.form.name = data.name;
          this.form.email = data.email;
          this.form.password = data.password;
          this.form.passwordRepeat = data.passwordRepeat;
          this.form.role = data.roles[0].id;
          this.form.manager = data.manager;
        })
        .catch(() => {
          alert("Something went wrong while loading selected user");
        });
    }

    Promise.all([userPromise, usersPromise, rolesPromise]).then(() => {
      this.loadingData = false;
    });
  },

  methods: {
    submit() {
      this.savingData = true;

      let newForm = Object.assign({}, this.form);
      newForm.manager = newForm.manager.id;
      console.log("submit -> newForm.manager", newForm.manager)

      if (this.mode == "edit") {
        axios
          .post("/api/users/" + this.$route.params.id + "/update", newForm)
          .then(({ data }) => {
            this.name = data.name;
            this.email = data.email;
            this.role = data.roles[0].id;
            handler.handleSuccessResponse(
              "User updated successfully",
              this.$store.commit
            );
            this.savingData = false;
          })
          .catch(err => {
            handler.handleErrorResponse(err, this.$store.commit);
            this.savingData = false;
          });
      } else {
        axios
          .post("/api/users/new", newForm)
          .then(({ data }) => {
            handler.handleSuccessResponse(
              "User created successfully",
              this.$store.commit
            );
            this.savingData = false;
            this.$router.push({ name: "iam.users" });
          })
          .catch(err => {
            handler.handleErrorResponse(err, this.$store.commit);
            this.savingData = false;
          });
      }
    }
  }
};
</script>