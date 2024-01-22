<template>
  <Head title="Admin Panel" />
  <AdminLayout>
    <div class="container-fluid mt-3" style="height: 30vh">
      <div class="p-5 bg-secondary text-white rounded">
        <div class="jumbotron">
          <h1>Welcome to Admin Dashboard</h1>
          <p>Human Resource Information System</p>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import AdminLayout from './Layout/AdminLayout.vue'
</script>
