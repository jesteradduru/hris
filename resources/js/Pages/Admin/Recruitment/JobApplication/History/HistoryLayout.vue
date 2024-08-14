<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <div class="container">
      <ul class="nav nav-pills align-items-center">
        <li v-for="result in results" :key="result.id" class="nav-item">
          <Link :class="{'active' : result.title === active}" :href="route('admin.recruitment.job_posting.application_history.show', {job_posting: result.job_posting_id, result: result.id})" class="nav-link" aria-current="page">{{ result.title }}</Link>
        </li>
        <li class="nav-item ms-auto">
          <small><a :href="route('admin.reports.job_application.export', {job_posting: job.id})" :onBefore="confirm" class="btn btn-secondary"><i class="fa-solid fa-download" />&nbsp; DOWNLOAD RESULT</a></small>
        </li>
      </ul>
      <slot />
    </div>
  </RecruitmentLayout>
</template>
  
<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import {Head, Link} from '@inertiajs/vue3'
import { computed } from 'vue'
  
const props = defineProps({
  application_results: Array,
  active: String,
  job: Object,
})

const results = computed(() => {
  return props.application_results.filter(res => !res.phase.includes('SCHEDULE') && !res.phase.includes('INTERVIEW') )
})
import BreadCrumbs from '@/Components/BreadCrumbs.vue'

const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Recruitment',
  },
  {
    label: 'Job Vacancies',
    link: route('admin.recruitment.job_posting.index'),
  },
  {
    label: props.job.plantilla.position,
    link: route('admin.recruitment.job_posting.show', {job_posting: props.job.id}),
  },
  {
    label: 'Application History',
  },
])
  
const confirm = () => window.confirm('Are you sure?')
</script>