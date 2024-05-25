<template>
  <Head :title="` | ${$page.component}`" />
  <meta head-key="description" name="description" content="This is teh description for Homepage" />
  <Layout>
    <div>
      <table>
        <thead>
          <tr class="bg-slate-300">
            <th>Avatar</th>
            <th>Name</th>
            <th>email</th>
            <th>Registration date</th>
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
// import Custom from "../Layouts/Custom.vue"

// defineOptions({
//   layout: Custom
// })
defineProps({
  users: Object
})

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