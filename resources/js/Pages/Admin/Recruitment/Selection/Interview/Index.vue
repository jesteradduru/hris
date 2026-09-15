<template>
  <Head title="Final Deliberation - Selection" />
  <RecruitmentLayout>
    <div class="card shadow-sm border-0 rounded-3 p-3 mb-4 bg-white">
      <!-- VACANCIES -->
      <JobVacancies :job_vacancies="job_vacancies" :posting="posting" />

      <!-- TITLE BAR -->
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 bg-light p-3 rounded-3 border">
        <div class="d-flex align-items-center gap-3">
          <div>
            <div class="d-flex align-items-center gap-2">
              <h4 class="fw-bold mb-0 text-dark">Final Deliberation</h4>
              <span class="badge bg-primary text-white rounded-pill px-3 py-1">Stage 5</span>
              <Spinner :processing="loading" :text="'Loading'" />
            </div>
            <small class="text-muted">Perform final interview evaluation and record committee deliberation notes</small>
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
            <span>NEXT (RANKING OF APPLICANT)</span>
            <i class="fa-solid fa-arrow-right" />
          </Link>
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
             
            <div class="card-body p-3" style="height: 70vh; overflow-y: auto;">
              <PsbPoints v-if="props.applicant_details" :applicant_details="applicant_details" />
              <ApplicantDetails 
                v-if="props.applicant_details"
                :latest_spms="props.latest_spms" 
                :applicant="props.applicant_details" 
                :plantilla="posting.plantilla" 
                :withControls="true" 
                :posting_id="job_vacancy_status.job_posting_id"
              />
              <div v-else class="text-center py-5 text-muted">
                <i class="fa-solid fa-user-slash display-6 mb-2" />
                <p>Please select an applicant from the left list to view details.</p>
              </div>
            </div>

            <!-- NOTES CARD FOOTER -->
            <div v-if="props.applicant_details" class="card-footer bg-light border-top p-3">
              <label class="form-label fw-bold extra-small text-uppercase text-dark mb-1 d-flex align-items-center gap-1">
                <i class="fa-solid fa-comment-dots text-primary" />Interview Notes & Deliberation Feedback
              </label>
              <textarea 
                v-model="form.notes" 
                class="form-control rounded-2 shadow-none border-light-subtle" 
                rows="3" 
                placeholder="Type deliberation notes here... (auto-saves)" 
                @keyup="onChangeNote" 
              />
              <small class="text-muted extra-small italic">Notes auto-save 1 second after typing.</small>
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
import {Head, Link, useForm, usePage} from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import Spinner from '@/Components/Spinner.vue'
import {debounce} from 'lodash'
import InputError from '@/Components/InputError.vue'
import JobVacancies from '../Components/JobVacancies.vue'
import PsbPoints from '../Components/ApplicantDetails/PsbPoints.vue'

const props = defineProps({
  job_vacancies: Array,
  posting: Object,
  applicant_details: Object,
  job_vacancy_status: Object,
  qualified_applicants: Array,
})
  
import { router } from '@inertiajs/vue3'
import ApplicantsList from '../Components/ApplicantsList.vue'
  
const loading = ref(false)
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

const initNotes = computed(() => {
  const applicant = props.qualified_applicants?.filter(qapp => {
    return qapp.user_id === props.applicant_details?.id
  })
  return applicant[0]?.notes
})

const form = useForm({
  _method: 'put',
  notes: initNotes.value,
})

const onChangeNote = debounce(() => {
  const applicant = props.qualified_applicants.filter(qapp => {
    return qapp.user_id === props.applicant_details.id
  })

  form.post(route('admin.recruitment.application_result.updateNotes', {application_result: applicant[0].id}), {
    preserveScroll: true,
    preserveState: true,
  })
}, 1000)


router.on('start', () => {
  loading.value = true
})
router.on('finish', () => {
  loading.value = false
})



const onSaveScore = (application_id) => {

  scoreForm.post(route('admin.recruitment.application_score.store', {application_id: application_id}))
}
  
const confirm = () => window.confirm('Are you sure?')
</script>