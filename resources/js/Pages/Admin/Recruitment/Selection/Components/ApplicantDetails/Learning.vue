<template>
  <div class="mb-3">
    <h5 class="text-primary">Learning and Development</h5>
    <div v-if="plantilla" class="alert alert-primary">
      <div>
        <b>Training Requirement</b>
      </div>
      {{ plantilla.training }}
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
          <tr v-for="learning in props.lnds" :id="`learning${learning.id}`" :key="learning.id">
            <td v-if="withControls">
              <input type="checkbox" :data-id="`learning${learning.id}`" @input="onInclude" />
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
  </div>
</template>
    
<script setup>
    
import {  computed } from 'vue'
    
const props = defineProps({
  lnds: Object,
  plantilla: Object,
  withControls: Object,
})

const onInclude = (e) => {
  const elem = document.querySelector('#' + e.target.getAttribute('data-id'))
  if(e.target.checked){
    elem.classList.add('table-success')
  }else{
    elem.classList.remove('table-success')
  }
}
</script>