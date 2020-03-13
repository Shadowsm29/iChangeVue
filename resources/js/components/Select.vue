<template>
  <div :class="columnClass">
    <div class="form-group">
      <label for="name">{{ label }}:</label>
      <select class="form-control" id="name" @change="change($event.target.value)" :value="value" :multiple="multiple" :disabled="disabled">
        <option v-for="o in options" :key="o[valueKey]" :value="o[valueKey]">{{ o[textKey] }}</option>
      </select>
      <!-- <p>{{value}}</p> -->
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
    options: {
      required: true,
      type: Array
    },
    columnClass: {
      default: "col-md-6"
    },
    value: {
      required: true
    },
    valueKey: {
        default: "id"
    },
    textKey: {
        default: "name"
    },
    multiple: {
      default: false
    },
    disabled: {
      default: false
    }
  },

  methods: {
    change(value) {
      this.$emit("input", value);
    }
  }
};
</script>