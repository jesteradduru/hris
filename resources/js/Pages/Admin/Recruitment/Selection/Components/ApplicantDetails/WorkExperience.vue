<template>
  <Box id="work" class="mb-4">
    <template #header>
      <div class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-briefcase text-primary" />
        <span>Work Experience</span>
      </div>
    </template>
    
    <!-- Requirement Banner -->
    <div v-if="plantilla" class="alert alert-primary bg-primary-subtle border-primary-subtle text-primary rounded-3 p-3 mb-3 d-flex align-items-start gap-2">
      <i class="fa-solid fa-circle-info mt-1" />
      <div>
        <small class="text-uppercase fw-bold extra-small d-block text-primary">Work Experience Requirement</small>
        <span class="fw-semibold text-dark">
          <span v-if="plantilla.work_experience">{{ plantilla.work_experience }} year/s of relevant experience.</span>
          <span v-else>None Required</span>
        </span>
      </div>
    </div>

    <!-- Experience Computation Summary -->
    <div v-if="applicant.workExperienceComputation" class="table-responsive mb-3">
      <table class="table table-sm table-bordered align-middle mb-0 bg-white rounded-2 overflow-hidden">
        <thead class="bg-light text-uppercase extra-small text-muted">
          <tr>
            <th class="py-2 px-3">Years of Relevant Experience</th>
            <th class="py-2 px-3">Equivalent Score (65 Max)</th>
            <th class="py-2 px-3">HRMPSB Rating (35 Max)</th>
            <th class="py-2 px-3">Relevant Experience Weight (25%)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-3 fw-bold text-dark">{{ applicant.workExperienceComputation.years }} yrs</td>
            <td class="px-3 fw-bold text-primary">{{ applicant.workExperienceComputation.equivalent }}</td>
            <td class="px-3 fw-bold text-info">{{ applicant.workExperienceComputation.psb }}</td>
            <td class="px-3 fw-bold text-success">{{ applicant.workExperienceComputation.score }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Work Experience Table -->
    <div class="table-responsive">
      <table class="table table-sm table-hover align-middle mb-0 bg-white border rounded-2 overflow-hidden">
        <thead class="bg-light text-uppercase extra-small text-muted border-bottom">
          <tr>
            <th v-if="withControls" class="py-2 px-2 text-center" style="width: 40px;">Select</th>
            <th class="py-2 px-3">Position Title</th>
            <th class="py-2 px-2">Agency / Office / Company</th>
            <th class="py-2 px-2">Appointment Status</th>
            <th class="py-2 px-2 text-center">Govt Service</th>
            <th class="py-2 px-3">Inclusive Dates</th>
          </tr>
        </thead>
        <tbody v-if="works && works.length > 0" class="small text-uppercase">
          <tr 
            v-for="work in works" 
            :id="`work${work.id}`" 
            :key="work.id" 
            :class="{'table-success bg-success-subtle': checkIfIncluded(work.id, 'App\\Models\\WorkExperience')}"
          >
            <td v-if="withControls" class="text-center">
              <input 
                type="checkbox" 
                class="form-check-input border-secondary"
                :checked="checkIfIncluded(work.id, 'App\\Models\\WorkExperience')" 
                :data-id="work.id" 
                @input="includeAward" 
              />
            </td>
            <td class="px-3 fw-semibold text-dark">{{ work.position_title }}</td>
            <td class="px-2 text-muted">{{ work.dept_agency_office_company }}</td>
            <td class="px-2"><span class="badge bg-light text-secondary border extra-small">{{ work.status_of_appointment || 'N/A' }}</span></td>
            <td class="px-2 text-center">
              <span v-if="work.govt_service" class="badge bg-primary-subtle text-primary border px-2">Yes</span>
              <span v-else-if="work.govt_service == 0" class="badge bg-light text-secondary border px-2">No</span>
              <span v-else class="text-muted extra-small">N/A</span>
            </td>
            <td class="px-3 text-muted">
              {{ `${simplifyDate(work.inclusive_date_from)} - ` }}
              <span v-if="work.inclusive_date_to">{{ simplifyDate(work.inclusive_date_to) }}</span>
              <span v-else class="badge bg-success text-white extra-small">PRESENT</span>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="!works || works.length === 0" class="text-center py-4 text-muted extra-small italic border rounded-bottom">
        <i class="fa-solid fa-folder-open me-1" />No work experience records to display
      </div>
    </div>
  </Box>
</template>

<script setup>
import moment from 'moment'
import Box from '../UI/Box.vue'
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  works: Array,
  plantilla: Object,
  withControls: Boolean,
  applicant: Object,
})

const included = computed(() => {
  return props.applicant.job_application[0].included?.map(included => included)
})

const checkIfIncluded = (id, type) => {
  if (!included.value) {
    return
  }
  return included.value.filter(includedVal => includedVal.computable_type === type && includedVal.computable_id === id).length > 0
}


const includeAward = (e) => {
  const id = e.target.getAttribute('data-id')

  router.visit(route('admin.recruitment.work.includeWork', { work: id, job_application_id: props.applicant.job_application[0].id }), {
    method: 'post',
    preserveScroll: true,
    preserveState: true,
  })
}


const simplifyDate = (date) => moment(date).format('MMM D, YYYY')


</script>