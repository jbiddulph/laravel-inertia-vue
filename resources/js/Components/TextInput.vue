<template>
  <div class="mb-6">
    <label>{{ name }}</label>
    <input :type="type" v-model="model" :class="{'!ring-red-600' : message}">
    <small class="error" v-if="message">{{ message }}</small>
  </div>
</template>

<script setup lang="ts">
const model = defineModel({
  type: null,
  required: true
})
defineProps({
  name: {
    type: String,
    required: true
  },
  type: {
    type: String,
    default: "text",
  },
  message: String

})
</script>

<style scoped>

</style>