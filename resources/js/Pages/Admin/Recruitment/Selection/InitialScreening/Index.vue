<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <!-- VACANCIES -->
    <b>VACANCIES</b>
    <JobVacancies :job_vacancies="job_vacancies" :posting="posting" />
    <!-- END OF VACANCIES -->

    <!-- TITLE -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex justify-content-between align-items-center gap-2">
        <h3>Initial Screening</h3>
        <Spinner :processing="loading" :text="'Loading'" />
      </div>
      <div>
        <Link 
          as="button"
          class="btn btn-primary"
          :onBefore="confirm"
          method="put"
          :href="route('admin.recruitment.application_result.publish', {
            results: props.job_vacancy_status.id,
          })"
        >
          NEXT (SHORTLISTING)
        </Link>
      </div>
    </div>

    <!-- APPLICANT DETAILS -->
    <div class="row">
      <div class="col-2">
        <ApplicantsList :job_applications="props.job_applications" :posting="posting" :applicant_details="applicant_details" />
      </div>
      <div class="col-10">
        <div
          class="nav nav-tabs nav-fill"
        >
          <a type="button" class="nav-link" :class="{active: activeTab == 'personal'}" data-id="personal" aria-current="page" @click="setActive">Personal</a>
          <a type="button" class="nav-link" :class="{active: activeTab == 'out-accomp'}" data-id="out-accomp" aria-current="page" @click="setActive">Awards</a>
          <a type="button" class="nav-link" :class="{active: activeTab == 'performance'}" data-id="performance" aria-current="page" @click="setActive">Performance</a>
          <a type="button" class="nav-link" :class="{active: activeTab == 'educ'}" data-id="educ" aria-current="page" @click="setActive">Education</a>
          <a type="button" class="nav-link" :class="{active: activeTab == 'lnd'}" data-id="lnd" aria-current="page" @click="setActive">Trainings</a>
          <a type="button" class="nav-link" :class="{active: activeTab == 'work'}" data-id="work" aria-current="page" @click="setActive">Experience</a>
          <a type="button" class="nav-link" :class="{active: activeTab == 'elig'}" data-id="elig" aria-current="page" @click="setActive">Eligibility</a>
        </div>
         
        <div class="container-fluid" style="height: 80vh; overflow-y: scroll;">
          <div v-if="props.applicant_details" class="d-flex gap-2 my-3">
            <Link 
              as="button"
              class="btn btn-success btn-sm"
              :onBefore="confirm"
              method="post"
              :href="route('admin.recruitment.application_result.store', {
                result_id: props.job_vacancy_status.id,
                result: 'QUALIFIED',
                application_id: props.applicant_details.job_application[0].id,
                user_id: props.applicant_details.id,
              })"
            >
              Qualified
            </Link>
            <Link 
              as="button"
              class="btn btn-warning btn-sm"
              :onBefore="confirm"
              method="post"
              :href="route('admin.recruitment.application_result.store', {
                result_id: props.job_vacancy_status.id,
                result: 'UNQUALIFIED',
                application_id: props.applicant_details.job_application[0].id,
                user_id: props.applicant_details.id,
              })"
            >
              Unqualified
            </Link>
          </div>
          <ApplicantDetails 
            v-if="props.applicant_details"
            :latest_spms="props.latest_spms" 
            :applicant="props.applicant_details" 
            :plantilla="posting.plantilla" 
            :posting_id="job_vacancy_status.job_posting_id"
          />
        </div>
      </div>
    </div>
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import ApplicantDetails from '@/Pages/Admin/Recruitment/Selection/Components/ApplicantDetails.vue'
import {Head, Link} from '@inertiajs/vue3'
import { ref } from 'vue'
import Spinner from '@/Components/Spinner.vue'
import JobVacancies from '../Components/JobVacancies.vue'


const props = defineProps({
  job_vacancies: Array,
  posting: Object,
  job_applications: Array,
  applicant_details: Object,
  job_vacancy_status: Object,
})



import { router } from '@inertiajs/vue3'
import ApplicantsList from '../Components/ApplicantsList.vue'

const loading = ref(false)
router.on('start', () => {
  loading.value = true
})
router.on('finish', () => {
  loading.value = false
})

const confirm = () => window.confirm('Are you sure?')

const activeTab = ref('personal')

const setActive = (e) => {
  e.preventDefault()
  const id = e.target.getAttribute('data-id')
  const target = document.getElementById(id)
  target.scrollIntoView()
  activeTab.value = id
}
</script>