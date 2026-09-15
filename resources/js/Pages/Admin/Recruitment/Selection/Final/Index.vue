<template>
  <Head title="Final Result - Selection" />
  <RecruitmentLayout>
    <div class="card shadow-sm border-0 rounded-3 p-3 mb-4 bg-white">
      <!-- VACANCIES -->
      <JobVacancies :job_vacancies="job_vacancies" :posting="{ id : posting.job_posting.id}" />

      <!-- TITLE BAR -->
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 bg-light p-3 rounded-3 border">
        <div class="d-flex align-items-center gap-3">
          <div>
            <div class="d-flex align-items-center gap-2">
              <h4 class="fw-bold mb-0 text-dark">Final Result & Candidate Ranking</h4>
              <span class="badge bg-success text-white rounded-pill px-3 py-1">Final Stage</span>
              <Spinner :processing="loading" :text="'Loading'" />
            </div>
            <small class="text-muted">Review comparative scores, rank candidates, and appoint successful applicants</small>
          </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <Link 
            as="button" 
            method="post" 
            :href="route('admin.recruitment.result.rollbackInterview', {result: props.job_vacancy_status.id})" 
            :onBefore="confirm" 
            class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center gap-1"
          >
            <i class="fa-solid fa-arrow-left" />
            <span>Previous</span>
          </Link>
          <a 
            :href="route('admin.reports.job_application.export', {job_posting: posting.job_posting.id})" 
            :onBefore="confirm" 
            class="btn btn-success btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center gap-1 text-white"
          >
            <i class="fa-solid fa-download" />
            <span>Export Result</span>
          </a>
          <Link 
            as="button" 
            method="put" 
            :href="route('admin.recruitment.job_posting.archived', {job_posting: posting.job_posting.id})" 
            :onBefore="confirm" 
            class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center gap-1"
          >
            <i class="fa-solid fa-box-archive" />
            <span>Archive Post</span>
          </Link>
        </div>
      </div>

      <!-- RANKING FILTER & CONTROL CARD -->
      <div class="p-3 bg-light rounded-3 border mb-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
          <div class="col-md-5 col-lg-4">
            <label class="form-label fw-semibold extra-small text-muted text-uppercase mb-1 d-flex align-items-center gap-1">
              <i class="fa-solid fa-arrow-down-wide-short text-primary" />Sort & Rank Candidates By
            </label>
            <select
              class="form-select form-select-sm rounded-2 shadow-none fw-semibold text-dark"
              :value="columnToFilter"
              @change="onRank"
            >
              <option value="total">Overall Total Score (100%)</option>
              <option value="performance">Performance Score</option>
              <option value="education">Education & Training Score</option>
              <option value="experience">Experience Score</option>
              <option value="personality">Personality Score</option>
              <option value="potential">Potential Score</option>
            </select>
          </div>

          <div class="d-flex align-items-center gap-2">
            <button 
              type="button" 
              class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm d-flex align-items-center gap-2"
              @click="toggleAllNotes"
            >
              <i class="fa-solid" :class="allExpanded ? 'fa-compress' : 'fa-expand'" />
              <span>{{ allExpanded ? 'Collapse All Notes' : 'Expand All Notes' }}</span>
            </button>
          </div>
        </div>
      </div>

      <!-- COMPARATIVE MATRIX TABLE -->
      <div class="table-responsive">
        <table class="table table-sm table-bordered table-hover align-middle mb-0 bg-white border rounded-2 overflow-hidden">
          <thead class="bg-light text-uppercase extra-small text-muted text-center border-bottom">
            <tr>
              <th scope="col" rowspan="2" class="align-middle px-3 text-start bg-light" style="min-width: 240px;">Candidate Name</th>
              <th scope="col" colspan="2" class="border-start border-end" :class="{'bg-primary-subtle text-primary': columnToFilter == 'performance'}">Performance</th>
              <th scope="col" colspan="2" class="border-start border-end" :class="{'bg-primary-subtle text-primary': columnToFilter == 'education'}">Education & Training</th>
              <th scope="col" colspan="2" class="border-start border-end" :class="{'bg-primary-subtle text-primary': columnToFilter == 'experience'}">Experience</th>
              <th scope="col" colspan="2" class="border-start border-end" :class="{'bg-primary-subtle text-primary': columnToFilter == 'personality'}">Personality</th>
              <th scope="col" colspan="2" class="border-start border-end" :class="{'bg-primary-subtle text-primary': columnToFilter == 'potential'}">Potential</th>
              <th scope="col" colspan="2" class="border-start border-end" :class="{'bg-primary-subtle text-primary': columnToFilter == 'total'}">Total Score</th>
              <th scope="col" rowspan="2" class="align-middle px-3 bg-light" style="width: 130px;">Appointment</th>
            </tr>
            <tr>
              <th scope="col" class="small">Score</th>
              <th scope="col" class="small">Rank</th>
              <th scope="col" class="small">Score</th>
              <th scope="col" class="small">Rank</th>
              <th scope="col" class="small">Score</th>
              <th scope="col" class="small">Rank</th>
              <th scope="col" class="small">Score</th>
              <th scope="col" class="small">Rank</th>
              <th scope="col" class="small">Score</th>
              <th scope="col" class="small">Rank</th>
              <th scope="col" class="small fw-bold">Total (100%)</th>
              <th scope="col" class="small fw-bold">Rank</th>
            </tr>
          </thead>
          <tbody class="small text-center">
            <template v-for="application in applications" :key="application.id">
              <tr>
                <td class="text-start px-3 py-2">
                  <div class="d-flex align-items-center justify-content-between gap-2">
                    <div>
                      <span class="fw-bold text-dark">{{ application.user.name }}</span>
                      <span v-if="application.notes" class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill ms-2 extra-small" title="Has interview notes">
                        <i class="fa-solid fa-comment-dots me-1"></i>Notes
                      </span>
                    </div>
                    <button 
                      type="button" 
                      class="btn btn-sm py-0 px-2 rounded-pill d-inline-flex align-items-center gap-1 border transition-all"
                      :class="expandedNotes[application.id] ? 'btn-primary text-white shadow-sm' : 'btn-light text-secondary hover-bg-light'"
                      @click="toggleNotes(application.id)"
                      :title="expandedNotes[application.id] ? 'Collapse Interview Notes' : 'Expand Interview Notes'"
                    >
                      <i class="fa-solid fa-comment-dots" :class="{'text-primary': !expandedNotes[application.id]}"></i>
                      <i class="fa-solid" :class="expandedNotes[application.id] ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                  </div>
                </td>
                
                <!-- Performance -->
                <td :class="{'bg-primary-subtle fw-bold': columnToFilter == 'performance'}">{{ application.scores.performance }}</td>
                <td :class="{'bg-primary-subtle fw-bold': columnToFilter == 'performance'}">
                  <span class="badge bg-light text-dark border">{{ application.scores.performance_rank }}</span>
                </td>
                
                <!-- Education -->
                <td :class="{'bg-primary-subtle fw-bold': columnToFilter == 'education'}">{{ application.scores.education }}</td>
                <td :class="{'bg-primary-subtle fw-bold': columnToFilter == 'education'}">
                  <span class="badge bg-light text-dark border">{{ application.scores.education_rank }}</span>
                </td>

                <!-- Experience -->
                <td :class="{'bg-primary-subtle fw-bold': columnToFilter == 'experience'}">{{ application.scores.experience }}</td>
                <td :class="{'bg-primary-subtle fw-bold': columnToFilter == 'experience'}">
                  <span class="badge bg-light text-dark border">{{ application.scores.experience_rank }}</span>
                </td>

                <!-- Personality -->
                <td :class="{'bg-primary-subtle fw-bold': columnToFilter == 'personality'}">{{ application.scores.personality }}</td>
                <td :class="{'bg-primary-subtle fw-bold': columnToFilter == 'personality'}">
                  <span class="badge bg-light text-dark border">{{ application.scores.personality_rank }}</span>
                </td>

                <!-- Potential -->
                <td :class="{'bg-primary-subtle fw-bold': columnToFilter == 'potential'}">{{ application.scores.potential }}</td>
                <td :class="{'bg-primary-subtle fw-bold': columnToFilter == 'potential'}">
                  <span class="badge bg-light text-dark border">{{ application.scores.potential_rank }}</span>
                </td>

                <!-- Total -->
                <td :class="{'bg-primary-subtle fw-bold text-primary': columnToFilter == 'total'}" class="fw-bold">{{ application.scores.total }}</td>
                <td :class="{'bg-primary-subtle fw-bold text-primary': columnToFilter == 'total'}">
                  <span class="badge bg-primary rounded-circle" style="width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;">
                    {{ application.scores.total_rank }}
                  </span>
                </td>

                <!-- Action -->
                <td class="px-2 text-center">
                  <button
                    :disabled="application.latest_result.result === 'SELECTED'"
                    class="btn btn-sm rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1"
                    :class="application.latest_result.result === 'SELECTED' ? 'btn-success opacity-100' : 'btn-outline-success hover-bg-success'"
                    data-bs-toggle="modal" 
                    data-bs-target="#positions" 
                    :onClick="() => {
                      onAppoint({
                        result_id: props.job_vacancy_status.id,
                        result: application.latest_result.result === 'SELECTED' ? 'SELECTION' : 'SELECTED',
                        application_id: application.id,
                        user_id: application.user.id,
                      })
                    }"
                  >
                    <i v-if="application.latest_result.result === 'SELECTED'" class="fa-solid fa-circle-check" />
                    <i v-else class="fa-solid fa-user-check" />
                    <span>{{ application.latest_result.result === 'SELECTED' ? 'APPOINTED' : 'APPOINT' }}</span>
                  </button>
                </td>
              </tr>

              <!-- COLLAPSIBLE INTERVIEW NOTES ROW -->
              <tr v-if="expandedNotes[application.id]" class="bg-light-subtle">
                <td colspan="14" class="p-3 bg-light border-bottom text-start">
                  <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-white py-2 px-3 border-bottom d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                          <i class="fa-solid fa-comment-dots"></i>
                        </span>
                        <div>
                          <h6 class="mb-0 fw-bold text-dark extra-small text-uppercase">Interview & Deliberation Notes</h6>
                          <small class="text-muted extra-small">Committee feedback & notes for {{ application.user.name }}</small>
                        </div>
                      </div>
                      <button 
                        type="button" 
                        class="btn-close btn-sm" 
                        @click="toggleNotes(application.id)"
                        aria-label="Close notes"
                      ></button>
                    </div>
                    <div class="card-body p-3 bg-white">
                      <div class="mb-2">
                        <label class="form-label extra-small fw-semibold text-muted text-uppercase mb-1">
                          <i class="fa-solid fa-pen-to-square me-1 text-primary"></i>Notes Content
                        </label>
                        <textarea 
                          v-model="application.notes" 
                          class="form-control form-control-sm rounded-2 shadow-none border-light-subtle" 
                          rows="3" 
                          placeholder="Type deliberation notes here... (auto-saves)" 
                          @input="onSaveNote(application.result_id, application.notes)" 
                        />
                      </div>
                      <div class="d-flex align-items-center justify-content-between extra-small text-muted">
                        <span class="italic"><i class="fa-solid fa-circle-info me-1 text-primary"></i>Notes automatically save as you type.</span>
                        <span v-if="savingNote[application.result_id]" class="text-primary fw-semibold d-flex align-items-center gap-1">
                          <i class="fa-solid fa-spinner fa-spin"></i> Saving...
                        </span>
                        <span v-else-if="savedNote[application.result_id]" class="text-success fw-semibold d-flex align-items-center gap-1">
                          <i class="fa-solid fa-circle-check"></i> Saved
                        </span>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>

    <!-- MODAL FOR PLANTILLA POSITIONS -->
    <Modal id="positions" modal-xl>
      <template #header>
        <div class="d-flex align-items-center gap-2 text-primary fw-bold">
          <i class="fa-solid fa-sitemap" />
          <span>Open Plantilla Positions Selection</span>
        </div>
      </template>
      <template #body>
        <div class="table-responsive">
          <table class="table table-sm table-hover align-middle mb-0 bg-white border rounded-2">
            <thead class="bg-light text-uppercase extra-small text-muted border-bottom">
              <tr>
                <th class="py-2 px-3">Position</th>
                <th class="py-2 px-2">Item No</th>
                <th class="py-2 px-2">Division</th>
                <th class="py-2 px-3 text-center">Action</th>
              </tr>
            </thead>
            <tbody class="small text-uppercase">
              <tr v-for="position in positions" :key="position.id">
                <td class="px-3 fw-bold text-dark">{{ position.position }}</td>
                <td class="px-2 font-monospace">{{ position.plantilla_item_no }}</td>
                <td class="px-2 text-muted">{{ position.division?.name || 'N/A' }}</td>
                <td class="px-3 text-center">
                  <div data-bs-toggle="modal" data-bs-target="#loadData">
                    <Link
                      class="btn btn-success btn-sm rounded-pill px-3 shadow-sm" 
                      :onBefore="confirmSelect"
                      method="post"
                      :href="route('admin.recruitment.application_result.store', {
                        result_id: props.job_vacancy_status.id,
                        result: user_result.result,
                        application_id: user_result.application_id,
                        user_id: user_result.user_id,
                        plantilla_id: position.id
                      })"
                    >
                      <i class="fa-solid fa-check me-1" />Select Position
                    </Link>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </template>
    </Modal>
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import Spinner from '@/Components/Spinner.vue'
import Modal from '@/Components/Modal.vue'
import JobVacancies from '../Components/JobVacancies.vue'
import { debounce } from 'lodash'

