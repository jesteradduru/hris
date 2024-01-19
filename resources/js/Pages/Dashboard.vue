<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import logo from '@/Assets/Logo.jpg'
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div class="py-12">
      <div class="container-fluid d-flex flex-column justify-content-center" style="height: 30vh">
        <div class="mt-4 p-5 bg-secondary text-white rounded">
          <div class="jumbotron">
            <h1>Welcome to NRO2 HRIS</h1>
            <p>Human Resource Information System</p>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

