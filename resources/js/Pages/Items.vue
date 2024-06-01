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
            <th>Pic</th>
            <th>Name</th>
            <th>Description</th>
            <th>Date</th>
            <th v-if="can.delete_user">Delete</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in items.data" :key="index">
            <td>
              <img :src="item.item_pic ? ('storage/' + item.item_pic) : ('storage/avatars/default.jpg')" alt="Avatar" class="avatar">
            </td>
            <td>
              {{ item.item_name }}
            </td>
            <td>
              {{ item.item_description }}    
            </td>
            <td>
              {{ getDate(item.created_at) }}
            </td>
            <td v-if="can.delete_user">
              <button class="bg-red-500 w-6 h-6 rounded-full"></button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- pagination links -->
      <div>
        <PaginationLinks :paginator="items" />
      </div>
    </div>
  </Layout>
</template>

<script setup lang="ts">
import PaginationLinks from "../Components/PaginationLinks.vue";
import { ref, watch } from 'vue';
import { router } from "@inertiajs/vue3";
import { debounce } from "lodash";

const props = defineProps({
  items: Object,
  searchTerm: String,
  can: Object,
});
const search = ref(props.searchTerm);

watch(search, debounce(
  (q) => router.get('/map', {search: q}, {preserveState: true}),
  500
));

// format date
const getDate = (date: string) => 
  new Date(date).toLocaleDateString("en-us", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
</script>

<style scoped>

</style>