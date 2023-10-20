<template>
  <Head title="L&D Competency Gap" />
  <LndLayout>
    <Link :href="route('admin.competency_gap.create')" class="btn btn-primary">Create monitoring report</Link>

    <div class="row mt-3">
      <div v-for="report in reports" :key="report.id" class="col-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ `CY ${report.year} Learning and Development Program Monitoring` }}</h5>
            <p class="card-text d-flex justify-content-end">
              <Link :href="route('admin.competency_gap.edit', {competency_gap: report.id})" class="btn btn-success btn-sm"><i class="fa-solid fa-pen" /></Link>
            </p>
          </div>
        </div>
      </div>
    </div>
  </LndLayout>
</template>
  
<script setup>
import {Head} from '@inertiajs/vue3'
import LndLayout from '@/Pages/Admin/L&D/Layout/LndLayout.vue'
import {Link} from '@inertiajs/vue3'

const props = defineProps({
  reports: Array,
})
</script>