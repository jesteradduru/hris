<template>
  <Box id="lnd" class="mb-3">
    <template #header>Learning and Development</template>
    <div v-if="plantilla" class="alert alert-primary">
      <div>
        <b>Training Requirement</b>
      </div>
      <span v-if="plantilla.training">{{ plantilla.training }} hour/s of relevant training.</span>
      <span v-else>None Required</span>
    </div>
    <div v-if="applicant.trainingComputation" class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th>Total No. of Hours</th>
            <th>Equivalent Score</th>
            <th>Relevant Trainings (10%)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ applicant.trainingComputation.hours }}</td>
            <td>{{ applicant.trainingComputation.equivalent }}</td>
            <td>{{ applicant.trainingComputation.score }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="table-responsive">
      <table class="table table-sm table-bordered mt-3">
        <thead>
          <tr>
            <th v-if="withControls" scope="col" />
            <th scope="col">LEARNING AND DEVELOPMENT</th>
            <th scope="col">FROM</th>
            <th scope="col">TO</th>
            <th scope="col">NUMBER OF HOURS</th>
            <th scope="col">TYPE OF LD</th>
            <th>CONDUCTED/ SPONSORED BY</th>
            <th>ATTACHMENTS</th>
          </tr>
        </thead>
        <tbody v-if="props.lnds.length" style="text-transform: uppercase;">
          <tr v-for="learning in props.lnds" :id="`learning${learning.id}`" :key="learning.id" :class="{'table-success': checkIfIncluded(learning.id, 'App\\Models\\LearningAndDevelopment')}">
            <td v-if="withControls">
              <input type="checkbox" :data-id="learning.id" :checked="checkIfIncluded(learning.id, 'App\\Models\\LearningAndDevelopment')" @input="includeLnd" />
            </td>
            <td scope="row">{{ learning.title_of_learning }}</td>
            <td>{{ learning.inclusive_date_from }}</td>
            <td>{{ learning.inclusive_date_to }}</td>
            <td>{{ learning.number_of_hours }}</td>
            <td>{{ learning.type_of_ld }}</td>
            <td>{{ learning.conducted_sponsored_by }}</td>
            <td>
              <ul>
                <li v-for="file in learning.files" :key="file.id">
                  <a target="_blank" :href="file.src">{{ file.filename }}</a>
                </li>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="!props.lnds.length" class="text-center">No records to display</div>
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