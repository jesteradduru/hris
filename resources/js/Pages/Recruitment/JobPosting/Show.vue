<template>
  <Head title="Job Vacancies" />

  <AuthenticatedLayout>
    <div class="mb-4">
      <BreadCrumbs :crumbs="crumbs" />
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
      <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
          <h3 class="fw-bold text-dark mb-1">{{ props.job_posting.plantilla.position }}</h3>
          <p class="text-muted mb-0"><i class="fa-solid fa-location-dot me-2 text-danger"></i>{{ props.job_posting.plantilla.place_of_assignment }}</p>
        </div>
        <div>
          <Link
            v-if="permissions && permissions.includes('Add Application')"
            :href="route('job_application.create', { job_posting: props.job_posting.id })"
            class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm"
          >
            Apply Now
          </Link>
          <div v-else class="alert alert-warning mb-0 rounded-pill py-2 px-3 small">
            <i class="fa-solid fa-circle-exclamation me-2"></i>Please login/register to apply.
          </div>
        </div>
      </div>
      
      <div class="card-body p-4">
        <div class="row g-4">
          <div class="col-12 col-lg-6">
            <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Job Details</h5>
            <div class="d-flex flex-column gap-3">
              <div>
                <span class="text-secondary small text-uppercase fw-semibold d-block">Plantilla Item No.</span>
                <span class="text-dark">{{ props.job_posting.plantilla.plantilla_item_no }}</span>
              </div>
              <div>
                <span class="text-secondary small text-uppercase fw-semibold d-block">Salary Grade</span>
                <span class="text-dark">{{ props.job_posting.plantilla.salary_grade }}</span>
              </div>
              <div>
                <span class="text-secondary small text-uppercase fw-semibold d-block">Monthly Salary</span>
                <span class="text-dark fw-bold text-success fs-5"><Salary :value="props.job_posting.plantilla.monthly_salary" /></span>
              </div>
              <div>
                <span class="text-secondary small text-uppercase fw-semibold d-block">Posting Date</span>
                <span class="text-dark">{{ moment(props.job_posting.posting_date).format('LL') }}</span>
              </div>
              <div>
                <span class="text-secondary small text-uppercase fw-semibold d-block">Closing Date</span>
                <span class="text-dark">{{ moment(props.job_posting.closing_date).format('LL') }}</span>
              </div>
            </div>
          </div>
          
          <div class="col-12 col-lg-6">
            <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Qualifications</h5>
            <div class="d-flex flex-column gap-3">
              <div>
                <span class="text-secondary small text-uppercase fw-semibold d-block">Education</span>
                <span class="text-dark">{{ props.job_posting.plantilla.education }}</span>
              </div>
              <div>
                <span class="text-secondary small text-uppercase fw-semibold d-block">Training</span>
                <span class="text-dark">
                  <span v-if="job_posting.plantilla.training == null">None Required</span>
                  <span v-else>{{ props.job_posting.plantilla.training }} hour/s of relevant training.</span>
                </span>
              </div>
              <div>
                <span class="text-secondary small text-uppercase fw-semibold d-block">Work Experience</span>
                <span class="text-dark">
                  <span v-if="job_posting.plantilla.work_experience == null">None Required</span>
                  <span v-else>{{ props.job_posting.plantilla.work_experience }} year/s of relevant experience</span>
                </span>
              </div>
              <div>
                <span class="text-secondary small text-uppercase fw-semibold d-block">Eligibility</span>
                <span class="text-dark">{{ props.job_posting.plantilla.eligibility }}</span>
              </div>
            </div>
          </div>

          <div class="col-12 mt-4">
            <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Competency & Requirements</h5>
            <div class="row g-4">
              <div class="col-12 col-md-6">
                <span class="text-secondary small text-uppercase fw-semibold d-block mb-1">Competency</span>
                <p class="text-dark mb-0" style="white-space: pre-wrap">{{ props.job_posting.plantilla.competency || 'Not specified' }}</p>
              </div>
              <div class="col-12 col-md-6">
                <span class="text-secondary small text-uppercase fw-semibold d-block mb-1">Documents Required</span>
                <p class="text-dark mb-0" style="white-space: pre-wrap">{{ props.job_posting.documents }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import Salary from '@/Components/Salary.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import moment from 'moment'
const props = defineProps({
  job_posting: Object,
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
  },
])

const permissions = usePage()
  .props.auth.permissions?.map((perm) => perm.name)
</script>
