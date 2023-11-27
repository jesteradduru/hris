<template>
  <b>APPLICANTS</b>
  <div class="d-flex gap-2 mb-3">
    <input id="group" type="checkbox" @click="onGrouped" />
    <label for="group">Group</label>
  </div>

  <div v-if="isGrouped">
    <b>Insider</b>
    <div>
      <ol v-if="insider.length !== 0">
        <li v-for="(item) in insider" :key="item.id">
          <Link
            :class="{
              'text-dark': applicant_details?.id === item.user.id,
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
          :class="{
            'text-dark': applicant_details?.id === item.user.id,
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
  

  
  <!-- if not grouped -->
  <div v-if="!isGrouped">
    <ol v-if="props.job_applications.length !== 0">
      <li v-for="(item) in props.job_applications" :key="item.id">
        <Link
          :class="{
            'text-dark': applicant_details?.id === item.user.id,
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
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import {ref, computed} from 'vue'
const props = defineProps({
  job_applications: Array,
  posting: Object,
  applicant_details: Object,
})

const isGrouped = ref(false)

const onGrouped = (e) => {
  isGrouped.value = e.target.checked
}

const insider = computed(() => {
  return props.job_applications.filter(application => application.user.role_name.includes('employee'))
})
const outsider = computed(() => {
  return props.job_applications.filter(application => application.user.role_name.includes('user'))
})

console.log(props.job_applications)
</script>