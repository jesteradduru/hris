<template>
  <div style="text-transform: uppercase">
    <div class="mb-2">
      <b>{{ applicant.name }}</b>
    </div>
    <!-- Personal Information -->
    <div class="mb-2">
      <dl>
        <dt>Dateof Birth:</dt>
        <dd>{{ moment(applicant.personal_information.date_of_birth).format('MMM d, YYYY') }}</dd>
        <dt>Sex:</dt>
        <dd>{{ applicant.personal_information.sex }}</dd>
        <dt>Civil Status:</dt>
        <dd>{{ applicant.personal_information.civil_status }}</dd>
        <dt>Address:</dt>
        <dd>{{ applicant.personal_information.address }}</dd>
      </dl>
    </div>
    <!-- Educational Background -->
    <div class="mb-2">
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
        <dt>College:</dt>
        <dd>
          <span v-if="educ.college_basic_ed_degree_course">
            {{ educ.college_basic_ed_degree_course }},
          </span>
          {{ `${educ.college_name_of_school} (${educ.college_period_from} - ${educ.college_period_to})` }}
        </dd>
        <dd v-if="educ.college_scholarship_academic_honors">{{ educ.college_scholarship_academic_honors }}</dd>
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
    </div>
  </div>
</template>

<script setup>
import moment from 'moment'
const props = defineProps({
  applicant: Object,
})

const {educational_background:educ} = props.applicant
</script>