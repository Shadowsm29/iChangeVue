<template>
  <div>
    <div class="row">
      <div class="col-md-3">
        <ul class="list-group">
          <router-link
            tag="li"
            class="list-group-item"
            active-class="active ing-btn"
            style="cursor:pointer"
            :to="{ name: 'iam.users' }"
          >User List</router-link>
          <router-link
            tag="li"
            class="list-group-item"
            active-class="active ing-btn"
            style="cursor:pointer"
            :to="{ name: 'iam.roles' }"
          >Roles</router-link>
        </ul>
      </div>
      <div class="col-md-9">
        <transition name="sub-page" mode="out-in">
          <router-view></router-view>
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
export default {

};
</script>