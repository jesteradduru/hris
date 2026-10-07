<template>
  <Head title="Admin Panel" />
  <AdminLayout>
    <div class="container-fluid py-4">
      <!-- Welcome Header -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card shadow-sm border-0 rounded-4 bg-primary text-white p-4 position-relative overflow-hidden">
            <div class="position-absolute opacity-10" style="top: -20px; right: 0; width: 200px; height: 200px; background: radial-gradient(circle, white, transparent); border-radius: 50%;"></div>
            <h3 class="fw-bold mb-1">Welcome to Admin Dashboard</h3>
            <p class="mb-0 text-white-50">Manage the Human Resource Information System efficiently.</p>
          </div>
        </div>
      </div>

      <div class="row g-4 mb-4">
        <!-- Quick Links -->
        <div class="col-12 col-md-6">
          <Link :href="route('admin.recruitment.job_posting.index')" class="text-decoration-none">
            <div class="card shadow-sm border-0 rounded-4 h-100 hover-shadow transition-all">
              <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 65px; height: 65px;">
                  <i class="fa-solid fa-briefcase fs-3"></i>
                </div>
                <div>
                  <h5 class="fw-bold text-dark mb-1">Job Vacancies</h5>
                  <p class="text-muted small mb-0">Manage job postings, create new vacancies, and monitor their statuses.</p>
                </div>
              </div>
            </div>
          </Link>
        </div>

        <div class="col-12 col-md-6">
          <Link :href="route('admin.recruitment.selection.index')" class="text-decoration-none">
            <div class="card shadow-sm border-0 rounded-4 h-100 hover-shadow transition-all">
              <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 65px; height: 65px;">
                  <i class="fa-solid fa-users fs-3"></i>
                </div>
                <div>
                  <h5 class="fw-bold text-dark mb-1">Applicant Selection</h5>
                  <p class="text-muted small mb-0">Review applications, screen candidates, and track recruitment phases.</p>
                </div>
              </div>
            </div>
          </Link>
        </div>
      </div>

      <div class="row g-4">
        <!-- Metrics Summary -->
        <div class="col-12 col-lg-4">
          <div class="card shadow-sm border-0 rounded-4 mb-4 h-100">
            <div class="card-body p-4">
              <div class="d-flex align-items-center mb-4">
                <div class="bg-info bg-opacity-10 text-info rounded-3 p-2 me-3">
                  <i class="fa-solid fa-chart-line fs-5"></i>
                </div>
                <h6 class="fw-bold text-dark mb-0">Quick Metrics</h6>
              </div>
              
              <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3 mb-3 border">
                <span class="text-secondary fw-medium">Unfilled Positions</span>
                <span class="badge bg-danger rounded-pill fs-6">{{ metrics?.unfilled_positions || 0 }}</span>
              </div>
              <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3 border">
                <span class="text-secondary fw-medium">Total Applications</span>
                <span class="badge bg-success rounded-pill fs-6">{{ metrics?.total_applications || 0 }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Unfilled Positions Table -->
        <div class="col-12 col-lg-8">
          <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
              <h6 class="fw-bold text-dark mb-0">Unfilled Plantilla Positions</h6>
            </div>
            <div class="card-body p-4">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th class="text-secondary small fw-bold border-0 rounded-start">Position</th>
                      <th class="text-secondary small fw-bold text-center border-0">Status</th>
                      <th class="text-secondary small fw-bold text-center border-0">Applicants</th>
                      <th class="text-secondary small fw-bold text-end border-0 rounded-end">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="plantilla in metrics?.recent_unfilled_positions" :key="plantilla.id">
                      <td class="border-bottom-0 py-3">
                        <div class="fw-medium text-dark">{{ plantilla.position }}</div>
                        <div class="small text-muted">Item {{ plantilla.item_no }}</div>
                      </td>
                      <td class="text-center border-bottom-0 py-3">
                        <span v-if="plantilla.has_posting" class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1">
                          {{ plantilla.status }}
                        </span>
                        <span v-else class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-3 py-1">
                          {{ plantilla.status }}
                        </span>
                      </td>
                      <td class="text-center border-bottom-0 py-3">
                        <span v-if="plantilla.has_posting" class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1">
                          {{ plantilla.applications_count }}
                        </span>
                        <span v-else class="text-muted small">-</span>
                      </td>
                      <td class="text-end border-bottom-0 py-3">
                        <Link v-if="plantilla.has_posting" :href="route('admin.recruitment.selection.index', { job_posting: plantilla.job_posting_id })" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                          Manage <i class="fa-solid fa-arrow-right ms-1"></i>
                        </Link>
                        <Link v-else :href="route('admin.recruitment.job_posting.index')" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                          Post Job
                        </Link>
                      </td>
                    </tr>
                    <tr v-if="!metrics?.recent_unfilled_positions?.length">
                      <td colspan="4" class="text-center text-muted py-5 fst-italic border-bottom-0">All plantilla positions are currently filled.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from './Layout/AdminLayout.vue'

defineProps({
  metrics: {
    type: Object,
    default: () => ({})
  }
})
</script>

<style scoped>
.hover-shadow:hover {
  transform: translateY(-4px);
  box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.transition-all {
  transition: all 0.3s ease;
}
</style>
