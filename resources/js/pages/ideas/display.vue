<template>
  <div class="container">
    <div v-if="loadingData" class="d-flex justify-content-center mt-5">
      <spinner-app colorClass="ing-text" />
    </div>
    <div v-else>
      <div class="card ing-border">
        <div class="card-header ing-bg">{{ idea.request_number }}</div>
        <div class="card-body">
          <div class="row">
            <input-app
              columnClass="col-md-2"
              label="Request Number"
              v-model="idea.request_number"
              :disabled="true"
            />
            <input-app columnClass="col-md-10" label="Title" v-model="idea.title" :disabled="true" />
          </div>
          <div class="row">
            <input-app label="Change Type" v-model="idea.change_type.name" :disabled="true" />
            <input-app label="Justification" v-model="idea.justification.name" :disabled="true" />
          </div>
          <div class="row">
            <input-app label="Circle" v-model="idea.circle.name" :disabled="true" />
            <input-app label="Super Circle" v-model="idea.super_circle.name" :disabled="true" />
          </div>
          <div class="row">
            <input-app label="Expected Benefit" v-model="idea.expected_benefit" :disabled="true" />
            <input-app label="Expected Effort" v-model="idea.expected_effort" :disabled="true" />
          </div>
          <div class="row">
            <input-app label="SME" v-model="idea.sme.name" :disabled="true" />
            <input-app
              label="Head of Supercircle"
              v-model="idea.super_circle.head_of.name"
              :disabled="true"
            />
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="description">Description:</label>
                <textarea
                  class="form-control"
                  id="description"
                  rows="5"
                  v-model="idea.description"
                  disabled
                ></textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea class="form-control" id="comment" rows="5" v-model="comment"></textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="text-center">
                <button class="button btn ing-btn">Approve</button>
                <button class="button btn btn-danger">Decline</button>
                <button class="button btn btn-warning">Back to Submitter</button>
                <button class="button btn btn-primary" @click="saveAsLineManager">Save</button>
                <button class="button btn btn-primary">Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Spinner from "../../components/Spinner";
import Input from "../../components/Input";

export default {
  components: {
    SpinnerApp: Spinner,
    InputApp: Input
  },

  data() {
    return {
      idea: null,
      loadingData: true,
      comment: "",
    };
  },

  created() {
    this.$http
      .get("/api/ideas/" + this.$route.params.id)
      .then(({ data }) => {
        this.idea = data;
        this.loadingData = false;
      })
      .catch(err => {
        this.handleErrorResponse(err);
      });
  },

  methods: {
    saveAsLineManager() {
      this.$http.post(`/api/ideas/${idea.id}/save-as-line-manager`, { comment }).then( (data) => {

      })
    }
  }
};
</script>