<template>
  <AdminLayout>
    <slot name="header" />
    <h3>Learning and Development</h3>
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <Link
          class="nav-link"
          :class="{
            active: route().current('admin.competency_gap.*') || route().current('admin.competency_training.*')
          }"
          :href="route('admin.competency_gap.index')"
        >
          Competency Gap Assessment
        </Link>
      </li>
      <li class="nav-item">
        <Link
          class="nav-link"
          :class="{
            active: route().current(
              'admin.idp.*'
            )
          }"
          :href="route('admin.idp.index')"
        >
          Individual Development Plan
        </Link>
      </li>
    </ul>
    <div class="mt-3 container">
      <slot />
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'

const props = defineProps({
  fluid: Boolean,
})

</script>
