<template>
  <Box id="out-accomp" class="mb-4">
    <template #header>
      <div class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-award text-primary" />
        <span>Outstanding Accomplishments & Awards</span>
      </div>
    </template>

    <!-- Awards Computation Rating -->
    <div v-if="applicant.awardsComputation && withControls" class="table-responsive mb-3">
      <table class="table table-sm table-bordered align-middle mb-0 bg-white rounded-2 overflow-hidden">
        <thead class="bg-light text-uppercase extra-small text-muted">
          <tr>
            <th class="py-2 px-3">Equivalent Awards Rating</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-3 fw-bold text-primary">{{ applicant.awardsComputation }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Academic Honors -->
    <div class="mb-4">
      <div class="d-flex align-items-center gap-2 mb-2 text-uppercase text-muted fw-bold extra-small">
        <i class="fa-solid fa-graduation-cap text-primary" />
        <span>Scholarship / Academic Honors Received</span>
      </div>
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle mb-0 bg-white border rounded-2 overflow-hidden">
          <thead class="bg-light text-uppercase extra-small text-muted border-bottom">
            <tr>
              <th v-if="withControls" class="py-2 px-2 text-center" style="width: 40px;">Select</th>
              <th class="py-2 px-3">Award Title</th>
              <th class="py-2 px-2">Category</th>
              <th class="py-2 px-3">Attachment</th>
            </tr>
          </thead>
          <tbody v-if="applicant.academic_distinction && applicant.academic_distinction.length > 0" class="small text-uppercase">
            <tr 
              v-for="award in applicant.academic_distinction" 
              :id="`award${award.id}`" 
              :key="award.id" 
              :class="{'table-success bg-success-subtle': checkIfIncluded(award.id, 'App\\Models\\AcademicDistinction')}"
            >
              <td v-if="withControls" class="text-center">
                <input 
                  v-if="!award.used_at" 
                  type="checkbox" 
                  class="form-check-input border-secondary"
                  :checked="checkIfIncluded(award.id, 'App\\Models\\AcademicDistinction')" 
                  :data-id="award.id" 
                  data-type="ACAD" 
                  @input="includeAward" 
                />
              </td>
              <td class="px-3 fw-semibold text-dark">{{ award.title }}</td>
              <td class="px-2"><span class="badge bg-light text-secondary border extra-small">{{ award.category }}</span></td>
              <td class="px-3">
                <a 
                  v-if="award.files && award.files[0]" 
                  :href="award.files[0]?.src" 
                  target="_blank" 
                  class="badge bg-white text-primary border text-decoration-none hover-shadow-sm extra-small d-inline-flex align-items-center gap-1 p-1"
                >
                  <i class="fa-solid fa-paperclip" />
                  <span class="text-truncate" style="max-width: 120px;">{{ award.files[0]?.filename }}</span>
                </a>
                <span v-else class="text-muted extra-small italic">None</span>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="!applicant.academic_distinction || applicant.academic_distinction.length === 0" class="text-center py-3 text-muted extra-small italic border rounded-bottom">
          No academic honors recorded
        </div>
      </div>
    </div>

    <!-- Non-Academic Distinctions -->
    <div>
      <div class="d-flex align-items-center gap-2 mb-2 text-uppercase text-muted fw-bold extra-small">
        <i class="fa-solid fa-trophy text-primary" />
        <span>Non-Academic Distinctions / Recognition / Awards</span>
      </div>
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle mb-0 bg-white border rounded-2 overflow-hidden">
          <thead class="bg-light text-uppercase extra-small text-muted border-bottom">
            <tr>
              <th v-if="withControls" class="py-2 px-3">Evaluation Control & Category</th>
              <th class="py-2 px-3">Award Title</th>
              <th class="py-2 px-2">Date Awarded</th>
              <th class="py-2 px-3">Attachment</th>
            </tr>
          </thead>
          <tbody v-if="applicant.non_academic_distinction && applicant.non_academic_distinction.length > 0" class="small text-uppercase">
            <tr 
              v-for="award in applicant.non_academic_distinction" 
              :key="award.id" 
              :class="{'table-success bg-success-subtle': checkIfIncluded(award.id, 'App\\Models\\NonAcademicDistinction')}"
            >
              <td v-if="withControls" class="px-3">
                <div class="d-flex align-items-center gap-2">
                  <input 
                    v-if="!award.used_at" 
                    type="checkbox" 
                    class="form-check-input border-secondary flex-shrink-0"
                    :data-id="award.id" 
                    :checked="checkIfIncluded(award.id, 'App\\Models\\NonAcademicDistinction')" 
                    @input="includeAward" 
                  />
                  <select 
                    class="form-select form-select-sm extra-small py-0 border-light-subtle" 
                    :data-id="award.id" 
                    :value="award.category" 
                    @change="onChangeAwardCategory"
                  >
                    <option value="MAJOR_NATIONAL">Major Award (National)</option>
                    <option value="MAJOR_LOCAL">Major Award (Local)</option>
                    <option value="MINOR">Minor Award</option>
                    <option value="SPECIAL">Special Award</option>
                  </select>
                </div>
              </td>
              <td class="px-3 fw-semibold text-dark">{{ award.title }}</td>
              <td class="px-2 text-muted">{{ moment(award.date_awarded).format('MMM D, YYYY') }}</td>
              <td class="px-3">
                <a 
                  v-if="award.files && award.files[0]" 
                  :href="award.files[0]?.src" 
                  target="_blank" 
                  class="badge bg-white text-primary border text-decoration-none hover-shadow-sm extra-small d-inline-flex align-items-center gap-1 p-1"
                >
                  <i class="fa-solid fa-paperclip" />
                  <span class="text-truncate" style="max-width: 120px;">{{ award.files[0]?.filename }}</span>
                </a>
                <span v-else class="text-muted extra-small italic">None</span>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="!applicant.non_academic_distinction || applicant.non_academic_distinction.length === 0" class="text-center py-3 text-muted extra-small italic border rounded-bottom">
          No non-academic distinctions recorded
        </div>
      </div>
    </div>
  </Box>
