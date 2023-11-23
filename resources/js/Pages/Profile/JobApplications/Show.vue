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
            <div v-for="(result, index) in job_application.result" :key="result.id">
              <li v-if="result.result" :class="{'text-success' : index === 0}">
                <div>
                  <span v-if="result.result === 'FOR_EXAM'">
                    {{ `Take the examination on ${getDateTime(result.results.schedule, result.results.start_time, result.results.end_time)}` }}
                  </span>
                  <span v-else-if="result.result === 'FOR_INTERVIEW'">
                    {{ `Attend the interview on ${getDateTime(result.results.schedule, result.results.start_time, result.results.end_time)}` }}
                  </span>
                  <span v-else>{{ result.result }}</span>
                </div>
                <i class="text-muted">{{ moment( result.created_at ).format('MMM D, YYYY hh:mm a') }}</i>
              </li>
            </div>
            <div>
              <li :class="{'text-success' : job_application.result.length === 0}">
                <div>
                  Application Submitted
                </div>
                <span class="text-muted">{{ moment( job_application.created_at ).format('MMM D, YYYY hh:mm a') }}</span>
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

const getDateTime = (schedule, start_time, end_time) => {
  const date = moment(schedule).format('MMM D, Y')
  const time = moment(start_time, [moment.ISO_8601, 'HH:mm']).format('hh:mm A') + ' - ' + moment(end_time, [moment.ISO_8601, 'HH:mm']).format('hh:mm A') 
  return `${date} ${time}`
}

</script>