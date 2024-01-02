<template>
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
              <div v-if="selected == application.id || selected === null" class="d-flex gap-2 mb-3">
                <span v-if="application.latest_result.result === 'SELECTED'">APPOINTED</span>
                <span v-else>APPOINT</span>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>

import { Link} from '@inertiajs/vue3'
import { ref, computed } from 'vue'


const props = defineProps({
//   job_vacancies: Array,
  posting: Object,
//   applicant_details: Object,
//   job_vacancy_status: Object,
//   qualified_applicants: Array,
})

import { router } from '@inertiajs/vue3'

const loading = ref(false)

router.on('start', () => {
  loading.value = true
})

router.on('finish', () => {
  loading.value = false
})

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