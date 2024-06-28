<template>
  <div id="job_vacancies">
    <div v-for="item in props.job_vacancies" :key="item.id" :class="{'active': item.id == posting?.id}">
      <Link
        :href="route('admin.recruitment.selection.index', 
                     {job_posting: item.id}
        )"
      >
        {{ `${item.plantilla.position}` }}
      </Link>
    </div>
  </div>
  <hr />
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
const props = defineProps({
  posting: Object,
  job_vacancies: Array,
})
</script>
