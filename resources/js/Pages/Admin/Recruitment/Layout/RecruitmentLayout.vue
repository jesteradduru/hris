<template>
  <AdminLayout>
    <slot name="header" />
    <h3>Recruiment, Selection and Placement</h3>
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <Link
          class="nav-link"
          :class="{
            active: route().current(
              'admin.recruitment.plantilla.*'
            )
          }"
          :href="route('admin.recruitment.plantilla.index')"
        >
          Plantilla Positions
        </Link>
      </li>
      <li class="nav-item">
        <Link
          class="nav-link"
          :class="{
            active: route().current('admin.recruitment.job_posting.*')
          }"
          :href="route('admin.recruitment.job_posting.index')"
        >
          Job Vacancies
        </Link>
      </li>
      <li class="nav-item">
        <Link
          class="nav-link"
          :class="{
            active: route().current(
              'admin.recruitment.selection.*'
            )
          }"
          :href="route('admin.recruitment.selection.index')"
        >
          Selection and Placement
        </Link>
      </li>
    </ul>
    <div class="mt-3">
      <slot />
    </div>
  </AdminLayout>
</template>
  
<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import { computed } from 'vue'
</script>
  