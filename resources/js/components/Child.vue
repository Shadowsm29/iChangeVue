<template>
  <transition name="page" mode="out-in">
    <slot>
      <router-view :key="$route.fullPath" />
    </slot>
  </transition>
</template>

<script>
export default {
  name: 'Child'
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>