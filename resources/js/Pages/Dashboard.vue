<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import logo from '@/Assets/Logo.jpg'
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div class="container-fluid mt-3" style="height: 30vh">
      <div class="p-5 bg-secondary text-white rounded">
        <div class="jumbotron">
          <h1>Welcome to NRO2 HRIS</h1>
          <p>Human Resource Information System</p>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

