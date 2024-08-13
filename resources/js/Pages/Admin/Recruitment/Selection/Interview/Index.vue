<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <b>VACANCIES</b>
    <JobVacancies :job_vacancies="job_vacancies" :posting="posting" />

    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex justify-content-between align-items-center gap-2">
        <h3>Final Deliberation</h3>
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
          NEXT (RANKING OF APPLICANT)
        </Link>
      </div>
    </div>
    <div class="row">
      <div class="col-2">
        <ApplicantsList :job_applications="props.qualified_applicants" :posting="posting" :applicant_details="applicant_details" />
      </div>
      <div class="col-10">
        <!-- pds nav -->
         
         
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
          <PsbPoints v-if="props.applicant_details" :applicant_details="applicant_details" />
          <ApplicantDetails v-if="props.applicant_details" :latest_spms="props.latest_spms" :applicant="props.applicant_details" :plantilla="posting.plantilla" :withControls="true" :posting_id="job_vacancy_status.job_posting_id" />
        </div>

        <div v-if="props.applicant_details" class="mt-2">
          <div class="mb-3">
            <label for="" class="form-label" />
            <textarea id="" v-model="form.notes" class="form-control" name="" rows="3" placeholder="Type notes here..." @keyup="onChangeNote" />
          </div>
        </div>
      </div>
    </div>
  </RecruitmentLayout>
</template>
  
<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import ApplicantDetails from '@/Pages/Admin/Recruitment/Selection/Components/ApplicantDetails.vue'
import {Head, Link, useForm, usePage} from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import Spinner from '@/Components/Spinner.vue'
import {debounce} from 'lodash'
import InputError from '@/Components/InputError.vue'
import JobVacancies from '../Components/JobVacancies.vue'
import PsbPoints from '../Components/ApplicantDetails/PsbPoints.vue'

const props = defineProps({
  job_vacancies: Array,
  posting: Object,
  applicant_details: Object,
  job_vacancy_status: Object,
  qualified_applicants: Array,
})
  
import { router } from '@inertiajs/vue3'
import ApplicantsList from '../Components/ApplicantsList.vue'
  
const loading = ref(false)
const activeTab = ref('personal')

const setActive = (e) => {
  e.preventDefault()
  const id = e.target.getAttribute('data-id')
  const target = document.getElementById(id)
  target.scrollIntoView()
  activeTab.value = id
}

const initNotes = computed(() => {
  const applicant = props.qualified_applicants?.filter(qapp => {
    return qapp.user_id === props.applicant_details?.id
  })
  return applicant[0]?.notes
})

const form = useForm({
  _method: 'put',
  notes: initNotes.value,
})

const onChangeNote = debounce(() => {
  const applicant = props.qualified_applicants.filter(qapp => {
    return qapp.user_id === props.applicant_details.id
  })

  form.post(route('admin.recruitment.application_result.updateNotes', {application_result: applicant[0].id}), {
    preserveScroll: true,
    preserveState: true,
  })
}, 1000)


router.on('start', () => {
  loading.value = true
})
router.on('finish', () => {
  loading.value = false
})



const onSaveScore = (application_id) => {

  scoreForm.post(route('admin.recruitment.application_score.store', {application_id: application_id}))
}
  
const confirm = () => window.confirm('Are you sure?')
</script>