<template>
  <div class="search">
    <input type="text" class="input form-control" placeholder="Search" v-model="text" />
  </div>
</template>

<script>
export default {
  props: ["array"],
  data() {
    return {
      text: ""
    };
  },
  watch: {
    text() {
      const filteredArr = this.array.filter(element => {
        
      });

      this.$emit("filtered", filteredArr);
    }
  }
};
</script>

<style scoped>
.search {
  display: flex;
  justify-content: flex-end;
  margin: 10px;
  margin-right: 0;
}

.input {
  width: 200px;
}
</style>