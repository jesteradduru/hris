<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <div class="row">
        <div class="col-12 mb-3">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                <i class="fa-solid fa-briefcase fs-4 text-primary"></i>
              </div>
              <div>
                <h4 class="fw-bold text-dark mb-1">Work Experience</h4>
                <p class="text-muted mb-0 small">Manage your employment history and records.</p>
              </div>
            </div>
            <div class="d-flex gap-2">
              <a class="btn btn-outline-primary rounded-pill px-4 fw-medium shadow-sm" :href="route('wes.print')" target="_blank">
                <i class="fa-solid fa-print me-2"></i>Print Sheet
              </a>
              <Link :href="route('profile.pds.work_experience.create')" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm">
                <i class="fa-solid fa-plus me-2"></i>Add Experience
              </Link>
            </div>
          </div>
        </div>

        <div class="col-12 mb-4">
          <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-sm">
                  <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem;">
                    <tr>
                      <th class="ps-4">From</th>
                      <th>To</th>
                      <th>Position</th>
                      <th>Department / Agency / Office / Company</th>
                      <th>Monthly Salary</th>
                      <th>Salary / Job / Pay Grade</th>
                      <th>Status of Appointment</th>
                      <th class="pe-4 text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody v-if="props.work_experiences.data.length">
                    <tr v-for="work_experience in props.work_experiences.data" :key="work_experience.id">
                      <td class="ps-4 fw-medium text-dark">{{ work_experience.inclusive_date_from }}</td>
                      <td>
                        <span v-if="work_experience.to_present" class="badge bg-success rounded-pill fw-normal">Present</span>
                        <span v-else>{{ work_experience.inclusive_date_to }}</span>
                      </td>
                      <td class="fw-medium">{{ work_experience.position_title }}</td>
                      <td>{{ work_experience.dept_agency_office_company }}</td>
                      <td>
                        <span v-if="work_experience.monthly_salary">₱{{ work_experience.monthly_salary }}</span>
                        <span v-else class="text-muted">-</span>
                      </td>
                      <td>{{ work_experience.paygrade || '-' }}</td>
                      <td>{{ work_experience.status_of_appointment }}</td>
                      <td class="pe-4 text-center">
                        <div class="d-flex gap-2 justify-content-center">
                          <Link class="btn btn-light btn-sm text-primary rounded-circle" :href="route('profile.pds.work_experience.edit', { work_experience: work_experience.id })" preserve-scroll title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </Link>
                          <Link as="button" class="btn btn-light btn-sm text-danger rounded-circle" method="delete" :href="route('profile.pds.work_experience.destroy', { work_experience: work_experience.id })" preserve-scroll :onBefore="confirm" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                          </Link>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td colspan="8" class="text-center py-5 text-muted fst-italic">
                        <i class="fa-solid fa-folder-open fs-3 d-block mb-2 text-black-50"></i>
                        No work experience records found.
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer bg-white border-top-0 py-3" v-if="props.work_experiences.data.length">
              <Pagination :links="props.work_experiences.links" />
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="d-flex justify-content-end gap-2">
            <Link :href="route('profile.pds.civil_service_eligibility.index')" type="button" class="btn btn-outline-dark rounded-pill px-4">
              <i class="fa-solid fa-arrow-left me-2" /> Back
            </Link>
            <Link :href="route('profile.pds.voluntary_work.index')" type="button" class="btn btn-dark rounded-pill px-4">
              Next <i class="fa-solid fa-arrow-right ms-2" />
            </Link>
          </div>
        </div>
      </div>
    </PDSLayout>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  work_experiences: Object,
})

const confirm = () => window.confirm('Are you sure to delete the work experience?')

</script>