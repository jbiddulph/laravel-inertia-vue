<template>
  <div class="w-1/4 flex mx-auto flex-col">
    <h1>Create Customer</h1>
    <form @submit.prevent=submit>
      <TextInput name="Name" v-model="form.name" :message="form.errors.name" />
      <TextInput name="Email" type="email" v-model="form.email" :message="form.errors.email" />
      <TextInput name="Phone" v-model="form.phone" :message="form.errors.phone" />
      <div>
        <button class="primary-btn" :disabled="form.processing">Create</button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import TextInput from '../../Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  name: null,
  email: null,
  phone: null,
})

const submit = () => {
  form.post(route('customerCreate'));
}
</script>

<style scoped>

</style>