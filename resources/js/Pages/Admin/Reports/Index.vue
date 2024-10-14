<template>
  <Head title="Performance Management" />
  <AdminLayout>
    <h3>Reports</h3>

    <div class="mb-3">
      <label for="" class="form-label">Select Report</label>
      <select
        id=""
        v-model="form.report"
        class="form-select form-select-lg"
        name=""
      >
        <option value="">Select one</option>
        <option value="applicants">List of Applicants</option>
        <option value="longlist">Longlisted Applicants</option>
        <option value="shortlisted">Shortlisted Applicants</option>
        <option value="exam">NEDA Exam Result</option>
      </select>
    </div>

    <div v-if="form.report !== ''" class="mb-3">
      <label for="" class="form-label">Select Job Vacancy</label>
      <select
        
        id=""
        v-model="form.posting"
        class="form-select form-select-lg"
        name=""
      >
        <option value="">All</option>
        <option v-for="posting in job_posting" :key="posting.id" :value="posting.id">{{ posting.plantilla.position }}</option>
      </select>

      <a class="btn btn-primary mt-3" target="_blank" :href="route('admin.reports.export', {posting: form.posting, report: form.report})">Export</a>
    </div>
  </AdminLayout>
</template>
      
<script setup>
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import {Head, useForm, router} from '@inertiajs/vue3'

const props = defineProps({
  job_posting: Array,
})

const form = useForm({
  report: '',
  posting: '',
})

</script>