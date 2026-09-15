<template>
  <Head title="Schedule DEPDev Exam - Selection" />
  <RecruitmentLayout>
    <div class="card shadow-sm border-0 rounded-3 p-3 mb-4 bg-white">
      <!-- VACANCIES -->
      <JobVacancies :job_vacancies="job_vacancies" :posting="posting" />

      <!-- TITLE BAR -->
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 bg-light p-3 rounded-3 border">
        <div class="d-flex align-items-center gap-3">
          <div>
            <div class="d-flex align-items-center gap-2">
              <h4 class="fw-bold mb-0 text-dark">
                Schedule DEPDev Exam
                <span v-if="examScheduleForm.schedule" class="text-primary fs-5 ms-1">
                  (on {{ moment(examScheduleForm.schedule).format('MMM D, YYYY') }})
                </span>
              </h4>
              <span class="badge bg-primary text-white rounded-pill px-3 py-1">Schedule Setup</span>
              <Spinner :processing="loading" :text="'Loading'" />
            </div>
            <small class="text-muted">Set date and time window for the upcoming DEPDev entrance examination</small>
          </div>
        </div>
        <div>
          <Link 
            as="button"
            class="btn btn-primary rounded-pill px-4 shadow-sm fw-semibold d-flex align-items-center gap-2"
            :onBefore="confirm"
            method="put"
            :href="route('admin.recruitment.application_result.publish', {
              results: props.job_vacancy_status.id,
            })"
            :disabled="!examScheduleForm.wasSuccessful"
          >
            <i class="fa-solid fa-paper-plane" />
            <span>PUBLISH SCHEDULE</span>
          </Link>
        </div>
      </div>

      <!-- SCHEDULE FORM CARD -->
      <div class="p-3 bg-light rounded-3 border mb-4">
        <h6 class="fw-bold text-dark mb-3 text-uppercase extra-small d-flex align-items-center gap-2">
          <i class="fa-solid fa-clock text-primary" />Exam Date & Time Controls
        </h6>
        <div class="row g-3 align-items-end">
          <div class="col-md-3">
            <label class="form-label fw-semibold extra-small text-muted text-uppercase mb-1">Date</label>
            <input
              v-model="examScheduleForm.schedule" 
              type="date" 
              class="form-control form-control-sm rounded-2 shadow-none" 
            />
            <InputError :message="examScheduleForm.errors.schedule" />
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold extra-small text-muted text-uppercase mb-1">Start Time</label>
            <input
              v-model="examScheduleForm.start_time" 
              type="time" 
              class="form-control form-control-sm rounded-2 shadow-none" 
            />
            <InputError :message="examScheduleForm.errors.start_time" />
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold extra-small text-muted text-uppercase mb-1">End Time</label>
            <input
              v-model="examScheduleForm.end_time" 
              type="time" 
              class="form-control form-control-sm rounded-2 shadow-none" 
            />
            <InputError :message="examScheduleForm.errors.end_time" />
          </div>
          <div class="col-md-3">
            <button class="btn btn-primary btn-sm rounded-pill px-4 w-100 shadow-sm fw-semibold" @click="setSchedule">
              <i class="fa-solid fa-calendar-check me-1" />Set Schedule
            </button>
          </div>
        </div>
      </div>

      <!-- APPLICANT DETAILS GRID -->
      <div class="row g-3">
        <div class="col-lg-3 col-md-4">
          <ApplicantsList :job_applications="props.qualified_applicants" :posting="posting" :applicant_details="applicant_details" />
        </div>
        <div class="col-lg-9 col-md-8">
          <div v-if="props.applicant_details" class="card border-0 shadow-sm rounded-3 p-3" style="height: 75vh; overflow-y: auto;">
            <ApplicantDetails :applicant="props.applicant_details" />
          </div>
          <div v-else class="text-center py-5 text-muted card border-0 shadow-sm rounded-3 p-5">
            <i class="fa-solid fa-user-slash display-6 mb-2" />
            <p>Please select an applicant from the left list to view details.</p>
          </div>
        </div>
      </div>
    </div>
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import ApplicantDetails from '@/Pages/Admin/Recruitment/Selection/Components/ApplicantDetails.vue'
import {Head, Link, useForm} from '@inertiajs/vue3'
import JobVacancies from '../Components/JobVacancies.vue'
import { ref } from 'vue'
import Spinner from '@/Components/Spinner.vue'
import {debounce} from 'lodash'
import InputError from '@/Components/InputError.vue'
import { router } from '@inertiajs/vue3'
import moment from 'moment'
import ApplicantsList from '../Components/ApplicantsList.vue'

const props = defineProps({
  job_vacancies: Array,
  posting: Object,
  applicant_details: Object,
  job_vacancy_status: Object,
  qualified_applicants: Array,
})

const examScheduleForm = useForm({
  _method: 'put',
  schedule: props.job_vacancy_status.schedule ? moment(props.job_vacancy_status.schedule).format('Y-M-D') : null,
  start_time: props.job_vacancy_status.start_time,
  end_time: props.job_vacancy_status.end_time,
})

const setSchedule = debounce(() => {
  if(window.confirm('Set this schedule for the entrance exam?')){
    examScheduleForm.post(route('admin.recruitment.neda_exam.set', {result: props.job_vacancy_status.id}))
  }
}, 200)




const loading = ref(false)

router.on('start', () => {
  loading.value = true
})

router.on('finish', () => {
  loading.value = false
})

const confirm = () => window.confirm('Are you sure?')
</script>