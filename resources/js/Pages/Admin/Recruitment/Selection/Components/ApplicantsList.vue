<template>
  <div class="card shadow-sm border-0 rounded-3 h-100 bg-white">
    <div class="card-header bg-white border-bottom py-3 px-3">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
          <i class="fa-solid fa-users text-primary" />Applicants
        </h6>
        <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill">
          {{ props.job_applications?.length || 0 }}
        </span>
      </div>
      <!-- Search filter -->
      <div class="input-group input-group-sm">
        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass" /></span>
        <input 
          v-model="searchQuery" 
          type="text" 
          class="form-control bg-light border-start-0 ps-0 shadow-none" 
          placeholder="Search applicant..." 
        />
      </div>
    </div>

    <div class="card-body p-2 custom-sidebar-scroll" style="max-height: 75vh; overflow-y: auto;">
      <!-- INSIDER SECTION -->
      <div class="mb-3">
        <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 text-uppercase text-muted fw-bold extra-small">
          <span class="d-flex align-items-center gap-1">
            <i class="fa-solid fa-id-badge text-secondary" />Insider
          </span>
          <span class="badge bg-light text-secondary border rounded-pill">{{ filteredInsider.length }}</span>
        </div>
        
        <div v-if="filteredInsider.length > 0" class="d-flex flex-column gap-1">
          <div 
            v-for="(item, index) in filteredInsider" 
            :key="item.id"
          >
            <Link
              :href="route('admin.recruitment.selection.index', {applicant: item.user.id, job_posting: posting.id})"
              class="applicant-card-item d-flex align-items-center justify-content-between p-2 rounded-2 text-decoration-none transition-all border"
              :class="applicant_details?.id === item.user.id ? 'active-applicant bg-primary-subtle border-primary text-primary fw-bold shadow-sm' : 'bg-white text-dark border-light-subtle hover-bg-light'"
            >
              <div class="d-flex align-items-center gap-2 text-truncate me-2">
                <span class="badge bg-light text-muted border rounded-circle flex-shrink-0" style="width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 10px;">
                  {{ index + 1 }}
                </span>
                <span class="text-truncate small text-uppercase fw-semibold" :title="item.user.name">
                  {{ item.user.name }}
                </span>
              </div>
              <div v-if="item.result" class="flex-shrink-0">
                <span v-if="item.result.length > 0 && item.result[0].result ==='UNQUALIFIED'" class="badge rounded-circle bg-warning text-white p-1" title="Unqualified">
                  <i class="fa-solid fa-xmark" style="font-size: 10px;" />
                </span>
                <span v-else-if="item.result.length > 0 && item.result[0].result ==='QUALIFIED'" class="badge rounded-circle bg-success text-white p-1" title="Qualified">
                  <i class="fa-solid fa-check" style="font-size: 10px;" />
                </span>
                <span v-else-if="item.result === 'EXAM_FAILED' || item.result === 'UNLISTED'" class="badge rounded-circle bg-warning text-white p-1" title="Unlisted / Failed">
                  <i class="fa-solid fa-xmark" style="font-size: 10px;" />
                </span>
                <span v-else-if="item.result === 'EXAM_PASSED' || item.result === 'SELECTED' || item.result === 'SHORTLISTED'" class="badge rounded-circle bg-success text-white p-1" title="Shortlisted / Passed">
                  <i class="fa-solid fa-check" style="font-size: 10px;" />
                </span>
              </div>
            </Link>
          </div>
        </div>
        <small v-else class="text-muted d-block px-2 py-1 italic extra-small">
          No insider applicants
        </small>
      </div>

      <!-- OUTSIDER SECTION -->
      <div>
        <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 text-uppercase text-muted fw-bold extra-small">
          <span class="d-flex align-items-center gap-1">
            <i class="fa-solid fa-user text-secondary" />Outsider
          </span>
          <span class="badge bg-light text-secondary border rounded-pill">{{ filteredOutsider.length }}</span>
        </div>

        <div v-if="filteredOutsider.length > 0" class="d-flex flex-column gap-1">
          <div 
            v-for="(item, index) in filteredOutsider" 
            :key="item.id"
          >
            <Link
              :href="route('admin.recruitment.selection.index', {applicant: item.user.id, job_posting: posting.id})"
              class="applicant-card-item d-flex align-items-center justify-content-between p-2 rounded-2 text-decoration-none transition-all border"
              :class="applicant_details?.id === item.user.id ? 'active-applicant bg-primary-subtle border-primary text-primary fw-bold shadow-sm' : 'bg-white text-dark border-light-subtle hover-bg-light'"
            >
              <div class="d-flex align-items-center gap-2 text-truncate me-2">
                <span class="badge bg-light text-muted border rounded-circle flex-shrink-0" style="width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; font-size: 10px;">
                  {{ index + 1 }}
                </span>
                <span class="text-truncate small text-uppercase fw-semibold" :title="item.user.name">
                  {{ item.user.name }}
                </span>
              </div>
              <div v-if="item.result" class="flex-shrink-0">
                <span v-if="item.result.length > 0 && item.result[0].result ==='UNQUALIFIED'" class="badge rounded-circle bg-warning text-white p-1" title="Unqualified">
                  <i class="fa-solid fa-xmark" style="font-size: 10px;" />
                </span>
                <span v-else-if="item.result.length > 0 && item.result[0].result ==='QUALIFIED'" class="badge rounded-circle bg-success text-white p-1" title="Qualified">
                  <i class="fa-solid fa-check" style="font-size: 10px;" />
                </span>
                <span v-else-if="item.result === 'EXAM_FAILED' || item.result === 'UNLISTED'" class="badge rounded-circle bg-warning text-white p-1" title="Unlisted / Failed">
                  <i class="fa-solid fa-xmark" style="font-size: 10px;" />
                </span>
                <span v-else-if="item.result === 'EXAM_PASSED' || item.result === 'SELECTED' || item.result === 'SHORTLISTED'" class="badge rounded-circle bg-success text-white p-1" title="Shortlisted / Passed">
                  <i class="fa-solid fa-check" style="font-size: 10px;" />
                </span>
              </div>
            </Link>
          </div>
        </div>
        <small v-else class="text-muted d-block px-2 py-1 italic extra-small">
          No outsider applicants
        </small>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const props = defineProps({
  job_applications: {
    type: Array,
    default: () => [],
  },
  posting: Object,
  applicant_details: Object,
})

const searchQuery = ref('')

const insider = computed(() => {
  if (!props.job_applications) return []
  return props.job_applications.filter(application => application.user.role_name.includes('employee'))
})

const outsider = computed(() => {
  if (!props.job_applications) return []
  return props.job_applications.filter(application => application.user.role_name.includes('user'))
})

const filteredInsider = computed(() => {
  if (!searchQuery.value) return insider.value
  return insider.value.filter(item => item.user.name.toLowerCase().includes(searchQuery.value.toLowerCase()))
})

const filteredOutsider = computed(() => {
  if (!searchQuery.value) return outsider.value
  return outsider.value.filter(item => item.user.name.toLowerCase().includes(searchQuery.value.toLowerCase()))
})
</script>

<style scoped>
.extra-small {
  font-size: 0.725rem;
}
.applicant-card-item {
  border-left: 3px solid transparent !important;
}
.active-applicant {
  border-left: 3px solid #0d6efd !important;
}
.hover-bg-light:hover {
  background-color: #f8f9fa !style;
}
</style>