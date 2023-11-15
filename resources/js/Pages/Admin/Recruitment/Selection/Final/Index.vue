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
        <h3>
          Final Result
        </h3>
        <Spinner :processing="loading" :text="'Loading'" />
      </div>
      <Link as="button" method="put" :href="route('admin.recruitment.job_posting.archived', {job_posting: props.posting_id})" :onBefore="confirm" class="btn btn-primary"><i class="fa-solid fa-archive" />&nbsp; Archive</Link>
    </div>
    <div class="row">
      <div class="col-3">
        <b>SELECTED APPLICANT</b>
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


import { router } from '@inertiajs/vue3'
import moment from 'moment'

const loading = ref(false)

router.on('start', () => {
  loading.value = true
})

router.on('finish', () => {
  loading.value = false
})

const confirm = () => window.confirm('Archive this job vacancy?')

</script>