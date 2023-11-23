<template>
  <Head title="Rewards and Recognition" />
        
  <AdminLayout>
    <h3>{{ reward.title }} Awardees</h3>
    <BreadCrumbs :crumbs="crumbs" />
    <Link class="btn  btn-primary" :href="route('admin.employees.rewards.create', {reward: reward.id})">Add Awardee</Link>
    <div class="table-responsive">
      <table class="table table-sm table-bordered mt-4">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Points</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in props.reward.employee" :key="item.id" class="">
            <td>{{ item.employee.name }}</td>
            <td>{{ moment(item.employee.created_at).format('MMM D, Y') }}</td>
            
            <td class="d-flex gap-2">
              <Link class="btn btn-danger btn-sm" method="delete" as="button" :href="route('admin.employees.rewards.destroy', {reward: item.id})" :onBefore="confirm">
                <i class="fa-solid fa-trash" />
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- <div v-if="props.rewards.length === 0" class="text-center text-muted">No Records</div>
      <Pagination v-if="props.rewards.length > 15" :links="props.rewards.links" /> -->
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
  },
])
        
  
const confirm = () => {
  return window.confirm('Are you sure to remove this employee?')
}
</script>
        