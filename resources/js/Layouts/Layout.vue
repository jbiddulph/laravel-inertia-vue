<template>
  <div>
    <header>
      <nav>
        <div class="space-x-6">
          <Link :href="route('home')" class="nav-link" :class="{'bg-slate-700': $page.component === 'Home'}">Users</Link>
          <Link :href="route('items')" class="nav-link" :class="{'bg-slate-700': $page.component === 'Items'}">Items</Link>
        </div>
        <div v-if="$page.props.auth.user" class="space-x-6 flex">
          <img class="avatar" :src="$page.props.auth.user.avatar ? ('/storage/' + $page.props.auth.user.avatar) : ('/torage/avatars/default.jpg')" alt="">
          <Link :href="route('itemCreate')" class="nav-link" :class="{'bg-slate-700': $page.component === 'Items/Create'}">Create item</Link>
          <Link :href="route('customerCreate')" class="nav-link" :class="{'bg-slate-700': $page.component === 'Customers/Create'}">Create customer</Link>
          <Link :href="route('dashboard')" class="nav-link" :class="{'bg-slate-700': $page.component === 'Dashboard'}">Dashboard</Link>
          <Link :href="route('logout')" method="post" as="button" type="button" class="nav-link">Logout</Link>
        </div>
        <div v-else class="space-x-6">
          <Link :href="route('register')" class="nav-link" :class="{'bg-slate-700': $page.component === 'Auth/Register'}">Register</Link>
          <Link :href="route('login')" class="nav-link" :class="{'bg-slate-700': $page.component === 'Auth/Login'}">Login</Link>
        </div>
      </nav>
    </header>
    <main class="container mx-auto mt-8">
      <slot />
    </main>
  </div>
</template>

<script setup lang="ts">

</script>

<style scoped>

</style>