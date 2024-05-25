<template>
  <Head title=" | About" />
  <div>
    <h1>About {{ user }}</h1>
  </div>
</template>

<script setup lang="ts">
defineProps({
  user: String
})
</script>

<style scoped>

</style>