<template>
  <Box class="mb-3">
    <template #header>Outstanding Accomplishments</template>
    <div class="mb-2">
      <b>SCHOLARSHIP/ACADEMIC HONORS RECEIVED</b>
      <div class="table-responsive">
        <table class="table table-sm table-bordered">
          <thead>
            <tr>
              <th v-if="withControls" scope="col" />
              <th scope="col">Awards</th>
              <th scope="col">Category</th>
              <th scope="col">File</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(award, index) in applicant.academic_distinction" :id="`award${award.id}`" :key="award.id" :class="{'table-success': checkIfIncluded(award.id, 'App\\Models\\AcademicDistinction')}">
              <td v-if="withControls">
                <input v-if="!award.used_at" type="checkbox" :checked="checkIfIncluded(award.id, 'App\\Models\\AcademicDistinction')" :data-id="award.id" data-type="ACAD" @input="includeAward" />
              </td>
              <td scope="row">{{ award.title }}</td>
              <td>{{ award.category }}</td>
              <td><a :href="award.files[0].src" target="_blank">{{ award.files[0].filename }}</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="mb-2">
      <b>NON-ACADEMIC DISTINCTIONS / RECOGNITION / AWARD</b>
      <div class="table-responsive">
        <table class="table table-sm table-bordered">
          <thead>
            <tr>
              <th v-if="withControls" scope="col" />
              <th scope="col">Awards</th>
              <th scope="col">File</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(award, index) in applicant.non_academic_distinction" :key="award.id" :class="{'table-success': checkIfIncluded(award.id, 'App\\Models\\NonAcademicDistinction')}">
              <td v-if="withControls" class="d-flex gap-2">
                <input v-if="!award.used_at" type="checkbox" :data-id="award.id" :checked="checkIfIncluded(award.id, 'App\\Models\\NonAcademicDistinction')" @input="includeAward" />
                <div>
                  <select id="" name="" :data-id="award.id" :value="award.category" @change="onChangeAwardCategory">
                    <option value="MAJOR_NATIONAL">Major Award (National)</option>
                    <option value="MAJOR_LOCAL">Major Award (Local)</option>
                    <option value="MINOR">Minor Award </option>
                    <option value="SPECIAL">Special Award </option>
                  </select>
                </div>
              </td>
              <td scope="row">{{ award.title }}</td>
              <td><a :href="award.files[0].src" target="_blank">{{ award.files[0].filename }}</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </Box>
</template>
      
<script setup>

import Box from '../UI/Box.vue'
import {debounce} from 'lodash'
import {router } from '@inertiajs/vue3'
import {computed} from 'vue'

const props = defineProps({
  withControls: Boolean,
  applicant: Object,
})

const included = computed(() => {
  return props.applicant.job_application[0].included.map(included => included)
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