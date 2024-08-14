<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import logo from '@/Assets/Logo.jpg'
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div class="container-fluid" style="height: 30vh">
      <div class="col d-flex justify-content-center align-items-center">
        <img :src="logo" class="w-50 rounded-circle border" alt="" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>

