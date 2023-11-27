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
        <dt>Contact:</dt>
        <dd><i class="fa-solid fa-mobile" />&nbsp;{{ applicant.personal_information.mobile_number }}</dd>
        <dd><i class="fa-solid fa-phone" />&nbsp;{{ applicant.personal_information.telephone_number }}</dd>
        <dd style="text-transform: lowercase;"><i class="fa-solid fa-envelope" />&nbsp;{{ applicant.personal_information.email_address }}</dd>
      </dl>
    </div>
    <!-- EMPLOYEE RECORDS -->
    <div v-if="applicant.position" class="mb-3">
      <h5 class="text-primary">Employment Records</h5>
      <dl>
        <dt>
          Current Position
        </dt>
        <dd>{{ applicant.position.position }}</dd>
        <dt>Performance Management:</dt>
        <dd>
          <div v-if="applicant.spms.length > 0" class="table-responsive">
            <table class="table table-sm table-bordered">
              <thead>
                <tr>
                  <th scope="col">File</th>
                  <th scope="col">Rating</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(spmsForm) in applicant.spms" :key="spmsForm.id">
                  <td><a :href="spmsForm.src" target="_blank">{{ `${spmsForm.year} ${spmsForm.semester} SEMESTER ${spmsForm.type}` }} <i class="fa-solid fa-up-right-from-square" /></a></td>
                  <td>
                    {{ spmsForm.rating }}
                    <b>
                      {{ spmsForm.rating == 5 ? 'Outstanding' : null }}
                      {{ spmsForm.rating < 5 && spmsForm.rating >= 4 ? 'Very Satisfactory' : null }}
                      {{ spmsForm.rating < 4 && spmsForm.rating >= 3 ? 'Satisfactory' : null }}
                      {{ spmsForm.rating < 3 && spmsForm.rating >= 2 ? 'Unsatisfactory' : null }}
                      {{ spmsForm.rating < 2 && spmsForm.rating >= 1 ? 'Poor' : null }}
                    </b>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-else class="text-muted text-center text-sm">
            No Record
          </div>
        </dd>
        <!-- REWARDS -->
        <dt>rewards:</dt>
        <dd>
          <div v-if="applicant.reward.length > 0" class="table-responsive">
            <table class="table table-bordered mt-3 table-sm">
              <thead>
                <tr>
                  <th scope="col">Title</th>
                  <th scope="col">Points</th>
                  <th scope="col">Date Awarded</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in applicant.reward" :key="item.id" class="">
                  <td scope="row">{{ item.reward.title }}</td>
                  <td>{{ item.reward.points }}</td>
                  <td>{{ moment(item.created_at).format('MMM D, YYYY') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-else class="text-muted text-center text-sm">
            No Record
          </div>
        </dd>
      </dl>
    </div>
    <!-- Educational Background -->
    <div v-if="educ" class="mb-3">
      <h5 class="text-primary">Educational BackGround</h5>
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
      <div v-if="plantilla" class="alert alert-primary">
        <div>
          <b>Eligibility Requirement</b>
        </div>
        {{ plantilla.eligibility }}
      </div>
      <div v-if="eligs.length === 0" class="text-muted text-center text-sm">
        No Record
      </div>
      <div v-else>
        <dl v-for="elig in eligs" :key="elig.id">
          <dt>{{ elig.cs_board_bar_ces_csee_barangay_drivers }}</dt>
          <div v-if=" elig.license_number ">
            License No.:{{ elig.license_number }}
          </div>
          <div v-if="elig.rating">
            Rating: {{ elig.rating }}
          </div>
        </dl>
      </div>
    </div>

    <!-- work experience -->
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
              <th scope="col">Position</th>
              <th scope="col">Agency</th>
              <th scope="col">Inclusive Date</th>
            </tr>
          </thead>
          <tbody v-if="works">
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
      <div v-if="plantilla" class="alert alert-primary">
        <div>
          <b>Training Requirement</b>
        </div>
        {{ plantilla.training }}
      </div>
      <div v-if="lnds.length === 0" class="text-muted text-center text-sm">
        No Record
      </div>
      <div v-else class="table-responsive">
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
      <div v-if="plantilla" class="alert alert-primary">
        <div>
          <b>Competency Requirement</b>
        </div>
        {{ plantilla.competency }}
      </div>
      <div v-if="skills">
        <span v-for="skill in skills.special_skills_hobbies.split(',')" :key="skill" class="badge bg-success">{{ skill }}</span>
      </div>
      <div v-else class="text-muted text-center text-sm">
        No Record
      </div>
    </div>
    <!-- documents -->
    <div class="mb-3">
      <h5 class="text-primary">Attached Documents</h5>
      <div v-if="applicant.job_application">
        <a 
          v-for="doc in applicant.job_application[0].document"
          :key="doc.id" 
          data-bs-toggle="modal" data-bs-target="#viewAttachment" 
          href="#" @click="() => showPdf(doc.src)"
        >{{ doc.filename }}</a>
        <!-- <a v-for="doc in applicant.job_application[0].document" :key="doc.id" target="_blank" :href="doc.src">{{ doc.filename }}</a> -->
      </div>
      <div v-else class="text-muted text-center text-sm">
        No Record
      </div>
    </div>

    <!-- Modal -->
    <Modal modal-max-width="true" modal_id="viewAttachment" modal-xl="true">
      <template #header>View Attachment</template>
      <template #body>
        <embed
          :src="pdf" class="w-100" style="height: 85vh;"
          type="application/pdf"
        />
      </template>
    </Modal>
    <!-- end of line -->
  </div>
</template>

<script setup>
import moment from 'moment'
import Modal from '@/Components/Modal.vue'
import { ref } from 'vue'

const props = defineProps({
  applicant: Object,
  plantilla: Object,
})

const pdf = ref('dffd')
const showPdf = (src) => pdf.value = src


const {
  educational_background:educ,
  civil_service_eligibility:eligs,
  work_experience: works,
  learning_and_development: lnds,
  other_information: skills,
} = props.applicant

const simplifyDate = (date) => moment(date).format('MMM D, YYYY')
</script>