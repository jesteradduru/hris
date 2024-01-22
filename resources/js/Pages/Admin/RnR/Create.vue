<template>
  <Head title="Job Vacancies" />
      
  <AdminLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>Create Reward/Recognition</h3>
    
    <form class="w-50 card mx-auto shadow" @submit.prevent="onSubmit">
      <div class="card-body">
        <div class="mb-3">
          <label for="" class="form-label">Title</label>
          <input
            id=""
            v-model="form.title" type="text" class="form-control" name="" aria-describedby="helpId" placeholder=""
          />
          <InputError :message="form.errors.title" />
        </div>
        <div class="mb-3">
          <label for="" class="form-label d-block">Type</label>
          <div class="form-check form-check-inline">
            <input
              id="major"
              v-model="form.category"
              class="form-check-input"
              type="radio"
              name="type"
              value="MAJOR_LOCAL"
            />
            <label class="form-check-label" for="major">Major Award</label>
          </div>
          <div class="form-check form-check-inline">
            <input
              id="MINOR"
              v-model="form.category"
              class="form-check-input"
              type="radio"
              name="type"
              value="MINOR"
            />
            <label class="form-check-label" for="MINOR">Minor Award</label>
          </div>
          
          <InputError :message="form.errors.category" />
        </div>
    
        <div class="mb-3">
          <button
            :disabled="!form.isDirty &&
              form.wasSuccessful" type="submit" class="btn btn-primary btn-md"
          >
            <Spinner :processing="form.processing" /> {{ !form.isDirty &&
              form.wasSuccessful ? 'Added' : 'Add Reward' }}
          </button>
        </div>
      </div>
    </form>
  </AdminLayout>
</template>
      
<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import InputError from '@/Components/InputError.vue'
import Spinner from '@/Components/Spinner.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue'
import Filter from '@/Pages/Admin//Recruitment/JobPosting/Components/Filter.vue'
  
const form = useForm({
  title: null,
  category: null,
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
    label: 'Create',
  },
])

const onSubmit = () => form.post(route('admin.rewards.store'), {
  onSuccess: () => form.reset(),
})
      
</script>
      