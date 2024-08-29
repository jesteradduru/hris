<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <b>VACANCIES</b>
    <JobVacancies :job_vacancies="job_vacancies" :posting="posting" />

    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex justify-content-between align-items-center gap-2">
        <h3>NEDA Exam</h3>
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
          NEXT (INTERVIEW SCHEDULE)
        </Link>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="mb-3">
          <label for="" class="form-label">Date of Exam</label>
          <input
            id=""
            :value="moment(props.job_vacancy_status.schedule).format('Y-MM-DD')" type="date" class="form-control" name="" aria-describedby="helpId" placeholder="" @input="setSchedule"
          />
        </div>
      </div>
      <div class="col-3">
        <ApplicantsList :job_applications="props.qualified_applicants" :posting="posting" :applicant_details="applicant_details" />
      </div>
      <div class="col-9">
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

        <div v-if="props.applicant_details" class="d-flex gap-2 mb-3 mt-3">
          <Link 
            as="button"
            class="btn btn-success btn-sm"
            :onBefore="confirm"
            method="post"
            :href="route('admin.recruitment.application_result.store', {
              result_id: props.job_vacancy_status.id,
              result: 'EXAM_PASSED',
              application_id: props.applicant_details.job_application[0].id,
              user_id: props.applicant_details.id,
            })"
          >
            PASSED
          </Link>
          <Link 
            as="button"
            class="btn btn-warning btn-sm"
            :onBefore="confirm"
            method="post"
            :href="route('admin.recruitment.application_result.store', {
              result_id: props.job_vacancy_status.id,
              result: 'EXAM_FAILED',
              application_id: props.applicant_details.job_application[0].id,
              user_id: props.applicant_details.id,
            })"
          >
            FAILED
          </Link>
        </div>
         
        <div class="container-fluid" style="height: 80vh; overflow-y: scroll;">
          <PsbPoints v-if="props.applicant_details" :applicant_details="applicant_details" />
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
import {Head, Link,  router} from '@inertiajs/vue3'
import { ref, computed} from 'vue'
import Spinner from '@/Components/Spinner.vue'
import JobVacancies from '../Components/JobVacancies.vue'
import {debounce} from 'lodash'
import moment from 'moment'


const props = defineProps({
  job_vacancies: Array,
  posting: Object,
  applicant_details: Object,
  job_vacancy_status: Object,
  qualified_applicants: Array,
})


const setSchedule = debounce((e) => {
  const date = e.target.value
  if(window.confirm('Are you sure?')){
    router.put(route('admin.recruitment.neda_exam.set', {result: props.job_vacancy_status.id, schedule: date}))
  }
}, 200)


import ApplicantsList from '../Components/ApplicantsList.vue'

const loading = ref(false)
const examSchedule = computed(() => moment(props.job_vacancy_status.schedule).format('yyyy-MM-dd'))


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