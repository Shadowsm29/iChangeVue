<template>
  <div :class="columnClass">
    <div class="form-group">
      <label :for="id">{{ label }}:</label>
      <input
        class="form-control"
        :type="type"
        :id="id"
        :placeholder="placeholder"
        :value="value"
        @input="input($event.target.value)"
        :disabled="disabled"
      />
    </div>
  </div>
  <!-- <p>test</p> -->
</template>

<script>
export default {
  props: {
    label: {
      default: "name"
    },
    type: {
      default: "text"
    },
    placeholder: {
      default: ""
    },
    columnClass: {
      default: "col-md-6"
    },
    value: {
      required: true
    },
    disabled: {
      default: false
    }
  },

  data() {
    return {
      id: Math.random().toString(36),
    };
  },

  methods: {
    input(value) {
      this.$emit("input", value);
    }
  }
};
</script>