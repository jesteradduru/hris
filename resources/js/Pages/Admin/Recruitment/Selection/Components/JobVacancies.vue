<template>
  <div class="vacancies-section mb-4">
    <div class="d-flex align-items-center gap-2 mb-2 text-uppercase text-muted fw-bold small">
      <i class="fa-solid fa-briefcase text-primary" />
      <span>Select Job Vacancy</span>
    </div>
    
    <div v-if="props.job_vacancies && props.job_vacancies.length > 0" class="d-flex flex-wrap gap-2">
      <div 
        v-for="item in props.job_vacancies" 
        :key="item.id"
      >
        <Link
          :href="route('admin.recruitment.selection.index', { job_posting: item.id })"
          class="btn text-start rounded-3 px-3 py-2 text-decoration-none transition-all d-flex align-items-center gap-2 border"
          :class="item.id == posting?.id ? 'bg-primary text-white shadow-sm border-primary fw-bold' : 'bg-white text-dark hover-shadow-sm border-light-subtle'"
        >
          <i class="fa-solid fa-circle-dot small" :class="item.id == posting?.id ? 'text-white' : 'text-primary'" />
          <span>{{ item.plantilla.position }}</span>
          <span 
            v-if="item.item_number" 
            class="badge rounded-pill ms-1"
            :class="item.id == posting?.id ? 'bg-white text-primary' : 'bg-light text-secondary border'"
          >
            {{ item.item_number }}
          </span>
        </Link>
      </div>
    </div>
    <div v-else class="text-muted fst-italic p-3 bg-light rounded-3 text-center border">
      <i class="fa-solid fa-folder-open me-2" />No job vacancies available.
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
const props = defineProps({
  posting: Object,
  job_vacancies: Array,
})
</script>
