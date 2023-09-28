<template>
  <Head title="Job Vacancies" />
    
  <AdminLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>Employees</h3>
    <Link :href="route('admin.employees.create')" class="btn btn-primary">Create Account</Link>

    <div class="table-responsive">
      <table class="table table-compact">
        <thead>
          <tr>
            <th scope="col">Username</th>
            <th scope="col">Name</th>
            <th scope="col">DTR ID</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="employee in props.employees.data" :key="employee.id" class="">
            <td scope="row">{{ employee.username }}</td>
            <td>{{ employee.name }}</td>
            <td>{{ employee.dtr_user_id }}</td>
            <td class="d-flex gap-2">
              <Link :href="route('admin.employees.edit', {employee: employee.id})" class="btn btn-success btn-sm"><i class="fa-solid fa-pencil" /></Link>
              <Link class="btn btn-danger btn-sm"><i class="fa-solid fa-trash" /></Link>
            </td>
          </tr>
        </tbody>
      </table>
      <Pagination v-if="props.employees.length > 15" :links="props.employees.links" />
    </div>
  </AdminLayout>
</template>
    
<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue'
import Filter from '@/Pages/Admin//Recruitment/JobPosting/Components/Filter.vue'

const props = defineProps({
  employees: Object,
})
const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Employees',
  },
])
    
</script>
    