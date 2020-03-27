<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">{{ appName }}</router-link>

      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarToggler"
        aria-controls="navbarToggler"
        aria-expanded="false"
      >
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">
        <ul class="navbar-nav">
          <locale-dropdown />
          <!-- <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>-->
        </ul>

        <ul class="navbar-nav mr-auto">
          <!-- Ideas -->
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >Ideas</a>
            <div class="dropdown-menu">
              <router-link
                tag="li"
                class="nav-item"
                active-class="active ing-text"
                :to="{name: 'ideas.create'}"
              >
                <a class="nav-link">Register Idea</a>
              </router-link>
              <router-link
                tag="li"
                class="nav-item"
                active-class="active ing-text"
                :to="{name: 'ideas.all'}"
              >
                <a class="nav-link">All ideas</a>
              </router-link>
              <router-link
                tag="li"
                class="nav-item"
                active-class="active ing-text"
                :to="{name: 'ideas.my-ideas'}"
              >
                <a class="nav-link">My ideas</a>
              </router-link>
              <router-link
                tag="li"
                class="nav-item"
                active-class="active ing-text"
                :to="{name: 'ideas.pending-at-me'}"
              >
                <a class="nav-link">Ideas pending at me</a>
              </router-link>
            </div>
          </li>
          <!-- IAM -->
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >IAM</a>
            <div class="dropdown-menu">
              <router-link
                tag="li"
                class="nav-item"
                active-class="active ing-text"
                :to="{name: 'iam.users'}"
              >
                <a class="nav-link">Users</a>
              </router-link>
              <router-link
                tag="li"
                class="nav-item"
                active-class="active ing-text"
                :to="{name: 'iam.roles'}"
              >
                <a class="nav-link">Roles</a>
              </router-link>
            </div>
          </li>
          <!-- Backend MGMT -->
          <li class="nav-item dropdown" v-if="$can(DISPLAY_BACKEND)">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >Backend MGMT</a>
            <div class="dropdown-menu">
              <router-link
                v-if="$can(DISPLAY_CIRCLES)"
                tag="li"
                class="nav-item"
                active-class="active ing-text"
                :to="{name: 'backend.circles'}"
              >
                <a class="nav-link">Circles</a>
              </router-link>
              <router-link
                v-if="$can(DISPLAY_SUPER_CIRCLES)"
                tag="li"
                class="nav-item"
                active-class="active ing-text"
                :to="{name: 'backend.super-circles'}"
              >
                <a class="nav-link">Super Circles</a>
              </router-link>
              <router-link
                v-if="$can(DISPLAY_JUSTIFICATIONS)"
                tag="li"
                class="nav-item"
                active-class="active ing-text"
                :to="{name: 'backend.justifications'}"
              >
                <a class="nav-link">Justifications</a>
              </router-link>
            </div>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <!-- Authenticated -->
          <li v-if="user" class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle text-dark"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <!-- <img :src="user.photo_url" class="rounded-circle profile-photo mr-1" /> -->
              {{ user.name }}
            </a>
            <div class="dropdown-menu">
              <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
                <fa icon="cog" fixed-width />
                {{ $t('settings') }}
              </router-link>

              <div class="dropdown-divider" />
              <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width />
                {{ $t('logout') }}
              </a>
            </div>
          </li>
          <!-- Guest -->
          <template v-else>
            <li class="nav-item">
              <router-link
                :to="{ name: 'login' }"
                class="nav-link"
                active-class="active"
              >{{ $t('login') }}</router-link>
            </li>
            <li class="nav-item">
              <router-link
                :to="{ name: 'register' }"
                class="nav-link"
                active-class="active"
              >{{ $t('register') }}</router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from "vuex";
import LocaleDropdown from "./LocaleDropdown";
import * as Perm from "../plugins/permission-checker";

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName
  }),

  computed: {
    ...mapGetters({
      user: "auth/user"
    })
  },

  methods: {
    async logout() {
      // Log out the user.
      await this.$store.dispatch("auth/logout");

      // Redirect to login.
      this.$router.push({ name: "login" });
    }
  },
};
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -0.375rem 0;
}
</style>
