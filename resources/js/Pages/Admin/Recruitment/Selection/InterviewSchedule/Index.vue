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
          {{ item.position }}
        </Link>
      </li>
    </ul>

    <hr />

    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex justify-content-between align-items-center gap-2">
        <h3>
          Schedule Interview
          <span v-if="scheduleForm.schedule">on {{ moment(scheduleForm.schedule).format('MMM D, Y') }}</span>
        </h3>
        <Spinner :processing="loading" :text="'Loading'" />
      </div>
      <div class="d-flex gap-2">
        <div>
          <Link 
            as="button"
            class="btn btn-primary"
            :onBefore="confirm"
            method="put"
            :href="route('admin.recruitment.application_result.publish', {
              results: props.job_vacancy_status.id,
            })"
            :disabled="!scheduleForm.wasSuccessful"
          >
            PUBLISH
          </Link>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="row mb-3">
          <div class="col-4">
            <div class="mb-3">
              <label for="" class="form-label">DATE</label>
              <input
                id=""
                v-model="scheduleForm.schedule" type="date" class="form-control" name="" aria-describedby="helpId"
                placeholder=""
              />
              <InputError :message="scheduleForm.errors.schedule" />
            </div>
          </div>
          <div class="col-4">
            <div class="mb-3">
              <label for="" class="form-label">FROM</label>
              <input
                id=""
                v-model="scheduleForm.start_time" type="time" class="form-control" name="" aria-describedby="helpId"
                placeholder=""
              />
              <InputError :message="scheduleForm.errors.start_time" />
            </div>
          </div>
          <div class="col-4">
            <div class="mb-3">
              <label for="" class="form-label">TO</label>
              <input
                id=""
                v-model="scheduleForm.end_time" type="time" class="form-control" name="" aria-describedby="helpId"
                placeholder=""
              />
              <InputError :message="scheduleForm.errors.end_time" />
            </div>
          </div>
          <div class="col-3">
            <button class="btn btn-primary btn-sm" @click="setSchedule">Set Schedule</button>
          </div>
        </div>
      </div>
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
          </li>
        </ol>
        <small v-else class="text-muted d-block">
          No Applications
        </small>
      </div>
      <div class="col-9">
        <ApplicantDetails v-if="props.applicant_details" :applicant="props.applicant_details" />
      </div>
    </div>
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import ApplicantDetails from '@/Pages/Admin/Recruitment/Selection/Components/ApplicantDetails.vue'
import {Head, Link, useForm, usePage} from '@inertiajs/vue3'
import { ref } from 'vue'
import Spinner from '@/Components/Spinner.vue'
import {debounce} from 'lodash'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  job_vacancies: Array,
  posting_id: String,
  applicant_details: Object,
  job_vacancy_status: Object,
  qualified_applicants: Array,
})

const scheduleForm = useForm({
  _method: 'put',
  schedule: props.job_vacancy_status.schedule,
  start_time: props.job_vacancy_status.start_time,
  end_time: props.job_vacancy_status.end_time,
})

const setSchedule = debounce(() => {
  if(window.confirm('Set this schedule for the NEDA exam?')){
    scheduleForm.post(route('admin.recruitment.neda_exam.set', {result: props.job_vacancy_status.id}))
  }
}, 200)


import { router } from '@inertiajs/vue3'
import moment from 'moment'

const loading = ref(false)

router.on('start', () => {
  loading.value = true
})

router.on('finish', () => {
  loading.value = false
})

const confirm = () => window.confirm('Are you sure?')
</script>