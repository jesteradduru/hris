<template>
  <div class="mb-3">
    <h5 class="text-primary">Eligibility</h5>
    <div v-if="plantilla" class="alert alert-primary">
      <div>
        <b>Eligibility Requirement</b>
      </div>
      {{ plantilla.eligibility }}
    </div>
    <div class="table-responsive">
      <table class="table table-sm table-bordered mt-3">
        <thead>
          <tr>
            <th scope="col">ELIGIBIILITY</th>
            <th scope="col">RATING(If applicable)</th>
            <th scope="col">DATE OF EXAMINATION</th>
            <th scope="col">PLACE OF EXAMINATION</th>
            <th scope="col">LICENSE NUMBER</th>
            <th scope="col">DATE OF VALIDITY</th>
            <th scope="col">FILES</th>
          </tr>
        </thead>
        <tbody v-if="props.eligs" style="text-transform: uppercase;">
          <tr v-for="eligibility in props.eligs" :key="eligibility.id">
            <td scope="row">{{ eligibility.cs_board_bar_ces_csee_barangay_drivers }}</td>
            <td>{{ eligibility.rating }}</td>
            <td>{{ eligibility.date_of_exam_conferment }}</td>
            <td>{{ eligibility.place_of_exam_conferment }}</td>
            <td>{{ eligibility.license_number }}</td>
            <td>{{ eligibility.license_date_of_validity }}</td>
            <td>
              <ul>
                <li v-for="file in eligibility.files" :key="file.id">
                  <a target="_blank" :href="file.src">{{ file.filename }}</a>
                </li>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="!props.eligs" class="text-center">No records to display</div>
    </div>
  </div>
</template>
  
<script setup>
  
import {  computed } from 'vue'
  
const props = defineProps({
  eligs: Object,
  plantilla: Object,
})
</script>