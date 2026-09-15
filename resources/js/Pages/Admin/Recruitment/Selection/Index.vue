<template>
  <Head title="Selection and Placement" />
  <RecruitmentLayout>
    <div class="card shadow-sm border-0 rounded-3 p-4 mb-4 bg-white">
      <JobVacancies :job_vacancies="job_vacancies" :posting="posting" />
      
      <div v-if="!posting" class="text-center py-5 bg-light rounded-3 border border-dashed my-3">
        <div class="mb-3">
          <i class="fa-solid fa-arrow-pointer text-primary display-5" />
        </div>
        <h5 class="fw-bold text-dark mb-1">Select a Job Vacancy Above</h5>
        <p class="text-muted small mb-0">Choose an active job vacancy from the list above to view applicant screenings and evaluations.</p>
      </div>
    </div>
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import JobVacancies from './Components/JobVacancies.vue'
import {Head, Link, usePage} from '@inertiajs/vue3'

const props = defineProps({
  job_vacancies: Array,
  posting: Object,
})

</script>