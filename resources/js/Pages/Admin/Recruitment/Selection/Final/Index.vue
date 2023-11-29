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
            <tr class="">
              <td scope="row">Candidate A</td>
              <td scope="row">19.51</td>
              <td scope="row">1</td>
              <td>15.55</td>
              <td scope="row">2</td>
              <td>18.63</td>
              <td scope="row">1</td>
              <td>10.16</td>
              <td scope="row">1</td>
              <td>10.90</td>
              <td scope="row">2</td>
              <td class="text-info"><b>74.74</b></td>
              <td class="text-info"><b>1</b></td>
              <td>
                <button class="btn btn-success" @click="confirmSelect">SELECT</button>
              </td>
            </tr>
            <tr class="">
              <td scope="row">Candidate B</td>
              <td scope="row">18.54</td>
              <td scope="row">2</td>
              <td>17.30</td>
              <td scope="row">1</td>
              <td>18.50</td>
              <td scope="row">2</td>
              <td>7.32</td>
              <td scope="row">3</td>
              <td>9.67</td>
              <td scope="row">3</td>
              <td class="text-info"><b>71.33</b></td>
              <td class="text-info"><b>2</b></td>
              <td>
                <button class="btn btn-success" @click="confirmSelect">SELECT</button>
              </td>
            </tr>
            <tr class="">
              <td scope="row">Candidate C</td>
              <td scope="row">17.82</td>
              <td scope="row">3</td>
              <td>14.20</td>
              <td scope="row">3</td>
              <td>15.50</td>
              <td scope="row">3</td>
              <td>10.09</td>
              <td scope="row">2</td>
              <td>11.10</td>
              <td scope="row">1</td>
              <td class="text-info"><b>68.71</b></td>
              <td class="text-info"><b>3</b></td>
              <td>
                <button class="btn btn-success" @click="confirmSelect">SELECT</button>
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
const confirmSelect = () => window.confirm('Select this applicant for this position?')

</script>