</template>
      
<script setup>

import Box from '../UI/Box.vue'
import {debounce} from 'lodash'
import {computed} from 'vue'
import {router } from '@inertiajs/vue3'
import moment from 'moment'

const props = defineProps({
  withControls: Boolean,
  applicant: Object,
})

const included = computed(() => {
  if(props.applicant.job_application[0].included){
    return props.applicant.job_application[0].included.map(included => included)
  }else{
    return []
  }
})

const checkIfIncluded = (id, type) => {
  return included.value.filter(includedVal => includedVal.computable_type === type && includedVal.computable_id === id).length > 0
}

const includeAward = (e) => {
  const awardId = e.target.getAttribute('data-id')
  const type = e.target.getAttribute('data-type')
  if(type == 'ACAD') {
    router.visit(route('admin.recruitment.academic_distinction.includeAward', {academic: awardId, job_application_id: props.applicant.job_application[0].id}), {
      method: 'post',
      preserveScroll: true,
      preserveState: true,
    })
  }else{
    router.visit(route('admin.recruitment.non_academic_distinction.includeAward', {non_academic: awardId, job_application_id: props.applicant.job_application[0].id}), {
      method: 'post',
      preserveScroll: true,
      preserveState: true,
    })
  }
}

const onChangeAwardCategory = debounce((e) => {
  const category = e.target.value
  const awardId = e.target.getAttribute('data-id')

  router.visit(route('admin.recruitment.non_academic_distinction.updateCategory', {non_academic: awardId}), {
    method: 'put',
    data: {
      category: category,
    },
    preserveScroll: true,
    preserveState: true,
  })

}, 1000)

</script>