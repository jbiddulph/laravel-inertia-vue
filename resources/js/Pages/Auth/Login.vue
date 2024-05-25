<template>
  <Head title="Login" />
  <h1 class="title">Login to your account</h1>
  <div class="w-1/4 mx-auto bg-slate-100 p-3 rounded-lg">
    <form @submit.prevent=submit>
      <TextInput name="Email" type="email" v-model="form.email" :message="form.errors.email" />
      <TextInput name="Password" type="password" v-model="form.password" :message="form.errors.password" />
      <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-2">
          <label for="remember">Remember me</label>
          <input type="checkbox" v-model="form.remember" id="remember">
        </div>
        <p class="text-slate-600 text-xs">Need an account? <a :href="route('register')">Register</a></p>
      </div>
      <div>
        <button class="primary-btn" :disabled="form.processing">Login</button>
      </div>
    </form>
  </div>
</template>
<script setup lang="ts">
import TextInput from '../../Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  email: null,
  password: null,
  remember: null,
})

const submit = () => {
  form.post(route('login'), {
    onError: () => {
      form.reset('password', 'remember')
    }
  });
}

</script>

<style scoped>

</style>