<template>
  <Head title="Selection" />
  <RecruitmentLayout>
    <b>VACANCIES</b>
    <ul>
      <li v-for="item in props.posting" :key="item.id">
        <Link
          :href="route('admin.recruitment.selection.index', 
                       {job_posting: item.id}
          )"
          :class="{'text-dark': item.id == posting_id}"
        >
          {{ item.position }}
        </Link>
      </li>
    </ul>

    <hr />

    <div class="row">
      <div class="col-3">
        <b>APPLICANTS</b>
        <ol v-if="application.length !== 0">
          <li v-for="(item) in props.application" :key="item.id">
            <Link :class="{'text-dark': applicant?.id}" :href="route('admin.recruitment.selection.index', {job_posting: posting_id, applicant: item.user.id})">
              {{ item.user.name }}
            </Link>
          </li>
        </ol>
        <small v-else class="text-muted d-block">
          No Applications
        </small>
      </div>
      <div class="col-9">
        <ApplicantDetails v-if="applicant" :applicant="props.applicant" />
      </div>
    </div>
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import ApplicantDetails from '@/Pages/Admin/Recruitment/Selection/Components/ApplicantDetails.vue'
import {Head, Link, usePage} from '@inertiajs/vue3'

const props = defineProps({
  posting: Array,
  application: Array,
  posting_id: String,
  applicant: Object,
})

</script>