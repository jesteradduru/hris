<template>
  <Head title="DEPDev Exam - Selection" />
  <RecruitmentLayout>
    <div class="card shadow-sm border-0 rounded-3 p-3 mb-4 bg-white">
      <!-- VACANCIES -->
      <JobVacancies :job_vacancies="job_vacancies" :posting="posting" />

      <!-- TITLE BAR -->
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 bg-light p-3 rounded-3 border">
        <div class="d-flex align-items-center gap-3">
          <div>
            <div class="d-flex align-items-center gap-2">
              <h4 class="fw-bold mb-0 text-dark">DEPDev Examination</h4>
              <span class="badge bg-primary text-white rounded-pill px-3 py-1">Stage 3</span>
              <Spinner :processing="loading" :text="'Loading'" />
            </div>
            <small class="text-muted">Record exam scores and evaluate candidate examination results</small>
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
          >
            <span>NEXT (INTERVIEW SCHEDULE)</span>
            <i class="fa-solid fa-arrow-right" />
          </Link>
        </div>
      </div>

      <!-- EXAM DATE PICKER CARD -->
      <div class="p-3 bg-light rounded-3 border mb-3">
        <div class="row align-items-center">
          <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold extra-small text-muted text-uppercase mb-1 d-flex align-items-center gap-1">
              <i class="fa-solid fa-calendar-days text-primary" />Date of Exam
            </label>
            <input
              :value="moment(props.job_vacancy_status.schedule).format('Y-MM-DD')" 
              type="date" 
              class="form-control form-control-sm rounded-2 shadow-none" 
              @input="setSchedule"
            />
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
              <div v-if="props.applicant_details" class="d-flex align-items-center gap-2 mb-3 p-2 bg-light rounded-3 border">
                <span class="small text-muted fw-bold me-2">Action:</span>
                <Link 
                  as="button"
                  class="btn btn-success btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center gap-1"
                  :onBefore="confirm"
                  method="post"
                  :href="route('admin.recruitment.application_result.store', {
                    result_id: props.job_vacancy_status.id,
                    result: 'EXAM_PASSED',
                    application_id: props.applicant_details.job_application[0].id,
                    user_id: props.applicant_details.id,
                  })"
                >
                  <i class="fa-solid fa-circle-check" />
                  <span>PASSED EXAM</span>
                </Link>
                <Link 
                  as="button"
                  class="btn btn-warning text-white btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center gap-1"
                  :onBefore="confirm"
                  method="post"
                  :href="route('admin.recruitment.application_result.store', {
                    result_id: props.job_vacancy_status.id,
                    result: 'EXAM_FAILED',
                    application_id: props.applicant_details.job_application[0].id,
                    user_id: props.applicant_details.id,
                  })"
                >
                  <i class="fa-solid fa-circle-xmark" />
                  <span>FAILED EXAM</span>
                </Link>
              </div>

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
import {Head, Link,  router} from '@inertiajs/vue3'
import { ref, computed} from 'vue'
import Spinner from '@/Components/Spinner.vue'
import JobVacancies from '../Components/JobVacancies.vue'
import {debounce} from 'lodash'
import moment from 'moment'


const props = defineProps({
  job_vacancies: Array,
  posting: Object,
  applicant_details: Object,
  job_vacancy_status: Object,
  qualified_applicants: Array,
})


const setSchedule = debounce((e) => {
  const date = e.target.value
  if(window.confirm('Are you sure?')){
    router.put(route('admin.recruitment.neda_exam.set', {result: props.job_vacancy_status.id, schedule: date}))
  }
}, 200)


import ApplicantsList from '../Components/ApplicantsList.vue'

const loading = ref(false)
const examSchedule = computed(() => moment(props.job_vacancy_status.schedule).format('yyyy-MM-dd'))


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