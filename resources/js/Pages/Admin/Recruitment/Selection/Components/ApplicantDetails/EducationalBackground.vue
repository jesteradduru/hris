<template>
  <Box v-if="educ || college_graduate_studies?.length > 0" id="educ" class="mb-4">
    <template #header>
      <div class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-graduation-cap text-primary" />
        <span>Educational Background</span>
      </div>
    </template>
    
    <!-- Plantilla Requirement Alert -->
    <div v-if="plantilla" class="alert alert-primary bg-primary-subtle border-primary-subtle text-primary rounded-3 p-3 mb-3 d-flex align-items-start gap-2">
      <i class="fa-solid fa-circle-info mt-1" />
      <div>
        <small class="text-uppercase fw-bold extra-small d-block text-primary">Educational Requirement</small>
        <span class="fw-semibold text-dark">{{ plantilla.education || 'None Required' }}</span>
      </div>
    </div>

    <!-- Education Computation Summary -->
    <div v-if="educationComputation" class="table-responsive mb-3">
      <table class="table table-sm table-bordered align-middle mb-0 bg-white rounded-2 overflow-hidden">
        <thead class="bg-light text-uppercase extra-small text-muted">
          <tr>
            <th class="py-2 px-3">Equivalent Score</th>
            <th class="py-2 px-3">Education Weight (10%)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-3 fw-bold text-primary">{{ educationComputation.equivalent }}</td>
            <td class="px-3 fw-bold text-success">{{ educationComputation.education }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Courses List -->
    <div v-if="college_graduate_studies?.length > 0">
      <div class="row g-3">
        <EducationBox :courses="college_graduate_studies" />
      </div>
    </div>
  </Box>
</template>

<script setup>

import Box from '../UI/Box.vue'
import EducationBox from '../UI/EducationBox.vue'

const props = defineProps({
  educ: Object,
  college_graduate_studies: Object,
  plantilla: Object,
  withControls: Boolean,
  educationComputation: Object,
})


</script>
