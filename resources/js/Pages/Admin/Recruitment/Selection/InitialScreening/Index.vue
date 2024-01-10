<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <!-- VACANCIES -->
    <b>VACANCIES</b>
    <JobVacancies :job_vacancies="job_vacancies" :posting="posting" />
    <!-- END OF VACANCIES -->

    <!-- TITLE -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex justify-content-between align-items-center gap-2">
        <h3>Initial Screening</h3>
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
          NEXT (SHORTLISTING)
        </Link>
      </div>
    </div>

    <!-- APPLICANT DETAILS -->
    <div class="row">
      <div class="col-3">
        <ApplicantsList :job_applications="props.job_applications" :posting="posting" :applicant_details="applicant_details" />
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
              result: 'QUALIFIED',
              application_id: props.applicant_details.job_application[0].id,
              user_id: props.applicant_details.id,
            })"
          >
            Qualified
          </Link>
          <Link 
            as="button"
            class="btn btn-warning btn-sm"
            :onBefore="confirm"
            method="post"
            :href="route('admin.recruitment.application_result.store', {
              result_id: props.job_vacancy_status.id,
              result: 'UNQUALIFIED',
              application_id: props.applicant_details.job_application[0].id,
              user_id: props.applicant_details.id,
            })"
          >
            Unqualified
          </Link>
        </div>
        <ApplicantDetails v-if="props.applicant_details" :applicant="props.applicant_details" :plantilla="posting.plantilla" />
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
  job_applications: Array,
  applicant_details: Object,
  job_vacancy_status: Object,
})



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