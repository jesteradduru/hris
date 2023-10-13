<template>
  <div style="text-transform: uppercase" class="row">
    <!-- Personal Information -->
    <div class="mb-3">
      <h5 class="text-primary">Personal Information</h5>
      <dl>
        <dt>
          Name
        </dt>
        <dd>{{ applicant.name }}</dd>
        <dt>Date of Birth:</dt>
        <dd>{{ moment(applicant.personal_information.date_of_birth).format('MMM D, YYYY') }}</dd>
        <dt>Sex:</dt>
        <dd>{{ applicant.personal_information.sex }}</dd>
        <dt>Civil Status:</dt>
        <dd>{{ applicant.personal_information.civil_status }}</dd>
        <dt>Address:</dt>
        <dd>{{ applicant.personal_information.address }}</dd>
      </dl>
    </div>
    <!-- Educational Background -->
    <div class="mb-3">
      <h5 class="text-primary">Educational BackGround</h5>
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

    <!-- CS Eligibility -->
    <div class="mb-3">
      <h5 class="text-primary">Civil Service Eligibility</h5>
      <dl v-for="elig in eligs" :key="elig.id">
        <dt>{{ elig.cs_board_bar_ces_csee_barangay_drivers }}</dt>
        <dd v-if="elig.license_number">
          <div v-if=" elig.license_number ">
            License No.:{{ elig.license_number }}
          </div>
          <div v-if="elig.rating">
            Rating: {{ elig.rating }}
          </div>
        </dd>
      </dl>
    </div>

    <!-- work experience -->
    <div class="mb-3">
      <h5 class="text-primary">Work Experience</h5>
      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th scope="col">Position</th>
              <th scope="col">Agency</th>
              <th scope="col">Inclusive Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="work in works" :key="work.id" class="">
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
    <!-- learning and development -->
    <div class="mb-3">
      <h5 class="text-primary">Learning and Development</h5>
      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th scope="col">Training</th>
              <th scope="col">Inclusive Date</th>
              <th scope="col">Hours</th>
              <th scope="col">Type of LD</th>
              <th scope="col">CONDUCTED/ SPONSORED BY</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="lnd in lnds" :key="lnd.id" class="">
              <td scope="row">{{ lnd.title_of_learning }}</td>
              <td>{{ `${simplifyDate(lnd.inclusive_date_from)} - ${simplifyDate(lnd.inclusive_date_to)}` }}</td>
              <td>{{ lnd.number_of_hours }}</td>
              <td>{{ lnd.type_of_ld }}</td>
              <td>{{ lnd.conducted_sponsored_by }}</td>
            </tr>
          </tbody>
        </table>
        <div v-if="works.length === 0" class="text-muted text-center text-sm">
          No Record
        </div>
      </div>
    </div>

    <!-- special skills and hobbies -->
    <div class="mb-3">
      <h5 class="text-primary">Special Skills and Hobbies</h5>
      <span v-for="skill in skills.special_skills_hobbies.split(',')" :key="skill" class="badge bg-success">{{ skill }}</span>
      <div v-if="skills.special_skills_hobbies === 0" class="text-muted text-center text-sm">
        No Record
      </div>
    </div>
    <!-- end of line -->
  </div>
</template>

<script setup>
import moment from 'moment'
const props = defineProps({
  applicant: Object,
})

const {
  educational_background:educ,
  civil_service_eligibility:eligs,
  work_experience: works,
  learning_and_development: lnds,
  other_information: skills,
} = props.applicant

const simplifyDate = (date) => moment(date).format('MMM D, YYYY')
</script>