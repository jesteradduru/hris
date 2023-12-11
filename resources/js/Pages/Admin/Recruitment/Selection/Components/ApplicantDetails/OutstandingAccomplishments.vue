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
            <tr v-for="(award, index) in applicant.academic_distinction" :id="`award${award.id}`" :key="award.id">
              <td v-if="withControls">
                <input type="checkbox" :data-id="award.id" @input="includeAward" />
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
            <tr v-for="(award, index) in applicant.non_academic_distinction" :id="`naward${award.id}`" :key="award.id">
              <td v-if="withControls" class="d-flex gap-2">
                <input type="checkbox" :data-id="award.id" @input="includeAward" />
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

const props = defineProps({
  withControls: Boolean,
  applicant: Object,
})

  
// const onInclude = (e) => {
//   const elem = document.querySelector('#' + e.target.getAttribute('data-id'))
//   const awardId = e.target.getAttribute('data-id')
//   if(e.target.checked){
//     elem.classList.add('table-success')
    
//   }else{
//     elem.classList.remove('table-success')
//   }
// }

const includeAward = (e) => {
  const awardId = e.target.getAttribute('data-id')
  router.visit(route('admin.recruitment.non_academic_distinction.includeAward', {non_academic: awardId, job_application_id: props.applicant.job_application[0].id}), {
    method: 'post',
    preserveScroll: true,
  })
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
  })

}, 1000)

</script>