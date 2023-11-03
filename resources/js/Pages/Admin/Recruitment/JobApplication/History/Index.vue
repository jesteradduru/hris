<template>
  <Head title="Selection" />
  <HistoryLayout :application_results="application_results.results" :job="application_results" />
</template>
  
<script setup>

import HistoryLayout from './HistoryLayout.vue'
import {Head} from '@inertiajs/vue3'

const props = defineProps({
  application_results: Array,
})


  
</script>