<template>
  <Head :title="` | ${$page.component}`" />
  <meta head-key="description" name="description" content="This is teh description for Homepage" />
  <Layout>
    <div>
      <div class="flex justify-end mb-4">
        <div class="w-1/4">
          <input type="search" placeholder="Search" v-model="search">
        </div>
      </div>
      {{ can }}
      <table>
        <thead>
          <tr class="bg-slate-300">
            <th>Avatar</th>
            <th>Name</th>
            <th>email</th>
            <th>Registration date</th>
            <th v-if="can.delete_user">delete</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users.data" :key="user.id">
            <td>
              <img :src="user.avatar ? ('storage/' + user.avatar) : ('storage/avatars/default.jpg')" alt="Avatar" class="avatar">
            </td>
            <td>
              {{ user.name }}
            </td>
            <td>
              {{ user.email }}    
            </td>
            <td>
              {{ getDate(user.created_at) }}
            </td>
            <td v-if="can.delete_user"><button class="bg-red-500 w-6 h-6 rounded-full"></button></td>
          </tr>
        </tbody>
      </table>

      <!-- pagination links -->
      <div>
        <PaginationLinks :paginator="users" />
      </div>
    </div>
  </Layout>
</template>

<script setup lang="ts">
import PaginationLinks from "../Components/PaginationLinks.vue"
import { ref, watch } from 'vue'
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";
// import Custom from "../Layouts/Custom.vue"

// defineOptions({
//   layout: Custom
// })
const props = defineProps({
  users: Object,
  searchTerm: String,
  can: Object,
})
const search = ref(props.searchTerm);

watch(search, debounce(
  (q) => router.get('/', {search: q}, {preserveState: true}),
  500
))
// format date
const getDate = (date)  => 
  new Date(date).toLocaleDateString("en-us", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });

</script>

<style scoped>

</style>