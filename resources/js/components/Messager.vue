<template>
  <div class="messager">
    <transition-group name="fade">
      <span
        v-for="message in activeMessages"
        :key="message.id"
        class="list-group-item"
        :class="{ 'error': message.type === 'error', 'success': message.type === 'success'}"
      >{{ message.text }}</span>
    </transition-group>
  </div>
</template>

<script>
export default {
  data() {
    return {
      activeMessages: []
    };
  },
  computed: {
    messages() {
      return this.$store.getters["messages/messages"];
    }
  },
  watch: {
    messages() {
      this.messages.forEach(message => {
        if (message.status === "new") {
          message.status = "old";

          this.activeMessages.splice(this.messages.length, 0, message);
          var activeMessage = this.activeMessages[
            this.activeMessages.length - 1
          ];

          const timeout = setTimeout(() => {
            this.activeMessages.splice(
              this.activeMessages.indexOf(activeMessage),
              1
            );
          }, 5000);
        }
      });
    }
  }
};
</script>

<style scoped>
.messager {
  display: block;
  position: fixed;
  z-index: 1000;
  right: 1%;
  top: 10%;
}

.list-group-item {
  margin: 5px 0;
  width: 250px;
  box-shadow: 0 0 4px 3px #fff;
}

.error {
  color: #721c24 !important;
  background-color: #f8d7da !important;
  border-color: #f5c6cb !important;
}

.success {
  color: #155724;
  background-color: #d4edda;
  border-color: #c3e6cb;
}

.fade-enter-active {
  animation: fadeIn 1s ease-in-out;
}

.fade-leave-active {
  animation: fadeOut 1s ease-in-out;
  position: absolute;
}

.fade-move {
  transition: transform 1s;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    /* transform: translateX(50px); */
  }
  to {
    opacity: 1;
    /* transform: translateX(0); */
  }
}

@keyframes fadeOut {
  from {
    opacity: 1;
    /* transform: translateX(0); */
  }
  to {
    opacity: 0;
    /* transform: translateX(50px); */
  }
}
</style>