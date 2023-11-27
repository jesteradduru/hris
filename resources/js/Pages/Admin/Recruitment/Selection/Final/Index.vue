<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <b>VACANCIES</b>
    <JobVacancies :job_vacancies="job_vacancies" :posting="{ id : posting[0].job_posting_id}" />

    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex justify-content-between align-items-center gap-2">
        <h3>
          Final Result
        </h3>
        <Spinner :processing="loading" :text="'Loading'" />
      </div>
      <Link as="button" method="put" :href="route('admin.recruitment.job_posting.archived', {job_posting: posting[0].job_posting_id})" :onBefore="confirm" class="btn btn-primary"><i class="fa-solid fa-archive" />&nbsp; Archive</Link>
    </div>
    <div>
      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th scope="col">Rank</th>
              <th scope="col">Applicant</th>
              <th scope="col">Performance</th>
              <th scope="col">Education and Training</th>
              <th scope="col">Experience</th>
              <th scope="col">Personality Traits & Attributes</th>
              <th scope="col">Potential</th>
              <th scope="col">Total</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(application, index) in posting" :key="application.id" class="">
              <td scope="row">{{ index + 1 }}</td>
              <td scope="row">{{ application.job_application[0].user.name }}</td>
              <td>{{ application.performance }}</td>
              <td>{{ application.education }}</td>
              <td>{{ application.experience }}</td>
              <td>{{ application.personality }}</td>
              <td>{{ application.potential }}</td>
              <td>{{ application.total }}</td>
              <td>
                <div class="d-flex gap-2 mb-3">
                  <Link 
                    as="button"
                    class="btn btn-success btn-sm"
                    :onBefore="confirm"
                    method="post"
                    :href="route('admin.recruitment.application_result.store', {
                      result_id: props.job_vacancy_status.id,
                      result: 'SELECTED',
                      application_id: application.job_application_id,
                      user_id: application.job_application[0].user.id,
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
                      application_id: application.job_application_id,
                      user_id: application.job_application[0].user.id,
                    })"
                  >
                    DESELECT
                  </Link>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- <div class="row">
      <div class="col-3">
        <b>SELECTED </b>
        <ApplicantsList :job_applications="props.qualified_applicants" :posting="posting" :applicant_details="applicant_details" />
      </div>
      <div class="col-9">
        <ApplicantDetails v-if="props.applicant_details" :applicant="props.applicant_details" />
      </div>
    </div> -->
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import ApplicantDetails from '@/Pages/Admin/Recruitment/Selection/Components/ApplicantDetails.vue'
import {Head, Link} from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import Spinner from '@/Components/Spinner.vue'
import JobVacancies from '../Components/JobVacancies.vue'

const props = defineProps({
  job_vacancies: Array,
  posting: Object,
  applicant_details: Object,
  job_vacancy_status: Object,
  qualified_applicants: Array,
})

import { router } from '@inertiajs/vue3'
import moment from 'moment'
import ApplicantsList from '../Components/ApplicantsList.vue'

const loading = ref(false)

router.on('start', () => {
  loading.value = true
})

router.on('finish', () => {
  loading.value = false
})

const confirm = () => window.confirm('Archive this job vacancy?')

</script>