<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <b>VACANCIES</b>
    <ul>
      <li v-for="item in props.job_vacancies" :key="item.id">
        <Link
          :href="route('admin.recruitment.selection.index', 
                       {job_posting: item.id}
          )"
          :class="{'text-dark': item.id == posting_id}"
        >
          {{ item.plantilla.position }}
        </Link>
      </li>
    </ul>
  
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
        <b>APPLICANTS</b>
        <ol v-if="props.qualified_applicants.length !== 0">
          <li v-for="(item) in props.qualified_applicants" :key="item.id">
            <Link
              :class="{
                'text-dark': applicant_details?.id === item.user.id,
              }" :href="route('admin.recruitment.selection.index', {job_posting: posting_id, applicant: item.user.id})"
            >
              {{ item.user.name }}
            </Link>
            <span v-if="item.result === 'SELECTED'" class="badge rounded-pill text-bg-success">
              <i class="fa-solid fa-check" />
            </span>
          </li>
        </ol>
        <small v-else class="text-muted d-block">
          No Applications
        </small>
      </div>
      <div class="col-9">
        <div v-if="props.applicant_details" class="d-flex gap-2 mb-3">
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
        </div>
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

const props = defineProps({
  job_vacancies: Array,
  posting_id: String,
  applicant_details: Object,
  job_vacancy_status: Object,
  qualified_applicants: Array,
})
  
import { router } from '@inertiajs/vue3'
  
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
  
const confirm = () => window.confirm('Are you sure?')
</script>