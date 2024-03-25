<template>
  <AuthenticatedLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>My Job Applications</h3>
    <hr />
    <div>
      <dl>
        <dt>
          Position
        </dt>
        <dd>
          {{ job_application.job_posting.plantilla.position }}
        </dd>
        <dt>
          Document/s Submitted
        </dt>
        <dd>
          <span v-for="file in job_application.document" :key="file.id"><a :href="file.src" target="_blank">{{ file.filename }}</a></span>
        </dd>
        <dt>
          History
        </dt>
        <dd>
          <ul>
            <div v-for="(result, index) in job_application.result.filter(res => res.result !== 'SELECTION')" :key="result.id">
              <li v-if="result.result" :class="{'text-success' : index === 0}">
                <div>
                  <!-- <b v-if="result.result === 'SELECTION'" class="text-bold">
                    {{ `You're application is undergoing final evaluation and deliberation.` }}
                  </b> -->
                  <b v-if="result.result === 'FOR_INTERVIEW'">
                    {{ `The interview is scheduled on ${getDateTime(result.results.schedule, result.results.start_time)}` }}
                  </b>
                  <b v-else-if="result.result === 'EXAM_PASSED'">
                    {{ `You've successfully passed the NEDA exam and will proceed to the next hiring process.` }}
                  </b>
                  <b v-else-if="result.result === 'EXAM_FAILED'">
                    {{ `You did not meet the passing criteria in the examination.` }}
                  </b>
                  <b v-else-if="result.result === 'FOR_EXAM'">
                    {{ `You are scheduled for examination on ${getDateTime(result.results.schedule, result.results.start_time)}` }}
                  </b>
                  <b v-else-if="result.result === 'UNLISTED'">
                    {{ `Your application did not make it to the shortlisting stage for further consideration.` }}
                  </b>
                  <b v-else-if="result.result === 'SHORTLISTED'">
                    {{ `You've been selected for the next stage of the hiring process.` }}
                  </b>
                  <b v-else-if="result.result === 'SHORTLISTING'">
                    {{ `Your application is under consideration for further evaluation.` }}
                  </b>
                  <b v-else-if="result.result === 'UNQUALIFIED'">
                    {{ ` You did not meet the necessary qualifications for the position.` }}
                  </b>
                  <b v-else-if="result.result === 'QUALIFIED'">
                    {{ `You have successfully met the qualification criteria and will undergo further evaluation.` }}
                  </b>
                  <!-- {{ result.result }} -->
                </div>
                <i class="text-muted">{{ moment( result.created_at ).format('MMM D, YYYY hh:mm a') }}</i>
              </li>
            </div>
            <div>
              <li :class="{'text-success' : job_application.result.length === 0}">
                <b>
                  You submitted your application.
                </b>
                <i class="d-block text-muted">{{ moment( job_application.created_at ).format('MMM D, YYYY hh:mm a') }}</i>
              </li>
            </div>
          </ul>
        </dd>
      </dl>
    </div>
  </AuthenticatedLayout>
</template>
  
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import moment from 'moment'
import {computed} from 'vue'
import BreadCrumbs from '@/Components/BreadCrumbs.vue'

const props = defineProps({
  job_application: Object,
})

const crumbs = computed(() => [
  {
    label: 'My Job Applications',
    link: route('job_application.index'),
  },
  {
    label: props.job_application.job_posting.plantilla.position,
  },
])

const getDateTime = (schedule, start_time) => {
  const date = moment(schedule).format('MMM D, Y')
  const time = moment(start_time, [moment.ISO_8601, 'HH:mm']).format('hh:mm A') 
  return `${date} ${time}`
}

</script>