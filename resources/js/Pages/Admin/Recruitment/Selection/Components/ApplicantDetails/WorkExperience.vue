<template>
  <div class="mb-3">
    <h5 class="text-primary">Work Experience</h5>
    <div v-if="plantilla" class="alert alert-primary">
      <div>
        <b>Work Experience Requirement</b>
      </div>
      {{ plantilla.work_experience }}
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
            <th scope="col">Inclusive Date</th>
          </tr>
        </thead>
        <tbody v-if="works">
          <tr v-for="work in works" :id="`work${work.id}`" :key="work.id" class="">
            <td v-if="withControls">
              <input type="checkbox" :data-id="`work${work.id}`" @input="onInclude" />
            </td>
            <td scope="row">{{ work.position_title }}</td>
            <td>{{ work.dept_agency_office_company }}</td>
            <td>{{ `${simplifyDate(work.inclusive_date_from)} - ${simplifyDate(work.inclusive_date_to)}` }}</td>
          </tr>
        </tbody>
      </table>
      <div v-if="works.length === 0" class="text-muted text-center text-sm">
        No work experience
      </div>
    </div>
  </div>
</template>
      
<script setup>
import moment from 'moment'

const props = defineProps({
  works: Array,
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

const simplifyDate = (date) => moment(date).format('MMM D, YYYY')
</script>