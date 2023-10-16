<template>
  <AdminLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <div class="tabbable">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <Link
            preserve-state :href="route('admin.employees.edit', {employee: props.employee})" class="nav-link"
            :class="{ active: route().current('admin.employees.edit') } "
          >
            Account Settings
          </Link>
        </li>
  
  
        <li class="nav-item">
          <Link
            preserve-state :href="route('admin.employees.rewards.edit', {employee: props.employee})" class="nav-link"
            :class="{ active: route().current('admin.employees.rewards.*') }"
          >
            Rewards and Recognition
          </Link>
        </li>
      </ul>
      <br />
      <div class="container">
        <slot />
      </div>
    </div>
  </AdminLayout>
</template>
  
<script setup>
import { Link } from '@inertiajs/vue3'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import { computed } from 'vue'
import BreadCrumbs from '@/Components/BreadCrumbs.vue'

  
const props = defineProps({
  isFormDirty: Boolean,
  employee: Number,
})

const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Employees',
    link: route('admin.employees.index'),
  },
  {
    label: 'Edit',
  },
])
  
</script>
  