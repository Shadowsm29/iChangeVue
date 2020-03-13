<template>
  <div class="d-inline-flex justify-content-center">
    <div class="spinner-border" :class="[{ 'spinner-border-sm': small }, colorClass]" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    small: {
      required: false,
      type: Boolean,
      default: false,
    },
    colorClass: {
      required: false,
      type: String,
      default: () => "",
    }
  },
  data() {
    return {
      isColorSet: null,
    };
  },
  mounted() {
    if(this.colorClass) {
      this.isColorSet = true;
    } else {
     this. isColorSet = false;
    }
  }
};
</script>