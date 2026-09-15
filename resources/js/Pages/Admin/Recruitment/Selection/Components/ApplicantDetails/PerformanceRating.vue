<template>
  <Box id="performance" class="mb-4">
    <template #header>
      <div class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-chart-line text-primary" />
        <span>Performance Rating (IPCR / PES)</span>
      </div>
    </template>
    
    <div v-if="isEmployee">
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle mb-0 bg-white border rounded-2 overflow-hidden">
          <thead class="bg-light text-uppercase extra-small text-muted border-bottom">
            <tr>
              <th v-if="withControls" class="py-2 px-2 text-center" style="width: 40px;">Select</th>
              <th class="py-2 px-3">Semester & Year</th>
              <th class="py-2 px-3 text-center">Rating</th>
              <th v-if="applicant.spms?.length > 0" class="py-2 px-3 text-center">Equivalent Rating (70 Points Max)</th>
            </tr>
          </thead>
          <tbody v-if="applicant.spms && applicant.spms.length > 0" class="small text-uppercase">
            <tr v-for="(ipcr, index) in applicant.spms" :id="`ipcr${ipcr.id}`" :key="ipcr.id">
              <td v-if="withControls" class="text-center">
                <input 
                  type="checkbox" 
                  class="form-check-input border-secondary"
                  :checked="checkIfIncluded(ipcr.id, 'App\\Models\\SpmsForm')" 
                  :data-id="ipcr.id" 
                  @input="includeIPCR" 
                />
              </td>
              <td class="px-3 fw-semibold">
                <a :href="ipcr.src" target="_blank" class="text-primary text-decoration-none d-inline-flex align-items-center gap-1 hover-underline">
                  <span>{{ `${ipcr.semester} SEMESTER ${ipcr.year}` }}</span>
                  <i class="fa-solid fa-up-right-from-square extra-small" />
                </a>
              </td>
              <td class="px-3 text-center fw-bold text-dark">{{ ipcr.rating }}</td>
              <td v-if="index == 0 && applicant.performanceComputation" rowspan="2" class="px-3 text-center align-middle bg-light-subtle">
                <span class="badge bg-primary fs-6 px-3 py-2 shadow-sm rounded-pill">
                  {{ applicant.performanceComputation.equivalent }}
                </span>
              </td>
            </tr>
          </tbody>
          <tbody v-else class="small text-uppercase">
            <tr>
              <td v-if="withControls" />
              <td class="px-3 text-muted italic">No SPMS IPCR rating records</td>
              <td class="px-3 text-center">-</td>
              <td class="px-3 text-center fw-bold text-primary">{{ applicant.performanceComputation?.equivalent || 'N/A' }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    
    <div v-else>
      <button 
        v-if="!applicant.pes_rating" 
        class="btn btn-success btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center gap-2 mb-2" 
        data-bs-toggle="modal" 
        data-bs-target="#addSpmsRating"
      >
        <i class="fa-solid fa-plus" />
        <span>Add PES Rating</span>
      </button>

      <div v-else class="table-responsive">
        <table class="table table-sm table-hover align-middle mb-0 bg-white border rounded-2 overflow-hidden">
          <thead class="bg-light text-uppercase extra-small text-muted border-bottom">
            <tr>
              <th class="py-2 px-3">Semester</th>
              <th class="py-2 px-3 text-center">Rating</th>
              <th v-if="applicant.pes_rating" class="py-2 px-3 text-center">Equivalent Rating (70 Points Max)</th>
            </tr>
          </thead>
          <tbody class="small text-uppercase">
            <tr>
              <td class="px-3 fw-semibold text-dark">First Semester</td>
              <td class="px-3 text-center fw-bold text-dark">{{ applicant.pes_rating.first_rating }}</td>
              <td v-if="applicant.performanceComputation" rowspan="2" class="px-3 text-center align-middle bg-light-subtle">
                <span class="badge bg-primary fs-6 px-3 py-2 shadow-sm rounded-pill">
                  {{ applicant.performanceComputation.equivalent }}
                </span>
              </td>
            </tr>
            <tr>
              <td class="px-3 fw-semibold text-dark">Second Semester</td>
              <td class="px-3 text-center fw-bold text-dark">{{ applicant.pes_rating.second_rating }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </Box>

  <!-- Modal for PES Rating -->
  <Modal id="addSpmsRating">
    <template #header>
      <div class="d-flex align-items-center gap-2 text-primary fw-bold">
        <i class="fa-solid fa-square-plus" />
        <span>Add PES Rating</span>
      </div>
    </template>
    <template #body>
      <div class="mb-3">
        <label class="form-label fw-semibold extra-small text-muted text-uppercase">First Semester Rating (1 - 5)</label>
        <input
          v-model="form.first_rating" 
          type="number" 
          class="form-control rounded-3" 
          min="1" 
          max="5" 
          placeholder="e.g. 4.5"
        />
        <InputError :message="form.errors.first_rating" />
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold extra-small text-muted text-uppercase">Second Semester Rating (1 - 5)</label>
        <input
          v-model="form.second_rating" 
          type="number" 
          class="form-control rounded-3" 
          min="1" 
          max="5" 
          placeholder="e.g. 4.8"
        />
        <InputError :message="form.errors.second_rating" />
      </div>
      <div class="d-flex justify-content-end gap-2 pt-2">
        <button class="btn btn-primary rounded-pill px-4" :disabled="form.processing" @click="onSubmit">
          <i class="fa-solid fa-save me-1" />Submit Rating
        </button>
      </div>
    </template>
  </Modal>
</template>
        
<script setup>
  
import Modal from '@/Components/Modal.vue'
import Box from '../UI/Box.vue'
import {useForm} from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import {router} from '@inertiajs/vue3'
import { computed } from 'vue'
  
const props = defineProps({
  withControls: Boolean,
  isEmployee: Boolean,
  applicant: Object,
  posting_id: Number,
  latest_spms: Array,
})

const form = useForm({
  first_rating: null,
  second_rating: null,
})

const onSubmit = () => {
  form.post(route('admin.recruitment.pes.store', {user_id: props.applicant.id, job_posting_id: props.posting_id}))
}

const included = computed(() => {
  return props.applicant.job_application[0].included?.map(included => included)
})

const checkIfIncluded = (id, type) => {
  if(!included.value){
    return
  }
  return included.value.filter(includedVal => includedVal.computable_type === type && includedVal.computable_id === id).length > 0
}

  
const includeIPCR = (e) => {
  const id = e.target.getAttribute('data-id')

  router.visit(route('admin.recruitment.spms.includeIPCR', {spms: id, job_application_id: props.applicant.job_application[0].id}), {
    method: 'post',
    preserveScroll: true,
    preserveState: true,
  })
}


</script>