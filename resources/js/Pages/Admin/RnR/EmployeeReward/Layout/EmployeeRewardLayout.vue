

<template>
  <AdminLayout>
    <Head title="Register" />
    <div class="container">
      <h3>{{ reward.title }} Awardees</h3>
      <BreadCrumbs :crumbs="crumbs" />
      <!-- Nav tabs -->
      <ul id="myTab" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
          <Link
            class="nav-link"
            :class="{'active': route().current('admin.employees.rewards.create')}"
            :href="route('admin.employees.rewards.create', {reward: reward.id})"
          >
            All
          </Link>
        </li>
        <li class="nav-item" role="presentation">
          <Link
            :href="route('admin.employees.rewards.rank_by_ipcr', {reward: reward.id})"
            class="nav-link"
            :class="{'active': route().current('admin.employees.rewards.rank_by_ipcr')}"
          >
            PERFORMANCE RANKING
          </Link>
        </li>
      </ul>
      <slot />
    </div>
  </AdminLayout>
</template>
      
<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { computed } from 'vue'
    
const props = defineProps({
  reward: Object,
})


const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Rewards and Recognition',
    link: route('admin.rewards.index'),
  },
  {
    label: props.reward.title,
    link: route('admin.rewards.show', {reward: props.reward.id}),
  },
  {
    label: 'Add Awardees',
  },
])
    
</script>
      