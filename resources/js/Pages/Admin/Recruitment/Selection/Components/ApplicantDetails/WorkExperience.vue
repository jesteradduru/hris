<template>
  <Box id="work" class="mb-3">
    <template #header>Work Experience</template>
    <div v-if="plantilla" class="alert alert-primary">
      <div>
        <b>Work Experience Requirement</b>
      </div>
      {{ plantilla.work_experience }} year/s of relevant experience.
    </div>
    <div v-if="applicant.workExperienceComputation" class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th>Years of relevevant Experience</th>
            <th>Equivalent Score(85)</th>
            <th>HRMPSB Validation Rating(15)</th>
            <th>Relevant Experience (25%)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ applicant.workExperienceComputation.years }}</td>
            <td>{{ applicant.workExperienceComputation.equivalent }}</td>
            <td>{{ applicant.workExperienceComputation.psb }}</td>
            <td>{{ applicant.workExperienceComputation.score }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-if="works.length === 0" class="text-muted text-center text-sm">
      No Record
    </div>
    <div v-else class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th v-if="withControls" scope="col" />
            <th scope="col">Position</th>
            <th scope="col">Agency</th>
            <th scope="col">Status of Appointment</th>
            <th scope="col">Inclusive Date</th>
          </tr>
        </thead>
        <tbody v-if="works">
          <tr v-for="work in works" :id="`work${work.id}`" :key="work.id" class="" :class="{'table-success': checkIfIncluded(work.id, 'App\\Models\\WorkExperience')}">
            <td v-if="withControls">
              <input type="checkbox" :checked="checkIfIncluded(work.id, 'App\\Models\\WorkExperience')" :data-id="work.id" @input="includeAward" />
            </td>
            <td scope="row">{{ work.position_title }}</td>
            <td>{{ work.dept_agency_office_company }}</td>
            <td>{{ work.status_of_appointment }}</td>
            <td>
              {{ `${simplifyDate(work.inclusive_date_from)} - ` }}
              <span v-if="work.inclusive_date_to">{{ simplifyDate(work.inclusive_date_to) }}</span>
              <span v-else>PRESENT</span>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="works.length === 0" class="text-muted text-center text-sm">
        No work experience
      </div>
    </div>
  </Box>
</template>
      
<script setup>
import moment from 'moment'
import Box from '../UI/Box.vue'
import {computed} from 'vue'
import {router} from '@inertiajs/vue3'

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
  if(!included.value){
    return
  }
  return included.value.filter(includedVal => includedVal.computable_type === type && includedVal.computable_id === id).length > 0
}

  
const includeAward = (e) => {
  const id = e.target.getAttribute('data-id')

  router.visit(route('admin.recruitment.work.includeWork', {work: id, job_application_id: props.applicant.job_application[0].id}), {
    method: 'post',
    preserveScroll: true,
    preserveState: true,
  })
}


const simplifyDate = (date) => moment(date).format('MMM D, YYYY')


</script>