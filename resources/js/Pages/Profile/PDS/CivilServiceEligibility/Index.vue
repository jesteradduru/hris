<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <div class="row">
        <div class="col-12 mb-3">
          <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                <i class="fa-solid fa-certificate fs-4 text-primary"></i>
              </div>
              <div>
                <h4 class="fw-bold text-dark mb-1">Civil Service Eligibility</h4>
                <p class="text-muted mb-0 small">Manage your civil service eligibilities and licenses.</p>
              </div>
            </div>
            <Link :href="route('profile.pds.civil_service_eligibility.create')" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm">
              <i class="fa-solid fa-plus me-2"></i>Add Eligibility
            </Link>
          </div>
        </div>

        <div class="col-12 mb-4">
          <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-sm">
                  <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem;">
                    <tr>
                      <th class="ps-4">Eligibility</th>
                      <th>Rating</th>
                      <th>Date of Examination</th>
                      <th>Place of Examination</th>
                      <th>License Number</th>
                      <th>Date of Validity</th>
                      <th>Files</th>
                      <th class="pe-4 text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody v-if="props.eligibilities.data.length">
                    <tr v-for="eligibility in props.eligibilities.data" :key="eligibility.id">
                      <td class="ps-4 fw-medium text-dark">{{ eligibility.cs_board_bar_ces_csee_barangay_drivers }}</td>
                      <td>{{ eligibility.rating || '-' }}</td>
                      <td>{{ eligibility.date_of_exam_conferment }}</td>
                      <td>{{ eligibility.place_of_exam_conferment }}</td>
                      <td>{{ eligibility.license_number || '-' }}</td>
                      <td>{{ eligibility.license_date_of_validity || '-' }}</td>
                      <td>
                        <div class="d-flex flex-column gap-1" v-if="eligibility.files && eligibility.files.length">
                          <a v-for="file in eligibility.files" :key="file.id" target="_blank" :href="file.src" class="text-decoration-none text-truncate" style="max-width: 150px;">
                            <i class="fa-solid fa-file-pdf text-danger me-1"></i><small>{{ file.filename }}</small>
                          </a>
                        </div>
                        <span v-else class="text-muted">-</span>
                      </td>
                      <td class="pe-4 text-center">
                        <div class="d-flex gap-2 justify-content-center">
                          <Link class="btn btn-light btn-sm text-primary rounded-circle" :href="route('profile.pds.civil_service_eligibility.edit', { civil_service_eligibility: eligibility.id })" preserve-scroll title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </Link>
                          <Link as="button" class="btn btn-light btn-sm text-danger rounded-circle" method="delete" :href="route('profile.pds.civil_service_eligibility.destroy', { civil_service_eligibility: eligibility.id })" preserve-scroll :onBefore="confirm" title="Delete">
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
                        No eligibility records found.
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer bg-white border-top-0 py-3" v-if="props.eligibilities.data.length">
              <Pagination :links="props.eligibilities.links" />
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="d-flex justify-content-end gap-2">
            <Link :href="route('profile.pds.educational_background.edit')" type="button" class="btn btn-outline-dark rounded-pill px-4">
              <i class="fa-solid fa-arrow-left me-2" /> Back
            </Link>
            <Link :href="route('profile.pds.work_experience.index')" type="button" class="btn btn-dark rounded-pill px-4">
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
  eligibilities: Object,
})


const confirm = () => window.confirm('Are you sure you want to delete this?')
</script>