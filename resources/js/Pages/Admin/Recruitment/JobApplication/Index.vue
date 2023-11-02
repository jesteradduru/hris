<template>
  <Head title="Job Vacancies" />
  
  <AdminLayout fluid>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>Job Applications</h3>
    <div class="row">
      <div class="col-2">
        <ol>
          <li v-for="(item) in props.applications.data" :key="item.id">
            <Link
              :href="route('admin.recruitment.job_application.index', 
                           {applicant: item.user.id, job_posting: posting.id}
              )"
            >
              {{ item.user.name }}
            </Link>
          </li>
        </ol>
      </div>
      <div class="col-10">
        <ApplicantDetails :applicant="props.applicant" />
      </div>
    </div>
    <div
      v-if="!props.applications.data.length"
      class="text-center text-secondary"
    >
      No records
    </div>
    <Pagination
      v-if="props.applications.data.length"
      :links="props.applications.links"
    />
  </AdminLayout>
</template>
  
<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue'
import Filter from '@/Pages/Admin//Recruitment/JobPosting/Components/Filter.vue'
  
const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Recruitment',
  },
  {
    label: 'Job Vacancies',
    link: route('admin.recruitment.job_posting.index'),
  },
  {
    label: props.posting.position,
    link: route('admin.recruitment.job_posting.show', {job_posting: props.posting.id}),
  },
  {
    label: 'Applications',
  },
])
  
const props = defineProps({
  posting: Object,
  applications: Object,
  applicant: Object,
})
</script>
  