const props = defineProps({
  job_vacancies: Array,
  posting: Object,
  job_vacancy_status: Object,
  positions: Array,
})

const loading = ref(false)
const expandedNotes = ref({})
const savingNote = ref({})
const savedNote = ref({})

const user_result = ref({
  result_id: props.job_vacancy_status.id,
  result: 'SELECTED',
  application_id: null,
  user_id: null,
})

const onAppoint = (result) => {
  user_result.value = result
}

router.on('start', () => {
  loading.value = true
})

router.on('finish', () => {
  loading.value = false
})

const confirm = () => window.confirm('Are you sure?')
const confirmSelect = () => window.confirm('Select this applicant for this position?')

const columnToFilter = ref('total')

const applications = computed(() => {
  const mappedApplications = props.posting.result.map(res => {
    const app = { ...res.application }
    app.result_id = res.id
    app.notes = res.notes || ''
    return app
  })

  mappedApplications.sort((a, b) => b.scores[columnToFilter.value] - a.scores[columnToFilter.value])

  return mappedApplications
})

const toggleNotes = (appId) => {
  expandedNotes.value[appId] = !expandedNotes.value[appId]
}

const allExpanded = computed(() => {
  if (!applications.value.length) return false
  return applications.value.every(app => expandedNotes.value[app.id])
})

const toggleAllNotes = () => {
  const newState = !allExpanded.value
  applications.value.forEach(app => {
    expandedNotes.value[app.id] = newState
  })
}

const onSaveNote = debounce((resultId, notesValue) => {
  savingNote.value[resultId] = true
  savedNote.value[resultId] = false

  router.post(
    route('admin.recruitment.application_result.updateNotes', {
      application_result: resultId,
    }),
    { notes: notesValue },
    {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        savingNote.value[resultId] = false
        savedNote.value[resultId] = true
        setTimeout(() => {
          savedNote.value[resultId] = false
        }, 2000)
      },
      onError: () => {
        savingNote.value[resultId] = false
      }
    }
  )
}, 800)

const onRank = (e) => {
  const column = e.target.value
  columnToFilter.value = column
}
</script>