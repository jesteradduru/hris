<template>
  <Box v-if="educ || college_graduate_studies.length > 0" id="educ" class="mb-3">
    <template #header>Educational BackGround</template>
    <div v-if="plantilla" class="alert alert-primary">
      <div>
        <b>Educational Requirement</b>
      </div>
      {{ plantilla.education }}
    </div>
    <div v-if="educationComputation" class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th>Equivalent Score</th>
            <th>Education(10%)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ educationComputation.equivalent }}</td>
            <td>{{ educationComputation.education }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-if="college_graduate_studies.length > 0">
      <div class="row">
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