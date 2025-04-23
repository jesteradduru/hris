<template>
  <Head title="Divisions" />
      
  <AdminLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>Divisions</h3>
    <button data-bs-toggle="modal" data-bs-target="#create" class="btn btn-primary">Create Division</button>
    <div class="row mt-3">
      <!-- <div class="col-4">
        <input
          id=""
          v-model="filterForm.name"
          type="text" class="form-control form-control-sm" name="" aria-describedby="helpId" placeholder="Search Name"
        />
      </div> -->
      <!-- <div class="col-4">
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
      </div> -->
    </div>
    <div class="table-responsive">
      <table class="table table-sm table-bordered mt-4">
        <thead>
          <tr>
            <th scope="col">Division</th>
            <th scope="col">Abbreviation</th>
            <th scope="col">No. of staff</th>
            <th scope="col">Head</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="division in props.divisions" :key="division.id" class="">
            <td>{{ division.name }}</td>
            <td>{{ division.abbreviation }}</td>
            <td>{{ division.positions.length }}</td>
            <td>
              <!-- <span v-if="division.chief.length > 0"> {{ division.chief[0].user.name }}</span> -->
            </td>
            <td class="d-flex gap-2">
              <Link class="btn btn-success btn-sm" :href="route('admin.divisions.edit', {division: division.id})">
                <span style="pointer-events: none;" class="fa-solid fa-cog" />
              </Link>
              <Link :onBefore="confirm" method="delete" as="button" :href="route('admin.divisions.destroy', {division: division.id})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash" /></Link>
            </td>
          </tr>
        </tbody>
      </table>
      
      <!-- CREATE FORM -->
      <CreateDivisionModal :createForm="createForm" />
    </div>
  </AdminLayout>
</template>
      
<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import CreateDivisionModal from './CreateDivisionModal.vue'
  
const props = defineProps({
  divisions : Array,
})

const createForm = useForm({
  name: '',
  abbreviation: '',
  head: '',
  start_date: null,
})
  
  
const confirm = () => window.confirm('Delete this division?')
  
const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Division',
  },
])
      
</script>
      