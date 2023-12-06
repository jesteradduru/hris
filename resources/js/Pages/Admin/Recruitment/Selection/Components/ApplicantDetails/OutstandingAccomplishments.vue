<template>
  <Box class="mb-3">
    <template #header>Outstanding Accomplishments</template>
    <div class="mb-2">
      <b>SCHOLARSHIP/ACADEMIC HONORS RECEIVED</b>
      <div class="table-responsive">
        <table class="table table-sm table-bordered">
          <thead>
            <tr>
              <th scope="col">Awards</th>
              <th scope="col">Category</th>
              <th scope="col">File</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(award, index) in academic_distinctions" :key="award.id" class="">
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
              <th scope="col">Awards</th>
              <th scope="col">File</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(award, index) in non_academic_distinctions" :key="award.id" class="">
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

const props = defineProps({
  withControls: Boolean,
  academic_distinctions: Array,
  non_academic_distinctions: Array,
})
  
</script>