<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <b>VACANCIES</b>
    <JobVacancies :job_vacancies="job_vacancies" :posting="posting" />
  
    <hr />
  
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
          PUBLISH
        </Link>
      </div>
    </div>
    <div class="row">
      <div class="col-3">
        <ApplicantsList :job_applications="props.qualified_applicants" :posting="posting" :applicant_details="applicant_details" />
      </div>
      <div class="col-9">
        <form class="table-responsive" @submit.prevent="() => onSaveScore(applicant_details.job_application[0]?.id)">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th scope="col">Performance</th>
                <th scope="col">Education and Training</th>
                <th scope="col">Experience</th>
                <th scope="col">Personality Traits & Attributes</th>
                <th scope="col">Potential</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr class="">
                <td scope="row"><input v-model="scoreForm.performance" type="text" style="width: 100%;" /><InputError :message="scoreForm.errors.performance" /></td>
                <td><input v-model="scoreForm.education" type="text" style="width: 100%;" /><InputError :message="scoreForm.errors.education" /></td>
                <td><input v-model="scoreForm.experience" type="text" style="width: 100%;" /><InputError :message="scoreForm.errors.experience" /></td>
                <td><input v-model="scoreForm.personality" type="text" style="width: 100%;" /><InputError :message="scoreForm.errors.personality" /></td>
                <td><input v-model="scoreForm.potential" type="text" style="width: 100%;" /><InputError :message="scoreForm.errors.potential" /></td>
                <td class="text-info"><b>{{ props.applicant_details?.job_application[0]?.score?.total }}</b></td>
              </tr>
            </tbody>
            <button :disabled="!scoreForm.isDirty" type="submit" class="btn btn-success btn-sm mt-2">Save Score</button>
          </table>
        </form>

        <!-- <div v-if="props.applicant_details" class="d-flex gap-2 mb-3">
          <Link 
            as="button"
            class="btn btn-success btn-sm"
            :onBefore="confirm"
            method="post"
            :href="route('admin.recruitment.application_result.store', {
              result_id: props.job_vacancy_status.id,
              result: 'SELECTED',
              application_id: props.applicant_details.job_application[0].id,
              user_id: props.applicant_details.id,
            })"
          >
            SELECT
          </Link>
          <Link 
            as="button"
            class="btn btn-danger btn-sm"
            :onBefore="confirm"
            method="post"
            :href="route('admin.recruitment.application_result.store', {
              result_id: props.job_vacancy_status.id,
              result: null,
              application_id: props.applicant_details.job_application[0].id,
              user_id: props.applicant_details.id,
            })"
          >
            DESELECT
          </Link>
        </div> -->
        <ApplicantDetails v-if="props.applicant_details" :applicant="props.applicant_details" />

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


const scoreForm =  useForm({
  performance: props.applicant_details ? props.applicant_details.job_application[0].score.performance : null,
  education: props.applicant_details ? props.applicant_details.job_application[0].score.education : null,
  experience: props.applicant_details ? props.applicant_details.job_application[0].score.experience : null,
  personality: props.applicant_details ? props.applicant_details.job_application[0].score.personality : null,
  potential: props.applicant_details ? props.applicant_details.job_application[0].score.potential : null,
})

const onSaveScore = (application_id) => {

  scoreForm.post(route('admin.recruitment.application_score.store', {application_id: application_id}))
}
  
const confirm = () => window.confirm('Are you sure?')
</script>