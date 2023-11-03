<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <ul class="nav nav-pills  ">
      <li v-for="result in results" :key="result.id" class="nav-item">
        <Link :class="{'active' : result.title === active}" :href="route('admin.recruitment.job_posting.application_history.show', {job_posting: result.job_posting_id, result: result.id})" class="nav-link" aria-current="page">{{ result.title }}</Link>
      </li>
    </ul>
    <div class="container">
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
  return props.application_results.filter(res => !res.phase.includes('SCHEDULE'))
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
    label: props.job.position,
    link: route('admin.recruitment.job_posting.show', {job_posting: props.job.id}),
  },
  {
    label: 'Application History',
  },
])
  
  
</script>