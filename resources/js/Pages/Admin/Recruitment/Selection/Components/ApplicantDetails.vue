<template>
  <div style="text-transform: uppercase" class="row">
    <!-- Personal Information -->
    <PersonalInformation :applicant="applicant" /> 

    <!-- PERFORMANCE -->
    <!-- outstanding accomplishments -->
    <OutstandingAccomplishments :withControls="withControls" :applicant="applicant" />
    <PerformanceRating :applicant="applicant" :posting_id="posting_id" :withControls="withControls" :is-employee="applicant.role_name.includes('employee')" :latest_spms="latest_spms" />



    <!-- EDUCATION AND TRAINING -->
    <!-- Educational Background -->
    <EducationalBackground :educ="educ" :college_graduate_studies="college" :educationComputation="applicant.educationComputation" :plantilla="plantilla" :withControls="withControls" />
    <!-- learning and development -->
    <Learning :plantilla="plantilla" :lnds="lnds" :applicant="applicant" :withControls="withControls" />
    

    <!-- EXPERIENCE -->
    <WorkExperience :works="works" :plantilla="plantilla" :with-controls="withControls" :applicant="applicant" />
    


    <!-- CS Eligibility -->
    <Eligibility :eligs="eligs" :plantilla="plantilla" />

    <Box>
      <template #header>
        <div class="d-flex align-items-center gap-2">
          <i class="fa-solid fa-folder-open text-primary" />
          <span>Attached Application Documents</span>
        </div>
      </template>
      <div v-if="applicant.job_application && applicant.job_application[0]?.document?.length > 0" class="d-flex flex-wrap gap-2">
        <a 
          v-for="doc in applicant.job_application[0].document"
          :key="doc.id" 
          :href="doc.src"
          target="_blank"
          class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1 shadow-sm d-inline-flex align-items-center gap-2 text-decoration-none"
        >
          <i class="fa-solid fa-file-pdf" />
          <span>{{ doc.filename }}</span>
          <i class="fa-solid fa-up-right-from-square extra-small" />
        </a>
      </div>
      <div v-else class="text-muted text-center py-3 extra-small italic">
        <i class="fa-solid fa-folder-minus me-1" />No documents attached
      </div>
    </Box>
    <!-- Modal -->
    <Modal :modal-max-width="true" modal_id="viewAttachment" :modal-xl="true">
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
import PerformanceRating from '../Components/ApplicantDetails/PerformanceRating.vue'
import { ref } from 'vue'
import Box from './UI/Box.vue'

const props = defineProps({
  applicant: Object,
  plantilla: Object,
  latest_spms: Array,
  withControls: Boolean,
  posting_id: Number,
})


const {
  educational_background:educ,
  civil_service_eligibility:eligs,
  work_experience: works,
  learning_and_development: lnds,
  other_information: skills,
  college_graduate_studies: college,
} = props.applicant



</script>