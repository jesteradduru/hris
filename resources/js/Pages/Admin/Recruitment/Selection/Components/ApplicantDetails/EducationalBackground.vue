<template>
  <Box v-if="educ || college_graduate_studies.length > 0" class="mb-3">
    <template #header>Educational BackGround</template>
    <div v-if="plantilla" class="alert alert-primary">
      <div>
        <b>Educational Requirement</b>
      </div>
      {{ plantilla.education }}
    </div>
    <dl>
      <dt>Elementary:</dt>
      <dd>
        {{ `${educ.elem_name_of_school} (${educ.elem_period_from} - ${educ.elem_period_to})` }}
      </dd>
      <dd v-if="educ.elem_scholarship_academic_honors">{{ educ.elem_scholarship_academic_honors }}</dd>
      <dt>Secondary:</dt>
      <dd>
        {{ `${educ.second_name_of_school} (${educ.second_period_from} - ${educ.second_period_to})` }}
      </dd>
      <dd v-if="educ.second_scholarship_academic_honors">{{ educ.second_scholarship_academic_honors }}</dd>
      <div v-if="educ.vocational_name_of_school">
        <dt>Vocational:</dt>
        <dd>
          <span v-if="educ.vocational_basic_ed_degree_course">
            {{ educ.vocational_basic_ed_degree_course }},
          </span>
          {{ `${educ.vocational_name_of_school} (${educ.vocational_period_from} - ${educ.vocational_period_to})` }}
        </dd>
        <dd v-if="educ.vocational_scholarship_academic_honors">{{ educ.vocational_scholarship_academic_honors }}</dd>
      </div>
    </dl>
    <dl v-if="college_graduate_studies.length > 0">
      <dt>College:</dt>
      <dd>
        <div class="table-responsive">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th v-if="withControls" scope="col" />
                <th scope="col">NAME OF SCHOOL</th>
                <th scope="col">DEGREE/COURSE</th>
                <th scope="col">PERIOD OF ATTENDANCE</th>
                <th scope="col">UNITS EARNED</th>
                <th scope="col">YEAR GRADUATED </th>
                <th scope="col">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</th>
                <th scope="col">FILES</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="course in colleges" :id="`course${course.id}`" :key="course.id" class="">
                <td v-if="withControls">
                  <input type="checkbox" :data-id="`course${course.id}`" @input="onInclude" />
                </td>
                <td scope="row">{{ course.name_of_school }}</td>
                <td>{{ course.basic_ed_degree_course }}</td>
                <td>{{ `${course.period_from} - ${course.period_to}` }}</td>
                <td>{{ course.highest_lvl_units_earned }}</td>
                <td>{{ course.year_graduated }}</td>
                <td>
                  <ul>
                    <li v-for="award in course.academic_award" :key="award.id">
                      <span>{{ award.title }}</span>
                    </li>
                  </ul>
                </td>
                <td>
                  <ul>
                    <li v-for="file in course.files" :key="file.id">
                      <a target="_blank" :href="file.src">{{ file.filename }}</a>
                    </li>
                  </ul>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </dd>
      <dd v-if="educ.college_scholarship_academic_honors">{{ educ.college_scholarship_academic_honors }}</dd>
      <dt>Graduate Studies:</dt>
      <dd>
        <div class="table-responsive">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th v-if="withControls" scope="col" />
                
                <th scope="col">NAME OF SCHOOL</th>
                <th scope="col">DEGREE/COURSE</th>
                <th scope="col">PERIOD OF ATTENDANCE</th>
                <th scope="col">UNITS EARNED</th>
                <th scope="col">YEAR GRADUATED </th>
                <th scope="col">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</th>
                <th scope="col">FILES</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="course in graduate_studies" :id="`grad${course.id}`" :key="course.id" class="">
                <td v-if="withControls">
                  <input type="checkbox" :data-id="`grad${course.id}`" @input="onInclude" />
                </td>
                <td scope="row">{{ course.name_of_school }}</td>
                <td>{{ course.basic_ed_degree_course }}</td>
                <td>{{ `${course.period_from} - ${course.period_to}` }}</td>
                <td>{{ course.highest_lvl_units_earned }}</td>
                <td>{{ course.year_graduated }}</td>
                <td>
                  <ul>
                    <li v-for="award in course.academic_award" :key="award.id">
                      <span>{{ award.title }}</span>
                    </li>
                  </ul>
                </td>
                <td>
                  <ul>
                    <li v-for="file in course.files" :key="file.id">
                      <a target="_blank" :href="file.src">{{ file.filename }}</a>
                    </li>
                  </ul>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </dd>
    </dl>
  </Box>
</template>

<script setup>

import {  computed } from 'vue'
import Box from '../UI/Box.vue'

const props = defineProps({
  educ: Object,
  college_graduate_studies: Object,
  plantilla: Object,
  withControls: Boolean,
})

const onInclude = (e) => {
  const elem = document.querySelector('#' + e.target.getAttribute('data-id'))
  if(e.target.checked){
    elem.classList.add('table-success')
  }else{
    elem.classList.remove('table-success')
  }
  
  
}

const colleges = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'COLLEGE')
})
const graduate_studies = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'GRADUATE')
})
</script>