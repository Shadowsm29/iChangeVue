<script>
export default {
  methods: {
    handleErrorResponse(err, next) {
      console.log("handleErrorResponse -> err", err.response)
      if (err.response.status && err.response.status === 422) {
        this.$store.commit("messages/addValidationError", err.response);
      } else if (
        err.response.status &&
        (err.response.status === 401 || err.response.status === 403)
      ) {
        this.$router.push({ name: "unauthorized" });
      } else {
        console.log(err.response);
        alert("Something went wrong. Please try again.");
      }
    },

    handleSuccessResponse(message) {
      this.$store.commit("messages/addSuccessMessage", message);
    }
  }
};
</script>