<template>
  <Head title="Application" />
  <AuthenticatedLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <div class="container rounded p-4 bg-light border">
      <slot />
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { computed } from 'vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps({
  job_posting: Object,
  percent: String,
})

const crumbs = computed(() => [
  {
    label: 'Dashboard',
    link: route('dashboard'),
  },
  {
    label: 'Job Vacancies',
    link: route('recruitment.job_posting.index'),
  },
  {
    label: props.job_posting.position,
    link: route('recruitment.job_posting.show', {
      job_posting: props.job_posting.id,
    }),
  },
  {
    label: 'Application',
  },
])
</script>
