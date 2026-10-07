<template>
  <AuthenticatedLayout>
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h3 class="fw-bold text-dark mb-1">My Job Applications</h3>
        <p class="text-muted mb-0 small">Track the status of your applications.</p>
      </div>
    </div>
    
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0 text-sm">
            <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem;">
              <tr>
                <th class="ps-4">Position</th>
                <!-- <th scope="col">Status</th> -->
                <th>Submitted Documents</th>
                <th class="pe-4 text-center">Action</th>
              </tr>
            </thead>
            <tbody v-if="job_applications && job_applications.length">
              <tr v-for="application in job_applications" :key="application.id">
                <td class="ps-4 fw-medium text-dark">{{ application.job_posting.plantilla.position }}</td>
                <!-- <td>Pending</td> -->
                <td>
                  <div class="d-flex flex-wrap gap-2">
                    <a v-for="file in application.document" :key="file.id" :href="file.src" target="_blank" class="badge bg-light text-primary text-decoration-none border">
                      <i class="fa-solid fa-file-pdf me-1"></i>{{ file.filename }}
                    </a>
                  </div>
                </td>
                <td class="pe-4 text-center">
                  <div class="d-flex gap-2 justify-content-center">
                    <Link :href="route('job_application.show', {job_application: application.id})" class="btn btn-light btn-sm text-primary rounded-circle" title="View Details">
                      <i class="fa-solid fa-eye"></i>
                    </Link>
                    <Link method="delete" as="button" :href="route('job_application.destroy', {job_application: application.id})" class="btn btn-light btn-sm text-danger rounded-circle" title="Withdraw Application">
                      <i class="fa-solid fa-trash"></i>
                    </Link>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr>
                <td colspan="3" class="text-center py-5 text-muted fst-italic">
                  <i class="fa-solid fa-folder-open fs-3 d-block mb-2 text-black-50"></i>
                  You haven't submitted any job applications yet.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import {computed} from 'vue'

const crumbs = computed(() => [
  {
    label: 'Applications',
  },
])

const props = defineProps({
  job_applications: Array,
})
</script>