<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div class="py-12">
      <div class="container d-flex flex-column justify-content-center" style="height: 30vh">
        <div class="d-flex flex-row align-items-center justify-content-center gap-4">
          <img
            class="img-fluid banner-logo"
            src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/National_Economic_and_Development_Authority_%28NEDA%29.svg/1200px-National_Economic_and_Development_Authority_%28NEDA%29.svg.png"
            alt=""
          />
          <div>
            <h1>Welcome to NRO2-HRIS</h1>
            <p>Human Resource Information System</p>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
