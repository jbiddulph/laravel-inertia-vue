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
              {{ user.created_at }}
            </td>
          </tr>
        </tbody>
      </table>

      <!-- pagination links -->
      <div>

      </div>
    </div>
  </Layout>
</template>

<script setup lang="ts">
// import Custom from "../Layouts/Custom.vue"

// defineOptions({
//   layout: Custom
// })
defineProps({
  users: Object
})
</script>

<style scoped>

</style>