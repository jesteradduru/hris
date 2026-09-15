<template>
  <Box id="elig" class="mb-4">
    <template #header>
      <div class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-id-card text-primary" />
        <span>Civil Service & Professional Eligibility</span>
      </div>
    </template>
    
    <!-- Requirement Banner -->
    <div v-if="plantilla" class="alert alert-primary bg-primary-subtle border-primary-subtle text-primary rounded-3 p-3 mb-3 d-flex align-items-start gap-2">
      <i class="fa-solid fa-circle-info mt-1" />
      <div>
        <small class="text-uppercase fw-bold extra-small d-block text-primary">Eligibility Requirement</small>
        <span class="fw-semibold text-dark">{{ plantilla.eligibility || 'None Required' }}</span>
      </div>
    </div>

    <!-- Eligibility Table -->
    <div class="table-responsive">
      <table class="table table-sm table-hover align-middle mb-0 bg-white border rounded-2 overflow-hidden">
        <thead class="bg-light text-uppercase extra-small text-muted border-bottom">
          <tr>
            <th class="py-2 px-3">Eligibility</th>
            <th class="py-2 px-2 text-center">Rating</th>
            <th class="py-2 px-2">Date Examined</th>
            <th class="py-2 px-2">Exam Place</th>
            <th class="py-2 px-2">License No.</th>
            <th class="py-2 px-2">Validity Date</th>
            <th class="py-2 px-3">Attachments</th>
          </tr>
        </thead>
        <tbody v-if="props.eligs && props.eligs.length > 0" class="small text-uppercase">
          <tr v-for="eligibility in props.eligs" :key="eligibility.id">
            <td class="px-3 fw-semibold text-dark">{{ eligibility.cs_board_bar_ces_csee_barangay_drivers }}</td>
            <td class="px-2 text-center">
              <span v-if="eligibility.rating" class="badge bg-success-subtle text-success border px-2 py-1">
                {{ eligibility.rating }}
              </span>
              <span v-else class="text-muted extra-small">N/A</span>
            </td>
            <td class="px-2 text-muted">{{ eligibility.date_of_exam_conferment || 'N/A' }}</td>
            <td class="px-2 text-muted">{{ eligibility.place_of_exam_conferment || 'N/A' }}</td>
            <td class="px-2 text-dark fw-semibold">{{ eligibility.license_number || 'N/A' }}</td>
            <td class="px-2 text-muted">{{ eligibility.license_date_of_validity || 'N/A' }}</td>
            <td class="px-3">
              <div v-if="eligibility.files && eligibility.files.length > 0" class="d-flex flex-wrap gap-1">
                <a 
                  v-for="file in eligibility.files" 
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
      <div v-if="!props.eligs || props.eligs.length === 0" class="text-center py-4 text-muted extra-small italic border rounded-bottom">
        <i class="fa-solid fa-folder-open me-1" />No eligibility records to display
      </div>
    </div>
  </Box>
</template>
  
<script setup>

import Box from '../UI/Box.vue'
  
const props = defineProps({
  eligs: Object,
  plantilla: Object,
})
</script>