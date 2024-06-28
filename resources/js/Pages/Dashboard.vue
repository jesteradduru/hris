<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import logo from '@/Assets/Logo.jpg'
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div class="container-fluid bg-dashboard" style="height: 30vh">
      <div class="p-5 text-dark text-center">
        <div>
          <h1 class="display-4">Welcome to NRO2 HRIS</h1>
          <p class="lead display-6">Human Resource Information System</p>
          <div v-if="!$page.props.auth.user" class="d-flex gap-2 justify-content-center mt-5">
            <Link :href="route('login')" class="btn btn-lg btn-primary">Sign-In</Link>
            <Link :href="route('register')" class="btn btn-lg btn-dark">Register</Link>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

