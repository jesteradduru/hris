<template>
  <Head title="Job Vacancies" />

  <AuthenticatedLayout>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="fw-bold text-dark mb-0">Job Vacancies</h3>
        <BreadCrumbs :crumbs="crumbs" />
      </div>
    </div>

    <div class="row g-4">
      <!-- Left Column: Job List -->
      <div class="col-12 col-md-5 col-lg-4">
        <div class="card shadow-sm border-0 rounded-4 mb-4">
          <div class="card-header bg-white border-bottom p-3">
            <h6 class="fw-bold text-dark mb-3">Recent Postings</h6>
            <Filter :filters="props.filters" />
          </div>
          <div class="card-body p-0" style="max-height: 75vh; overflow-y: auto;">
            <div v-if="props.job_vacancies.data.length" class="list-group list-group-flush">
              <button 
                v-for="item in props.job_vacancies.data" :key="item.id"
                class="list-group-item list-group-item-action p-4 border-bottom"
                :class="{ 'bg-primary bg-opacity-10 border-start border-primary border-4': selectedJob && selectedJob.id === item.id }"
                @click="selectedJob = item"
              >
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h6 class="fw-bold text-dark mb-0">{{ item.plantilla.position }}</h6>
                </div>
                <div class="text-muted small mb-2">
                  <i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ item.plantilla.place_of_assignment }}
                </div>
                <div class="d-flex flex-wrap gap-2 mb-2">
                  <span class="badge bg-light text-secondary border">SG {{ item.plantilla.salary_grade }}</span>
                  <span class="badge bg-light text-secondary border">Item {{ item.plantilla.plantilla_item_no }}</span>
                </div>
                <div class="text-secondary small mt-3">
                  Posted {{ moment(item.posting_date).fromNow() }}
                </div>
              </button>
            </div>
            <div v-else class="text-center py-5 text-muted fst-italic">
              <i class="fa-solid fa-folder-open fs-3 d-block mb-2 text-black-50"></i>
              No job vacancies available at the moment.
            </div>
          </div>
          <div class="card-footer bg-white border-top py-3" v-if="props.job_vacancies.data.length">
            <Pagination :links="props.job_vacancies.links" />
          </div>
        </div>
      </div>

      <!-- Right Column: Job Details (LinkedIn Style) -->
      <div class="col-12 col-md-7 col-lg-8 d-none d-md-block">
        <div v-if="selectedJob" class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 100px; max-height: calc(100vh - 120px); overflow-y: auto;">
          <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
              <h4 class="fw-bold text-dark mb-2">{{ selectedJob.plantilla.position }}</h4>
              <p class="text-muted mb-0"><i class="fa-solid fa-location-dot me-2 text-danger"></i>{{ selectedJob.plantilla.place_of_assignment }}</p>
              <div class="text-muted small mt-2">
                Closes on {{ moment(selectedJob.closing_date).format('LL') }}
              </div>
            </div>
            <div>
              <Link
                v-if="permissions && permissions.includes('Add Application')"
                :href="route('job_application.create', { job_posting: selectedJob.id })"
                class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm"
              >
                Apply Now
              </Link>
              <div v-else class="alert alert-warning mb-0 rounded-pill py-2 px-3 small">
                <i class="fa-solid fa-circle-exclamation me-2"></i>Login to apply
              </div>
            </div>
          </div>
          
          <div class="card-body p-4">
            <div class="row g-4">
              <div class="col-12 col-lg-6">
                <h6 class="fw-bold text-primary mb-3 text-uppercase small letter-spacing-1">Job Details</h6>
                <div class="d-flex flex-column gap-3">
                  <div>
                    <span class="text-secondary small text-uppercase fw-semibold d-block">Plantilla Item No.</span>
                    <span class="text-dark">{{ selectedJob.plantilla.plantilla_item_no }}</span>
                  </div>
                  <div>
                    <span class="text-secondary small text-uppercase fw-semibold d-block">Salary Grade</span>
                    <span class="text-dark">{{ selectedJob.plantilla.salary_grade }}</span>
                  </div>
                  <div>
                    <span class="text-secondary small text-uppercase fw-semibold d-block">Monthly Salary</span>
                    <span class="text-dark fw-bold text-success fs-5"><Salary :value="selectedJob.plantilla.monthly_salary" /></span>
                  </div>
                </div>
              </div>
              
              <div class="col-12 col-lg-6">
                <h6 class="fw-bold text-primary mb-3 text-uppercase small letter-spacing-1">Qualifications</h6>
                <div class="d-flex flex-column gap-3">
                  <div>
                    <span class="text-secondary small text-uppercase fw-semibold d-block">Education</span>
                    <span class="text-dark">{{ selectedJob.plantilla.education }}</span>
                  </div>
                  <div>
                    <span class="text-secondary small text-uppercase fw-semibold d-block">Training</span>
                    <span class="text-dark">
                      <span v-if="selectedJob.plantilla.training == null">None Required</span>
                      <span v-else>{{ selectedJob.plantilla.training }} hour/s relevant training.</span>
                    </span>
                  </div>
                  <div>
                    <span class="text-secondary small text-uppercase fw-semibold d-block">Work Experience</span>
                    <span class="text-dark">
                      <span v-if="selectedJob.plantilla.work_experience == null">None Required</span>
                      <span v-else>{{ selectedJob.plantilla.work_experience }} year/s relevant experience</span>
                    </span>
                  </div>
                  <div>
                    <span class="text-secondary small text-uppercase fw-semibold d-block">Eligibility</span>
                    <span class="text-dark">{{ selectedJob.plantilla.eligibility }}</span>
                  </div>
                </div>
              </div>

              <div class="col-12 mt-4">
                <h6 class="fw-bold text-primary mb-3 text-uppercase small letter-spacing-1">Competency & Requirements</h6>
                <div class="row g-4">
                  <div class="col-12 col-md-6">
                    <span class="text-secondary small text-uppercase fw-semibold d-block mb-1">Competency</span>
                    <p class="text-dark small mb-0" style="white-space: pre-wrap">{{ selectedJob.plantilla.competency || 'Not specified' }}</p>
                  </div>
                  <div class="col-12 col-md-6">
                    <span class="text-secondary small text-uppercase fw-semibold d-block mb-1">Documents Required</span>
                    <p class="text-dark small mb-0" style="white-space: pre-wrap">{{ selectedJob.documents }}</p>
                  </div>
                </div>
              </div>
              
              <div class="col-12 mt-4 text-center">
                 <Link
                    :href="route('recruitment.job_posting.show', { job_posting: selectedJob.id })"
                    class="btn btn-outline-secondary rounded-pill px-4"
                  >
                    View Full Details Page <i class="fa-solid fa-arrow-right ms-2"></i>
                  </Link>
              </div>
            </div>
          </div>
        </div>
        
        <div v-else class="card shadow-sm border-0 rounded-4 h-100 d-flex align-items-center justify-content-center p-5">
          <div class="text-center text-muted">
            <i class="fa-solid fa-briefcase fs-1 mb-3 text-black-50"></i>
            <h5 class="fw-bold">Select a job to view details</h5>
            <p class="small">Click on a job posting from the left to see more information.</p>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue'
import Filter from '@/Pages/Recruitment/JobPosting/Components/Filter.vue'
import Salary from '@/Components/Salary.vue'

const permissions = usePage().props.auth.permissions?.map((perm) => perm.name)

const crumbs = computed(() => [
  {
    label: 'Dashboard',
    link: route('dashboard'),
  },
  {
    label: 'Job Vacancies',
  },
])

const props = defineProps({
  job_vacancies: Object,
  filters: Object,
})

const selectedJob = ref(props.job_vacancies.data.length > 0 ? props.job_vacancies.data[0] : null)
</script>
