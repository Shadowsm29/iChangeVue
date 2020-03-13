<template>
  <div class="row">
    <div class="col-md-3">
      <ul class="list-group">
        <router-link
          v-if="$can(DISPLAY_CIRCLES)"
          class="list-group-item pointer"
          tag="li"
          :to="{ name: 'backend.circles' }"
          active-class="active ing-btn"
        >Circles</router-link>
        <router-link
          v-if="$can(DISPLAY_SUPER_CIRCLES)"
          class="list-group-item pointer"
          tag="li"
          :to="{ name: 'backend.super-circles' }"
          active-class="active ing-btn"
        >Super Circles</router-link>
        <router-link
          v-if="$can(DISPLAY_JUSTIFICATIONS)"
          class="list-group-item pointer"
          tag="li"
          :to="{ name: 'backend.justifications' }"
          active-class="active ing-btn"
        >Justification</router-link>
      </ul>
    </div>
    <div class="col-md-9">
      <transition name="sub-page" mode="out-in">
        <router-view class="router" />
      </transition>
    </div>
  </div>
</template>

<script>
import store from "~/store/index";
import * as handler from "../../plugins/response-handler";

export default {
  beforeRouteEnter(to, from, next) {
    store.dispatch("backend-mgmt/fetchAll").then(
      () => {
        next();
      },
      error => {
        handler.handleErrorResponse(error, next);
      }
    );
  }
};
</script>
