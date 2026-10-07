<template>
  <Head title="Application" />
  <AuthenticatedLayout>
    <div class="container py-4">
      <BreadCrumbs :crumbs="crumbs" class="mb-4" />
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
          <slot />
        </div>
      </div>
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
    label: props.job_posting.plantilla.position,
    link: route('recruitment.job_posting.show', {
      job_posting: props.job_posting.id,
    }),
  },
  {
    label: 'Application',
  },
])
</script>
