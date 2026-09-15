<template>
  <Head title="Schedule Interview - Selection" />
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
                Schedule Interview
                <span v-if="scheduleForm.schedule" class="text-primary fs-5 ms-1">
                  (on {{ moment(scheduleForm.schedule).format('MMM D, YYYY') }})
                </span>
              </h4>
              <span class="badge bg-primary text-white rounded-pill px-3 py-1">Stage 4</span>
              <Spinner :processing="loading" :text="'Loading'" />
            </div>
            <small class="text-muted">Set interview dates and time for candidate final deliberation</small>
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
            :disabled="!scheduleForm.wasSuccessful && scheduleForm.schedule === null"
          >
            <span>NEXT (INTERVIEW)</span>
            <i class="fa-solid fa-arrow-right" />
          </Link>
        </div>
      </div>

      <!-- SCHEDULE FORM CARD -->
      <div class="p-3 bg-light rounded-3 border mb-4">
        <h6 class="fw-bold text-dark mb-3 text-uppercase extra-small d-flex align-items-center gap-2">
          <i class="fa-solid fa-calendar-check text-primary" />Interview Schedule Controls
        </h6>
        <div class="row g-3 align-items-end">
          <div class="col-md-4">
            <label class="form-label fw-semibold extra-small text-muted text-uppercase mb-1">Date</label>
            <input
              v-model="scheduleForm.schedule" 
              type="date" 
              class="form-control form-control-sm rounded-2 shadow-none" 
            />
            <InputError :message="scheduleForm.errors.schedule" />
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold extra-small text-muted text-uppercase mb-1">Time</label>
            <input
              v-model="scheduleForm.start_time" 
              type="time" 
              class="form-control form-control-sm rounded-2 shadow-none" 
            />
            <InputError :message="scheduleForm.errors.start_time" />
          </div>
          <div class="col-md-4">
            <button class="btn btn-primary btn-sm rounded-pill px-4 w-100 shadow-sm fw-semibold" @click="setSchedule">
              <i class="fa-solid fa-clock me-1" />Set Interview Schedule
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
          <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-light border-bottom p-2">
              <div class="nav nav-pills nav-fill gap-1">
                <button type="button" class="nav-link border-0 text-dark fw-semibold py-2 px-2 small rounded-2" :class="{ 'active bg-primary text-white shadow-sm': activeTab == 'personal' }" data-id="personal" @click="setActive">
                  <i class="fa-solid fa-user me-1" />Personal
                </button>
                <button type="button" class="nav-link border-0 text-dark fw-semibold py-2 px-2 small rounded-2" :class="{ 'active bg-primary text-white shadow-sm': activeTab == 'out-accomp' }" data-id="out-accomp" @click="setActive">
                  <i class="fa-solid fa-award me-1" />Awards
                </button>
                <button type="button" class="nav-link border-0 text-dark fw-semibold py-2 px-2 small rounded-2" :class="{ 'active bg-primary text-white shadow-sm': activeTab == 'performance' }" data-id="performance" @click="setActive">
                  <i class="fa-solid fa-chart-line me-1" />Performance
                </button>
                <button type="button" class="nav-link border-0 text-dark fw-semibold py-2 px-2 small rounded-2" :class="{ 'active bg-primary text-white shadow-sm': activeTab == 'educ' }" data-id="educ" @click="setActive">
                  <i class="fa-solid fa-graduation-cap me-1" />Education
                </button>
                <button type="button" class="nav-link border-0 text-dark fw-semibold py-2 px-2 small rounded-2" :class="{ 'active bg-primary text-white shadow-sm': activeTab == 'lnd' }" data-id="lnd" @click="setActive">
                  <i class="fa-solid fa-certificate me-1" />Trainings
                </button>
                <button type="button" class="nav-link border-0 text-dark fw-semibold py-2 px-2 small rounded-2" :class="{ 'active bg-primary text-white shadow-sm': activeTab == 'work' }" data-id="work" @click="setActive">
                  <i class="fa-solid fa-briefcase me-1" />Experience
                </button>
                <button type="button" class="nav-link border-0 text-dark fw-semibold py-2 px-2 small rounded-2" :class="{ 'active bg-primary text-white shadow-sm': activeTab == 'elig' }" data-id="elig" @click="setActive">
                  <i class="fa-solid fa-id-card me-1" />Eligibility
                </button>
              </div>
            </div>
             
            <div class="card-body p-3" style="height: 75vh; overflow-y: auto;">
              <PsbPoints v-if="props.applicant_details" :applicant_details="applicant_details" />
              <ApplicantDetails 
                v-if="props.applicant_details"
                :latest_spms="props.latest_spms" 
                :applicant="props.applicant_details" 
                :plantilla="posting.plantilla" 
                :posting_id="job_vacancy_status.job_posting_id"
              />
              <div v-else class="text-center py-5 text-muted">
                <i class="fa-solid fa-user-slash display-6 mb-2" />
                <p>Please select an applicant from the left list to view details.</p>
              </div>
            </div>
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
import { ref } from 'vue'
import Spinner from '@/Components/Spinner.vue'
import {debounce} from 'lodash'
import InputError from '@/Components/InputError.vue'
import JobVacancies from '../Components/JobVacancies.vue'

const props = defineProps({
  job_vacancies: Array,
  posting: Object,
  applicant_details: Object,
  job_vacancy_status: Object,
  qualified_applicants: Array,
})

const scheduleForm = useForm({
  _method: 'put',
  schedule: props.job_vacancy_status.schedule ? moment(props.job_vacancy_status.schedule).format('Y-MM-D') : null,
  start_time: props.job_vacancy_status.start_time,
  end_time: props.job_vacancy_status.end_time,
})

const setSchedule = debounce(() => {
  if(window.confirm('Are you sure?')){
    scheduleForm.post(route('admin.recruitment.neda_exam.set', {result: props.job_vacancy_status.id}))
  }
}, 200)


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

const confirm = () => window.confirm('Are you sure?')

const activeTab = ref('personal')

const setActive = (e) => {
  e.preventDefault()
  const btn = e.target.closest('[data-id]')
  if (!btn) return
  const id = btn.getAttribute('data-id')
  activeTab.value = id

  document.querySelectorAll('.tab-section-highlight').forEach(el => {
    el.classList.remove('tab-section-highlight')
  })

  const target = document.getElementById(id)
  if (target) {
    target.scrollIntoView({ behavior: 'smooth', block: 'start' })
    target.classList.add('tab-section-highlight')
  }
}
</script>