<template>
  <Box id="lnd" class="mb-4">
    <template #header>
      <div class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-certificate text-primary" />
        <span>Learning and Development (Trainings)</span>
      </div>
    </template>
    
    <!-- Requirement Banner -->
    <div v-if="plantilla" class="alert alert-primary bg-primary-subtle border-primary-subtle text-primary rounded-3 p-3 mb-3 d-flex align-items-start gap-2">
      <i class="fa-solid fa-circle-info mt-1" />
      <div>
        <small class="text-uppercase fw-bold extra-small d-block text-primary">Training Requirement</small>
        <span class="fw-semibold text-dark">
          <span v-if="plantilla.training">{{ plantilla.training }} hour/s of relevant training.</span>
          <span v-else>None Required</span>
        </span>
      </div>
    </div>

    <!-- Training Computation Summary -->
    <div v-if="applicant.trainingComputation" class="table-responsive mb-3">
      <table class="table table-sm table-bordered align-middle mb-0 bg-white rounded-2 overflow-hidden">
        <thead class="bg-light text-uppercase extra-small text-muted">
          <tr>
            <th class="py-2 px-3">Total Hours</th>
            <th class="py-2 px-3">Equivalent Score</th>
            <th class="py-2 px-3">Relevant Trainings Weight (10%)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-3 fw-bold text-dark">{{ applicant.trainingComputation.hours }} hrs</td>
            <td class="px-3 fw-bold text-primary">{{ applicant.trainingComputation.equivalent }}</td>
            <td class="px-3 fw-bold text-success">{{ applicant.trainingComputation.score }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- LND Table -->
    <div class="table-responsive">
      <table class="table table-sm table-hover align-middle mb-0 bg-white border rounded-2 overflow-hidden">
        <thead class="bg-light text-uppercase extra-small text-muted border-bottom">
          <tr>
            <th v-if="withControls" class="py-2 px-2 text-center" style="width: 40px;">Select</th>
            <th class="py-2 px-3">Title of Training / L&D</th>
            <th class="py-2 px-2">From</th>
            <th class="py-2 px-2">To</th>
            <th class="py-2 px-2 text-center">Hours</th>
            <th class="py-2 px-2">Type</th>
            <th class="py-2 px-2">Conducted / Sponsored By</th>
            <th class="py-2 px-3">Attachments</th>
          </tr>
        </thead>
        <tbody v-if="props.lnds && props.lnds.length > 0" class="small text-uppercase">
          <tr 
            v-for="learning in props.lnds" 
            :id="`learning${learning.id}`" 
            :key="learning.id" 
            :class="{'table-success bg-success-subtle': checkIfIncluded(learning.id, 'App\\Models\\LearningAndDevelopment')}"
          >
            <td v-if="withControls" class="text-center">
              <input 
                type="checkbox" 
                class="form-check-input border-secondary"
                :data-id="learning.id" 
                :checked="checkIfIncluded(learning.id, 'App\\Models\\LearningAndDevelopment')" 
                @input="includeLnd" 
              />
            </td>
            <td class="px-3 fw-semibold text-dark">{{ learning.title_of_learning }}</td>
            <td class="px-2 text-muted">{{ learning.inclusive_date_from || 'N/A' }}</td>
            <td class="px-2 text-muted">{{ learning.inclusive_date_to || 'N/A' }}</td>
            <td class="px-2 text-center font-monospace fw-bold text-primary">{{ learning.number_of_hours }}</td>
            <td class="px-2"><span class="badge bg-light text-secondary border extra-small">{{ learning.type_of_ld || 'N/A' }}</span></td>
            <td class="px-2 text-muted">{{ learning.conducted_sponsored_by || 'N/A' }}</td>
            <td class="px-3">
              <div v-if="learning.files && learning.files.length > 0" class="d-flex flex-wrap gap-1">
                <a 
                  v-for="file in learning.files" 
                  :key="file.id" 
                  target="_blank" 
                  :href="file.src"
                  class="badge bg-white text-primary border text-decoration-none hover-shadow-sm extra-small d-inline-flex align-items-center gap-1 p-1"
                >
                  <i class="fa-solid fa-paperclip" />
                  <span class="text-truncate" style="max-width: 100px;">{{ file.filename }}</span>
                </a>
              </div>
              <span v-else class="text-muted extra-small italic">None</span>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="!props.lnds || props.lnds.length === 0" class="text-center py-4 text-muted extra-small italic border rounded-bottom">
        <i class="fa-solid fa-folder-open me-1" />No learning and development records to display
      </div>
    </div>
  </Box>
</template>
    
<script setup>
    
import Box from '../UI/Box.vue'
import {router} from '@inertiajs/vue3'
import {computed} from 'vue'
    
const props = defineProps({
  lnds: Object,
  plantilla: Object,
  withControls: Boolean,
  applicant: Object,
})

const included = computed(() => {
  return  props.applicant?.job_application.length > 0 ?  props.applicant?.job_application[0].included?.map(included => included) : false
})

const checkIfIncluded = (id, type) => {
  return included.value ? included.value.filter(includedVal => includedVal.computable_type === type && includedVal.computable_id === id).length > 0 : false
}

const includeLnd = (e) => {
  const lndID = e.target.getAttribute('data-id')

  router.visit(route('admin.recruitment.lnd.includeLnd', {lnd: lndID, job_application_id: props.applicant.job_application[0].id}), {
    method: 'post',
    preserveScroll: true,
    preserveState: true,
  })
}
</script>