<template>
  <div class="container-fluid">
    <div v-if="loadingData" class="mt-5 d-flex justify-content-center">
      <spinner-app colorClass="ing-text" />
    </div>
    <div v-else>
      <table class="table">
        <thead>
          <th>Req. Number</th>
          <th>Title</th>
          <th>Change Type</th>
          <th>Justification</th>
          <th>Circle</th>
          <th>Supercircle</th>
          <th>Expected Benefit</th>
          <th>SME</th>
          <th>Status</th>
          <th>Pending At</th>
          <th>Actions</th>
        </thead>
        <tbody>
          <tr v-for="idea in ideas" :key="idea.id">
            <td>{{idea.request_number}}</td>
            <td>{{idea.title}}</td>
            <td>{{idea.change_type.name}}</td>
            <td>{{idea.justification.name}}</td>
            <td>{{idea.circle.name}}</td>
            <td>{{idea.super_circle.name}}</td>
            <td>{{idea.expected_benefit}} hours/week</td>
            <td>{{idea.sme.name}}</td>
            <td>{{idea.status.title}}</td>
            <td>{{idea.pending_at.name}}</td>
            <td>
              <button class="btn ing-btn btn-sm" @click="openIdea(idea.id)">Open</button>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="ideas.length == 0" class="d-flex justify-content-center mt-3">
        <h4>There are no items in this list</h4>
      </div>
    </div>
  </div>
</template>

<script>
import Spinner from "../../components/Spinner";

export default {
  components: {
    SpinnerApp: Spinner
  },

  data() {
    return {
      loadingData: true,
      ideas: []
    };
  },

  created() {
    let url = "";

    if(this.$route.name === "ideas.all") {
      url = "/api/ideas";
    } else if(this.$route.name === "ideas.my-ideas") {
      url = "/api/ideas/my-ideas";
    } else if(this.$route.name === "ideas.pending-at-me") {
      url = "/api/ideas/pending-at-me";
    }
    
    this.$http
      .get(url)
      .then(({ data }) => {
        this.ideas = data;
        console.log("created -> this.ideas", this.ideas)
        console.log(this.ideas.length);
        
        this.loadingData = false;
      })
      .catch(err => {
        this.handleErrorResponse(err);
      });
  },

  methods: {
    openIdea(id) {
      this.$router.push({
        name: "ideas.display",
        params: { id: id }
      });
    }
  }
};
</script>

<style scoped>
.container {
    max-width: unset !important;  
    width: 90% !important;
}
</style>