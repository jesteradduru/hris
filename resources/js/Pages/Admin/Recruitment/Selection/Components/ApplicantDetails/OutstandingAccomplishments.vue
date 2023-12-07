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
            <tr v-for="(award, index) in academic_distinctions" :id="`award${award.id}`" :key="award.id">
              <td v-if="withControls">
                <input type="checkbox" :data-id="`award${award.id}`" @input="onInclude" />
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
            <tr v-for="(award, index) in non_academic_distinctions" :id="`naward${award.id}`" :key="award.id">
              <td v-if="withControls">
                <input type="checkbox" :data-id="`naward${award.id}`" @input="onInclude" />
                <div>
                  <select id="" name="">
                    <option value="">Major Award (National)</option>
                    <option value="">Major Award (Local)</option>
                    <option value="">Minor Award </option>
                    <option value="">Special</option>
                  </select>
                </div>
                <!-- <div>
                  <input id="major" type="radio" name="classification" />
                  <label for="major">Major</label>
                  &nbsp;
                  <input id="minor" type="radio" name="classification" />
                  <label for="minor">Minor</label>
                </div> -->
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

const props = defineProps({
  withControls: Boolean,
  academic_distinctions: Array,
  non_academic_distinctions: Array,
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