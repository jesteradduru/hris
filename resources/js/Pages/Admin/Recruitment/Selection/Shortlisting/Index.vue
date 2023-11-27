<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <b>VACANCIES</b>
    <JobVacancies :job_vacancies="job_vacancies" :posting="posting" />

    <hr />

    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex justify-content-between align-items-center gap-2">
        <h3>Shortlisting of Applicants</h3>
        <Spinner :processing="loading" :text="'Loading'" />
      </div>
      <div>
        <Link 
          as="button"
          class="btn btn-primary"
          :onBefore="confirm"
          method="put"
          :href="route('admin.recruitment.application_result.publish', {
            results: props.job_vacancy_status.id,
          })"
        >
          PUBLISH
        </Link>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
        <b>APPLICANTS</b>
        <ApplicantsList :job_applications="props.qualified_applicants" :posting="posting" :applicant_details="applicant_details" />
      </div>
      <div class="col-9">
        <div v-if="props.applicant_details" class="d-flex gap-2 mb-3">
          <Link 
            as="button"
            class="btn btn-success btn-sm"
            :onBefore="confirm"
            method="post"
            :href="route('admin.recruitment.application_result.store', {
              result_id: props.job_vacancy_status.id,
              result: 'SHORTLISTED',
              application_id: props.applicant_details.job_application[0].id,
              user_id: props.applicant_details.id,
            })"
          >
            SHORTLIST
          </Link>
          <Link 
            as="button"
            class="btn btn-warning btn-sm"
            :onBefore="confirm"
            method="post"
            :href="route('admin.recruitment.application_result.store', {
              result_id: props.job_vacancy_status.id,
              result: 'UNLISTED',
              application_id: props.applicant_details.job_application[0].id,
              user_id: props.applicant_details.id,
            })"
          >
            UNLIST
          </Link>
        </div>
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

const haveResult = (id) => {
  const applicantHaveResult = props.latest_result.filter(res => res.user_id == id)
  return applicantHaveResult.length > 0
}

const examPassed = (id) => {
  const applicantHaveResult = props.latest_result.filter(res => res.user_id == id)
  const applicantPassed = applicantHaveResult.filter(res =>  res.result == 'EXAM_PASSED')
  return applicantPassed.length > 0 
}

import { router } from '@inertiajs/vue3'
import ApplicantsList from '../Components/ApplicantsList.vue'

const loading = ref(false)
router.on('start', () => {
  loading.value = true
})
router.on('finish', () => {
  loading.value = false
})

const confirm = () => window.confirm('Are you sure?')
</script>