<template>
  <AdminLayout fluid>
    <slot name="header" />
    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
      <div>
        <h3 class="fw-bold mb-0 text-dark">
          <i class="fa-solid fa-users-gear text-primary me-2" />Recruitment, Selection and Placement
        </h3>
        <small class="text-muted">Manage plantilla positions, job postings, and applicant selection workflows</small>
      </div>
    </div>
    
    <div class="nav-wrapper mb-4">
      <ul class="nav nav-pills gap-2 bg-light p-2 rounded-3 border">
        <li class="nav-item">
          <Link
            class="nav-link fw-semibold px-3 py-2 rounded-2"
            :class="{
              'active bg-primary text-white shadow-sm': route().current(
                'admin.recruitment.plantilla.*'
              ),
              'text-secondary hover-bg-white': !route().current('admin.recruitment.plantilla.*')
            }"
            :href="route('admin.recruitment.plantilla.index')"
          >
            <i class="fa-solid fa-sitemap me-2" />Plantilla Positions
          </Link>
        </li>
        
        <li class="nav-item">
          <Link
            class="nav-link fw-semibold px-3 py-2 rounded-2"
            :class="{
              'active bg-primary text-white shadow-sm': route().current('admin.recruitment.job_posting.*'),
              'text-secondary hover-bg-white': !route().current('admin.recruitment.job_posting.*')
            }"
            :href="route('admin.recruitment.job_posting.index')"
          >
            <i class="fa-solid fa-briefcase me-2" />Job Vacancies
          </Link>
        </li>
        <li class="nav-item">
          <Link
            class="nav-link fw-semibold px-3 py-2 rounded-2"
            :class="{
              'active bg-primary text-white shadow-sm': route().current(
                'admin.recruitment.selection.*'
              ),
              'text-secondary hover-bg-white': !route().current('admin.recruitment.selection.*')
            }"
            :href="route('admin.recruitment.selection.index')"
          >
            <i class="fa-solid fa-user-check me-2" />Selection and Placement
          </Link>
        </li>
      </ul>
    </div>
    <div class="mt-3">
      <slot />
    </div>
  </AdminLayout>
</template>
  
<script setup>
import { Link } from '@inertiajs/vue3'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
</script>
  