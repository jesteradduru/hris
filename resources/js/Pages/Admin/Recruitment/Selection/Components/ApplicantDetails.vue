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
    <EducationalBackground :educ="educ" :college_graduate_studies="college" :plantilla="plantilla" />
    

    <!-- CS Eligibility -->
    <Eligibility :eligs="eligs" :plantilla="plantilla" />

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
    <Learning :plantilla="plantilla" :lnds="lnds" />

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
import EducationalBackground from '../Components/ApplicantDetails/EducationalBackground.vue'
import Eligibility from '../Components/ApplicantDetails/Eligibility.vue'
import Learning from '../Components/ApplicantDetails/Learning.vue'
import { ref } from 'vue'

const props = defineProps({
  applicant: Object,
  plantilla: Object,
})

const pdf = ref('')
const showPdf = (src) => pdf.value = src


const {
  educational_background:educ,
  civil_service_eligibility:eligs,
  work_experience: works,
  learning_and_development: lnds,
  other_information: skills,
  college_graduate_studies: college,
} = props.applicant


const simplifyDate = (date) => moment(date).format('MMM D, YYYY')
</script>