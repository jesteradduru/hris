<template>
  <div style="text-transform: uppercase" class="row">
    <!-- Personal Information -->
    <PersonalInformation :applicant="applicant" />
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
    <EducationalBackground :educ="educ" :college_graduate_studies="college" :plantilla="plantilla" :withControls="withControls" />
    

    <!-- CS Eligibility -->
    <Eligibility :eligs="eligs" :plantilla="plantilla" />

    <!-- work experience -->
    <WorkExperience :works="works" :plantilla="plantilla" :with-controls="withControls" />
    
    


    <!-- learning and development -->
    <Learning :plantilla="plantilla" :lnds="lnds" :withControls="withControls" />

    <!-- outstanding accomplishments -->
    <OutstandingAccomplishments :withControls="withControls" :academic_distinctions="applicant.academic_distinction" :non_academic_distinctions="applicant.non_academic_distinction" />


    <Box>
      <!-- special skills and hobbies -->
      <div class="mb-3">
        <h5 class="text-primary">Special Skills and Hobbies</h5>
        <!-- <div v-if="plantilla" class="alert alert-primary">
        <div>
          <b>Competency Requirement</b>
        </div>
        {{ plantilla.competency }}
      </div> -->
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
    </Box>
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
import OutstandingAccomplishments from '../Components/ApplicantDetails/OutstandingAccomplishments.vue'
import PersonalInformation from '../Components/ApplicantDetails/PersonalInformation.vue'
import WorkExperience from '../Components/ApplicantDetails/WorkExperience.vue'
import { ref } from 'vue'
import Box from './UI/Box.vue'

const props = defineProps({
  applicant: Object,
  plantilla: Object,
  withControls: Boolean,
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



</script>