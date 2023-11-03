<template>
  <Head title="Job Vacancies" />
  
  <RecruitmentLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <div style="text-transform: capitalize;">
      <h4>{{ `${user.personal_information.first_name} ${user.personal_information.middle_name} ${user.personal_information.surname}` }}</h4>
      <hr />
      <h5>Attachments</h5>
      <div class="d-flex flex-column gap-3">
        <a v-for="doc in props.application.document" :key="doc.id" :href="doc.src" target="_blank">{{ doc.filename }}</a>
      </div>
    </div>
  </RecruitmentLayout>
</template>

<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import RecruitmentLayout from '../Layout/RecruitmentLayout.vue'

const props = defineProps({
  application: Object,
})

const {user} = props.application

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
    label: props.application.job_posting.position,
    link: route('admin.recruitment.job_posting.show', {job_posting: props.application.job_posting.id}),
  },
  {
    label: 'Applications',
    link: route('admin.recruitment.job_application.index', {
      job_posting: props.application.job_posting.id,
    }),
  },
  {
    label: props.application.user.name,
  },
])
</script>