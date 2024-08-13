<template>
  <div title="Applicants" class="card shadow">
    <div class="applicant-list cad-body">
      <div class="text-uppercase">
        <b>Insider</b>
        <div>
          <ol v-if="insider.length !== 0">
            <li v-for="(item) in insider" :key="item.id">
              <Link
                :preserve-state="false"
                :class="{
                  'active': applicant_details?.id === item.user.id,
                }" :href="route('admin.recruitment.selection.index', {applicant: item.user.id, job_posting: posting.id})"
              >
                {{ item.user.name }}
              </Link>
              <div v-if="item.result">
                <span v-if="item.result.length > 0 && item.result[0].result ==='UNQUALIFIED'" class="badge rounded-pill text-bg-warning">
                  <i class="fa-solid fa-x " />
                </span>
                <span v-if="item.result.length > 0 && item.result[0].result ==='QUALIFIED'" class="badge rounded-pill text-bg-success">
                  <i class="fa-solid fa-check" />
                </span>
                <span v-if="item.result === 'EXAM_FAILED' || item.result === 'UNLISTED'" class="badge rounded-pill text-bg-warning">
                  <i class="fa-solid fa-x " />
                </span>
                <span v-if="item.result === 'EXAM_PASSED' || item.result === 'SELECTED' || item.result === 'SHORTLISTED'" class="badge rounded-pill text-bg-success">
                  <i class="fa-solid fa-check" />
                </span>
              </div>
            </li>
          </ol>
          <small v-else class="text-muted d-block">
            No Applications
          </small>
        </div>


        <b>Outsider</b>
        <ol v-if="outsider.length !== 0">
          <li v-for="(item) in outsider" :key="item.id">
            <Link
              :preserve-state="false"
              :class="{
                'active': applicant_details?.id === item.user.id,
              }" :href="route('admin.recruitment.selection.index', {applicant: item.user.id, job_posting: posting.id})"
            >
              {{ item.user.name }}
            </Link>
            <div v-if="item.result">
              <span v-if="item.result.length > 0 && item.result[0].result ==='UNQUALIFIED'" class="badge rounded-pill text-bg-warning">
                <i class="fa-solid fa-x " />
              </span>
              <span v-if="item.result.length > 0 && item.result[0].result ==='QUALIFIED'" class="badge rounded-pill text-bg-success">
                <i class="fa-solid fa-check" />
              </span>
              <span v-if="item.result === 'EXAM_FAILED' || item.result === 'UNLISTED'" class="badge rounded-pill text-bg-warning">
                <i class="fa-solid fa-x " />
              </span>
              <span v-if="item.result === 'EXAM_PASSED' || item.result === 'SELECTED' || item.result === 'SHORTLISTED'" class="badge rounded-pill text-bg-success">
                <i class="fa-solid fa-check" />
              </span>
            </div>
          </li>
        </ol>
        <small v-else class="text-muted d-block">
          No Applications
        </small>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import {computed} from 'vue'

const props = defineProps({
  job_applications: Array,
  posting: Object,
  applicant_details: Object,
})

const insider = computed(() => {
  return props.job_applications.filter(application => application.user.role_name.includes('employee'))
})
const outsider = computed(() => {
  return props.job_applications.filter(application => application.user.role_name.includes('user'))
})

</script>