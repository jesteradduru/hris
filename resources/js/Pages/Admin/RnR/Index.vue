<template>
  <Head title="Job Vacancies" />
      
  <AdminLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>Rewards and Recognition</h3>
    <Link class="btn  btn-primary" :href="route('admin.rewards.create')">Create Reward/Recognition</Link>
  
    <div class="table-responsive">
      <table class="table table-compact">
        <thead>
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Points</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in props.rewards.data" :key="item.id" class="">
            <td scope="row">{{ item.title }}</td>
            <td>{{ item.points }}</td>
            <td class="d-flex gap-2">
              <Link class="btn btn-success btn-sm" :href="route('admin.rewards.edit', {reward: item.id})">
                <i class="fa-solid fa-pencil" />
              </Link>
              <Link class="btn btn-danger btn-sm" :onBefore="confirm" method="delete" as="button" :href="route('admin.rewards.destroy', {reward: item.id})">
                <i class="fa-solid fa-trash" />
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="props.rewards.length === 0" class="text-center text-muted">No Records</div>
      <Pagination v-if="props.rewards.length > 15" :links="props.rewards.links" />
    </div>
  </AdminLayout>
</template>
      
<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue'
import Filter from '@/Pages/Admin//Recruitment/JobPosting/Components/Filter.vue'
  
const props = defineProps({
  rewards: Object,
})
const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Rewards and Recognition',
  },
])
      

const confirm = () => {
  return window.confirm('Are you sure to delete this reward?')
}
</script>
      