<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <b>VACANCIES</b>
    <JobVacancies :job_vacancies="job_vacancies" :posting="{ id : posting.id}" />

    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="d-flex justify-content-between align-items-center gap-2">
        <h3>
          Final Result
        </h3>
        
        <Spinner :processing="loading" :text="'Loading'" />
      </div>
      <Link as="button" method="put" :href="route('admin.recruitment.job_posting.archived', {job_posting: posting.id})" :onBefore="confirm" class="btn btn-primary"><i class="fa-solid fa-archive" />&nbsp; Archive</Link>
    </div>
    <div class="mb-3">
      <label for="" class="form-label">Rank by</label>
      <select
        id=""
        class="form-select form-select-md"
        name=""
        :value="columnToFilter"
        @change="onRank"
      >
        <option selected>Select one</option>
        <option value="performance">Performance</option>
        <option value="education">Education</option>
        <option value="experience">Experience</option>
        <option value="personality">Personality</option>
        <option value="potential">Potential</option>
        <option value="total">Total</option>
      </select>
    </div>
    <div>
      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th scope="col" rowspan="2">CANDIDATES</th>
              <th scope="col" colspan="2">Performance</th>
              <th scope="col" colspan="2">Education and Training</th>

              <th scope="col" colspan="2">Experience</th>
              <th scope="col" colspan="2">Personality Traits & Attributes</th>
              <th scope="col" colspan="2">Potential</th>
              <th scope="col" colspan="2">Total</th>
              <th scope="col" rowspan="2">Action</th>
            </tr>
            <tr>
              <th scope="col">SCORE</th>
              <th scope="col">RANK</th>
              <th scope="col">SCORE</th>
              <th scope="col">RANK</th>
              <th scope="col">SCORE</th>
              <th scope="col">RANK</th>
              <th scope="col">SCORE</th>
              <th scope="col">RANK</th>
              <th scope="col">SCORE</th>
              <th scope="col">RANK</th>
              <th scope="col">TOTAL(100%)</th>
              <th scope="col">RANK</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="application in applications" :key="application.id">
              <td scope="row"><b>{{ application.user.name }}</b></td>
              <td :class="{'table-success': columnToFilter == 'performance'}" scope="row"><b>{{ application.scores.performance }}</b></td>
              <td :class="{'table-success': columnToFilter == 'performance'}" scope="row"><b>{{ application.scores.performance_rank }}</b></td>
              <td :class="{'table-success': columnToFilter == 'education'}"><b>{{ application.scores.education }}</b></td>
              <td :class="{'table-success': columnToFilter == 'education'}" scope="row"><b>{{ application.scores.education_rank }}</b></td>
              <td :class="{'table-success': columnToFilter == 'experience'}"><b>{{ application.scores.experience }}</b></td>
              <td :class="{'table-success': columnToFilter == 'experience'}" scope="row"><b>{{ application.scores.experience_rank }}</b></td>
              <td :class="{'table-success': columnToFilter == 'personality'}"><b>{{ application.scores.personality }}</b></td>
              <td :class="{'table-success': columnToFilter == 'personality'}" scope="row"><b>{{ application.scores.personality_rank }}</b></td>
              <td :class="{'table-success': columnToFilter == 'potential'}"><b>{{ application.scores.potential }}</b></td>
              <td :class="{'table-success': columnToFilter == 'potential'}" scope="row"><b>{{ application.scores.potential_rank }}</b></td>
              <td :class="{'table-success': columnToFilter == 'total'}"><b>{{ application.scores.total }}</b></td>
              <td :class="{'table-success': columnToFilter == 'total'}"><b>{{ application.scores.total_rank }}</b></td>
              <td>
                <div class="d-flex gap-2 mb-3">
                  <Link 
                    as="button"
                    class="btn btn-success btn-sm"
                    :onBefore="confirmSelect"
                    method="post"
                    :href="route('admin.recruitment.application_result.store', {
                      result_id: props.job_vacancy_status.id,
                      result: application.latest_result.result === 'SELECTED' ? 'SELECTION' : 'SELECTED',
                      application_id: application.id,
                      user_id: application.user.id,
                    })"
                  >
                    <span v-if="application.latest_result.result === 'SELECTED'">APPOINTED</span>
                    <span v-else>APPOINT</span>
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
        <ApplicantDetails v-if="props.applicant_details" :latest_spms="latest_spms" :withControls="true" :applicant="props.applicant_details" :posting_id="job_vacancy_status.job_posting_id" />
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
const confirmSelect = () => window.confirm('Select this applicant for this position?')

const columnToFilter = ref('total')

const selected = computed(() => {
  const mappedApplications = props.posting.job_application.filter(application => {
    return application.latest_result.result === 'SELECTED'
  })
  return mappedApplications.length > 0 ? mappedApplications[0].id : null
})

const applications = computed(() => {
  const mappedApplications = props.posting.job_application.map(application => {
    return application
  })

  mappedApplications.sort((a, b) => b.scores[columnToFilter.value] - a.scores[columnToFilter.value])

  return mappedApplications
})

const onRank = (e) => {
  const column = e.target.value

  columnToFilter.value = column
  // router.get(route('admin.recruitment.selection.index'), {job_posting: props.posting.id, rank_by: column}, {
  //   preserveState: true,
  // })
}
</script>