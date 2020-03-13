<script>
import store from "../store/index";

export default {
  data() {
    return {
      DISPLAY_BACKEND: "display backend",
      DISPLAY_CIRCLES: "display circles",
      DISPLAY_SUPER_CIRCLES: "display supercircles",
      DISPLAY_JUSTIFICATIONS: "display justifications",
      EDIT_CIRCLES: "edit circles",
      EDIT_SUPER_CIRCLES: "edit supercircles",
      EDIT_JUSTIFICATIONS: "edit justifications",
      CREATE_CIRCLES: "create circles",
      CREATE_SUPER_CIRCLES: "create supercircles",
      CREATE_JUSTIFICATIONS: "create justifications",
      DELETE_CIRCLES: "delete circles",
      DELETE_SUPER_CIRCLES: "delete supercircles",
      DELETE_JUSTIFICATIONS: "delete justifications"
    };
  },
  methods: {
    $can(permissionToCheck) {
      const permissions = store.getters["auth/permissions"];

      if (Array.isArray(permissionToCheck)) {
        for(let i = 0; i<permissionToCheck.length; i++) {
          if(permissions.some(p => p.name == permissionToCheck[i])) return true;
        }
        return false;
      } else {
        if (permissions) {
          return permissions.some(p => p.name == permissionToCheck);
        } else return false;
      }
    }
  }
};
</script>