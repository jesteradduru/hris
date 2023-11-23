<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <b>VACANCIES</b>
    <JobVacancies :job_vacancies="job_vacancies" :posting="posting" />

    <hr />

    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex justify-content-between align-items-center gap-2">
        <h3>
          Final Result
        </h3>
        <Spinner :processing="loading" :text="'Loading'" />
      </div>
      <Link as="button" method="put" :href="route('admin.recruitment.job_posting.archived', {job_posting: posting.id})" :onBefore="confirm" class="btn btn-primary"><i class="fa-solid fa-archive" />&nbsp; Archive</Link>
    </div>
    <div class="row">
      <div class="col-3">
        <b>SELECTED </b>
        <ApplicantsList :job_applications="props.qualified_applicants" :posting="posting" :applicant_details="applicant_details" />
      </div>
      <div class="col-9">
        <ApplicantDetails v-if="props.applicant_details" :applicant="props.applicant_details" />
      </div>
    </div>
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import ApplicantDetails from '@/Pages/Admin/Recruitment/Selection/Components/ApplicantDetails.vue'
import {Head, Link} from '@inertiajs/vue3'
import { ref } from 'vue'
import Spinner from '@/Components/Spinner.vue'
import JobVacancies from '../Components/JobVacancies.vue'

const props = defineProps({
  job_vacancies: Array,
  posting: Object,
  applicant_details: Object,
  job_vacancy_status: Object,
  qualified_applicants: Array,
})


import { router } from '@inertiajs/vue3'
import moment from 'moment'
import ApplicantsList from '../Components/ApplicantsList.vue'

const loading = ref(false)

router.on('start', () => {
  loading.value = true
})

router.on('finish', () => {
  loading.value = false
})

const confirm = () => window.confirm('Archive this job vacancy?')

</script>