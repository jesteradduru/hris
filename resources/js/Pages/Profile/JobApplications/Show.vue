<template>
  <AuthenticatedLayout>
    <div class="mb-4">
      <BreadCrumbs :crumbs="crumbs" />
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
      <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
          <h3 class="fw-bold text-dark mb-1">{{ job_application.job_posting.plantilla.position }}</h3>
          <p class="text-muted mb-0 small">Job Application Details</p>
        </div>
      </div>
      
      <div class="card-body p-4">
        <div class="row g-4">
          <div class="col-12 col-md-5">
            <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Submitted Documents</h5>
            <div class="d-flex flex-column gap-2">
              <a v-for="file in job_application.document" :key="file.id" :href="file.src" target="_blank" class="d-flex align-items-center p-2 rounded bg-light text-decoration-none border text-secondary" style="transition: 0.2s">
                <i class="fa-solid fa-file-pdf fs-4 text-danger me-3"></i>
                <span class="text-truncate" style="max-width: 250px;">{{ file.filename }}</span>
              </a>
            </div>
          </div>
          
          <div class="col-12 col-md-7">
            <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Application History</h5>
            <div class="position-relative ms-2">
              <!-- Application Journey List -->
              <div v-for="(result, index) in job_application.result.filter(res => res.result !== 'SELECTION')" :key="result.id" class="mb-4 position-relative border-start border-2 border-primary ps-4">
                <div class="position-absolute top-0 start-0 translate-middle p-2 bg-primary border border-white border-2 rounded-circle shadow-sm" style="width: 14px; height: 14px;"></div>
                <div class="p-3 bg-light rounded-3 border">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <span :class="['fw-bold', index === 0 ? 'text-primary' : 'text-dark']">
                      <template v-if="result.result === 'FOR_INTERVIEW'">Interview Scheduled</template>
                      <template v-else-if="result.result === 'EXAM_PASSED'">Exam Passed</template>
                      <template v-else-if="result.result === 'EXAM_FAILED'">Exam Failed</template>
                      <template v-else-if="result.result === 'FOR_EXAM'">Exam Scheduled</template>
                      <template v-else-if="result.result === 'UNLISTED'">Not Shortlisted</template>
                      <template v-else-if="result.result === 'SHORTLISTED'">Shortlisted</template>
                      <template v-else-if="result.result === 'SHORTLISTING'">Under Evaluation</template>
                      <template v-else-if="result.result === 'UNQUALIFIED'">Unqualified</template>
                      <template v-else-if="result.result === 'QUALIFIED'">Qualified</template>
                    </span>
                    <span class="badge bg-secondary-subtle text-secondary fw-normal"><i class="fa-regular fa-clock me-1"></i>{{ moment( result.created_at ).format('MMM D, YYYY hh:mm A') }}</span>
                  </div>
                  <p class="text-muted small mb-0 mt-2">
                    <template v-if="result.result === 'FOR_INTERVIEW'">The interview is scheduled on <b>{{ getDateTime(result.results.schedule, result.results.start_time) }}</b></template>
                    <template v-else-if="result.result === 'EXAM_PASSED'">You've successfully passed the entrance exam and will proceed to the next hiring process.</template>
                    <template v-else-if="result.result === 'EXAM_FAILED'">You did not meet the passing criteria in the examination.</template>
                    <template v-else-if="result.result === 'FOR_EXAM'">You are scheduled for examination on <b>{{ getDateTime(result.results.schedule, result.results.start_time) }}</b></template>
                    <template v-else-if="result.result === 'UNLISTED'">Your application did not make it to the shortlisting stage for further consideration.</template>
                    <template v-else-if="result.result === 'SHORTLISTED'">You've been selected for the next stage of the hiring process.</template>
                    <template v-else-if="result.result === 'SHORTLISTING'">Your application is under consideration for further evaluation.</template>
                    <template v-else-if="result.result === 'UNQUALIFIED'">You did not meet the necessary qualifications for the position.</template>
                    <template v-else-if="result.result === 'QUALIFIED'">You have successfully met the qualification criteria and will undergo further evaluation.</template>
                  </p>
                </div>
              </div>
              
              <!-- Initial Application Item -->
              <div class="mb-2 position-relative border-start border-2 border-primary ps-4">
                <div class="position-absolute top-0 start-0 translate-middle p-2 bg-primary border border-white border-2 rounded-circle shadow-sm" style="width: 14px; height: 14px;"></div>
                <div class="p-3 bg-light rounded-3 border">
                  <div class="d-flex justify-content-between align-items-center">
                    <span :class="['fw-bold', job_application.result.length === 0 ? 'text-primary' : 'text-dark']">Application Submitted</span>
                    <span class="badge bg-secondary-subtle text-secondary fw-normal"><i class="fa-regular fa-clock me-1"></i>{{ moment( job_application.created_at ).format('MMM D, YYYY hh:mm A') }}</span>
                  </div>
                  <p class="text-muted small mb-0 mt-2">You successfully submitted your application for this position.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <Link :onBefore="confirm" method="delete" as="button" :href="route('job_application.destroy', {job_application: job_application.id})" class="btn btn-danger btn-sm ">Recall Application</Link> -->
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

const confirm = () => window.confirm('Are you sure to cancel the job application.')

</script>