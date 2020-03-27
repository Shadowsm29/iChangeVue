<template>
  <div class="unauthorized">
    <div class="message">
      <h1>403</h1>
      <h5>Unauthorized</h5>
      <p>This resource is not allowed for you!</p>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
.unauthorized {
  height: 85vh;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  /* flex-direction: column; */
}

.message {
    border: 1px solid #CCC;
    border-radius: 8px;
    padding: 50px;
    box-shadow: 0 0 10px 5px #AAA;
}
</style>