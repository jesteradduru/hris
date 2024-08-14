<template>
  <Head title="Job Vacancies" />
    
  <AdminLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>Accounts</h3>
    <Link :href="route('admin.employees.employee.create')" class="btn btn-primary">Create Account</Link>
    <div class="row mt-3">
      <div class="col-4">
        <input
          id=""
          v-model="filterForm.name"
          type="text" class="form-control form-control-sm" name="" aria-describedby="helpId" placeholder="Search Name"
        />
      </div>
      <div class="col-4">
        <div class="d-flex gap-2">
          <label for="" class="form-label">Division</label>
          <select id="division" v-model="filterForm.division" class="form-select form-select-sm" name="">
            <option value="" selected>All</option>
            <option v-for="division in divisions" :key="division.id" :value="division.id">
              {{ 
                division.name }}
            </option>
          </select>
        </div>
      </div>
      <div class="col-1 d-flex gap-2">
        <button class="btn btn-dark btn-sm" @click="onFilter">Filter</button>
        <button class="btn btn-secondary btn-sm" @click="onReset">Reset</button>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-sm table-bordered mt-4">
        <thead>
          <tr>
            <th scope="col">Picture</th>
            <th scope="col">Username</th>
            <th scope="col">Name</th>
            <th scope="col">Position</th>
            <th scope="col">DTR ID</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="employee in props.employees.data" :key="employee.id" class="">
            <td scope="row">
              <img v-if="employee.profile_pic" class="profile-pic-nav rounded-circle shadow me-2" :src="employee.profile_pic" alt="" />
              <img v-else class="profile-pic-nav rounded-circle  me-2" src="../../../Assets/profile.png" alt="" />
            </td>
            <td>{{ employee.username }}</td>
            <td>{{ employee.name }}</td>
            <td>{{ employee.position?.position }}</td>
            <td>{{ employee.dtr_user_id }}</td>
            <td class="d-flex gap-2">
              <Link :href="route('admin.employees.employee.edit', {employee: employee.id})" class="btn btn-success btn-sm"><i class="fa-solid fa-pencil" /></Link>
              <Link :onBefore="confirm" method="delete" as="button" :href="route('admin.employees.employee.destroy', {employee: employee.id})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash" /></Link>
            </td>
          </tr>
        </tbody>
      </table>
      <Pagination v-if="props.employees.data.length === 15" :links="props.employees.links" />
    </div>
  </AdminLayout>
</template>
    
<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  employees: Object,
  divisions: Array,
})

const filterForm = useForm({
  name: '',
  division: '',
})

const onFilter = () => {
  filterForm.get(route('admin.employees.employee.index'), {
    preserveScroll: true,
    preserveState: true,
  })
}

const onReset = () => {
  filterForm.name = ''
  filterForm.division = ''
  filterForm.get(route('admin.employees.employee.index'), {
    preserveScroll: true,
    preserveState: true,
  })
}

const confirm = () => window.confirm('Delete this user?')

const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Accounts',
  },
])
    
</script>
    