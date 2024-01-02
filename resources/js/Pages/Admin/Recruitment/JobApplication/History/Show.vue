<template>
  <Head title="Selection" />
  <HistoryLayout :application_results="application_results" :active="result.title" :job="props.posting">
    <!-- TITLE -->
    <div class="d-flex justify-content-between align-items-center mb-1">
      <div class="d-flex justify-content-between align-items-center gap-2">
        <h3 class="mt-3">
          {{ result.title }}
          <span v-if="result.schedule"> {{ moment(result.schedule).format('MMM D, Y') }}</span>
        </h3>
        <Spinner :processing="loading" :text="'Loading'" />
      </div>
    </div>

    <!-- FINAL RESULT -->
    <div v-if="result.phase === 'FINAL'">
      <Result :posting="posting" />
    </div>
  
    <!-- APPLICANT DETAILS -->
    <div class="row">
      <div class="col-3">
        <b>
          <span v-if="result.phase === 'FINAL'">SELECTED</span>
          APPLICANT
        </b>
        <ol v-if="props.result.result.length !== 0">
          <li v-for="(item) in props.result.result" :key="item.id">
            <Link
              :class="{
                'text-dark': applicant_details?.id === item.user.id,
              }" :href="route('admin.recruitment.job_posting.application_history.show', {job_posting: posting.id, applicant: item.user.id, result: result.id})"
            >
              {{ item.user.name }}
            </Link>
            <div v-if="item.result">
              <span v-if="item.result.length > 0 && !isChecked(item.result) && result.phase !== 'FINAL'" class="badge rounded-pill text-bg-warning">
                <i class="fa-solid fa-x " />
              </span>
              <span v-if="item.result.length > 0 && isChecked(item.result)" class="badge rounded-pill text-bg-success">
                <i class="fa-solid fa-check" />
              </span>
            </div>
          </li>
        </ol>
        <small v-else class="text-muted d-block">
          No Applications
        </small>
      </div>
      <div class="col-9">
        <ApplicantDetails v-if="props.applicant_details" :applicant="props.applicant_details" />
        <div v-if="props.applicant_details && props.applicant_details.job_application[0].latest_result.notes">
          <h5 class="text-primary">INTERVIEW NOTES</h5>
          <div class="text-pre-wrap">
            {{ props.applicant_details.job_application[0].latest_result.notes }}
          </div>
        </div>
      </div>
    </div>
  </HistoryLayout>
</template>
  
<script setup>
import HistoryLayout from './HistoryLayout.vue'
import ApplicantDetails from '@/Pages/Admin/Recruitment/Selection/Components/ApplicantDetails.vue'
import {Head, Link} from '@inertiajs/vue3'
import { ref } from 'vue'
import Spinner from '@/Components/Spinner.vue'
import Result from '../History/Components/Result.vue'
import { router } from '@inertiajs/vue3'
import moment from 'moment'
  
const props = defineProps({
  job_vacancies: Array,
  posting: Object,
  job_applications: Array,
  applicant_details: Object,
  job_vacancy_status: Object,
  application_results:Array,
  result: Object,
})
  
  
const loading = ref(false)

router.on('start', () => {
  loading.value = true
})

router.on('finish', () => {
  loading.value = false
})

const isChecked = (value) => {
  const check = ['QUALIFIED', 'EXAM_PASSED', 'SELECTED', 'SHORTLISTED']

  return check.includes(value) || value === ''
}

</script>