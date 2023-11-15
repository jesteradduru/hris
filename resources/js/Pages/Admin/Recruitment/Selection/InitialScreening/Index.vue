<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <!-- VACANCIES -->
    <b>VACANCIES</b>
    <ul>
      <li v-for="item in props.job_vacancies" :key="item.id">
        <Link
          :href="route('admin.recruitment.selection.index', 
                       {job_posting: item.id}
          )"
          :class="{'text-dark': item.id == posting.id}"
        >
          {{ item.plantilla.position }}
        </Link>
      </li>
    </ul>
    <!-- END OF VACANCIES -->
    <hr />

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
          PUBLISH
        </Link>
      </div>
    </div>

    <!-- APPLICANT DETAILS -->
    <div class="row">
      <div class="col-3">
        <b>APPLICANTS</b>
        <ol v-if="props.job_applications.length !== 0">
          <li v-for="(item) in props.job_applications" :key="item.id">
            <Link
              :class="{
                'text-dark': applicant_details?.id === item.user.id,
              }" :href="route('admin.recruitment.selection.index', {job_posting: posting.id, applicant: item.user.id})"
            >
              {{ item.user.name }}
            </Link>
            <span v-if="item.result.length > 0 && item.result[0].result ==='UNQUALIFIED'" class="badge rounded-pill text-bg-warning">
              <i class="fa-solid fa-x " />
            </span>
            <span v-if="item.result.length > 0 && item.result[0].result ==='QUALIFIED'" class="badge rounded-pill text-bg-success">
              <i class="fa-solid fa-check" />
            </span>
          </li>
        </ol>
        <small v-else class="text-muted d-block">
          No Applications
        </small>
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


const props = defineProps({
  job_vacancies: Array,
  posting: Object,
  job_applications: Array,
  applicant_details: Object,
  job_vacancy_status: Object,
})



import { router } from '@inertiajs/vue3'

const loading = ref(false)
router.on('start', () => {
  loading.value = true
})
router.on('finish', () => {
  loading.value = false
})

const confirm = () => window.confirm('Are you sure?')
</script>