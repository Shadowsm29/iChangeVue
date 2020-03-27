<template>
  <div>
    <div class="d-flex justify-content-center mt-5" v-if="loadingData">
      <spinner-app colorClass="ing-text" />
    </div>
    <div class="card" v-if="!loadingData">
      <div class="card-header ing-bg">
        <span v-if="mode == 'edit'">Edit Role</span>
        <span v-if="mode == 'new'">Add New Role</span>
      </div>
      <div class="card-body">
        <div class="row">
          <input-app label="Role Name" v-model="form.name" />
          <div class="col-md-6">
            <div class="form-group">
              <label for="permissions">Permissions:</label>
              <multiselect
                :options="permissions"
                label="name"
                track-by="id"
                :multiple="true"
                :close-on-select="false"
                v-model="form.permissions"
              ></multiselect>
              <!-- <select
                class="form-control"
                name="permissions"
                id="permissions"
                multiple
                v-model="form.permissions"
              >
                <option
                  v-for="permission in permissions"
                  :key="permission.id"
                  :value="permission.id"
                >{{ permission.name }}</option>
              </select>-->
            </div>
          </div>
        </div>

        <div class="text-center">
          <button class="btn ing-btn" @click="submit" :disabled="savingData || disabled">
            <span v-if="mode=='edit'">Save</span>
            <span v-else>Submit</span>
            <spinner-app v-if="savingData" :small="true" />
          </button>
          <router-link class="btn btn-primary" :to="{ name: 'iam.roles' }">Back</router-link>
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

export default {
  components: {
    InputApp: Input,
    SelectApp: Select,
    SpinnerApp: Spinner
  },

  data() {
    return {
      mode: "",
      form: {
        name: "",
        permissions: []
      },
      permissions: [],
      loadingData: true,
      savingData: false,
      role: null
    };
  },

  computed: {
    disabled() {
      return this.form.name.length == 0;
    }
  },

  mounted() {
    this.loadingData = true;

    if (this.$route.name === "iam.roles-edit") this.mode = "edit";
    else this.mode = "new";

    if (this.mode == "edit") {
      let rolePromise = axios
        .get("/api/roles/" + this.$route.params.id)
        .then(({ data }) => {
          this.form.name = data.name;
          this.form.permissions = data.permissions;
          // .map(p => {
          //   return p.id;
          // });
        })
        .catch(() => {
          alert("Something went wrong while loading role");
        });

      let permissionsPromise = axios
        .get("/api/permissions")
        .then(({ data }) => {
          this.permissions = data;
        })
        .catch(() => {
          alert("Something went wrong while loading permissions");
        });

      Promise.all([rolePromise, permissionsPromise]).then(() => {
        this.loadingData = false;
      });
    } else {
      axios
        .get("/api/permissions")
        .then(({ data }) => {
          this.permissions = data;
          this.loadingData = false;
        })
        .catch(() => {
          alert("Something went wrong while loading permissions");
        });
    }
  },

  methods: {
    submit() {
      this.savingData = true;

      let newForm = Object.assign({}, this.form);
      newForm.permissions = newForm.permissions.map(p => p.id);

      if (this.mode == "edit") {
        axios
          .post("/api/roles/" + this.$route.params.id + "/update", newForm)
          .then(({ data }) => {
            handler.handleSuccessResponse("Role updated successfully");
            this.savingData = false;
          })
          .catch(err => {
            handler.handleErrorResponse(err);
            this.savingData = false;
          });
      } else {
        axios
          .post("/api/roles/new", newForm)
          .then(({ data }) => {
            handler.handleSuccessResponse("Role created successfully");
            this.savingData = false;
            this.$router.push({ name: "iam.roles" });
          })
          .catch(err => {
            handler.handleErrorResponse(err);
            this.savingData = false;
          });
      }
    }
  }
};
</script>

