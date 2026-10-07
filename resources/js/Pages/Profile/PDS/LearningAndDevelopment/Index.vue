<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <div class="row">
        <div class="col-12">
          <div class="alert alert-info border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
            <i class="fa-solid fa-circle-info fs-4 me-3 text-info"></i>
            <div>
              <h6 class="fw-bold mb-1">Reminder</h6>
              <span class="small">To validate the Learning and Development Intervention/Training, please attach the certificate.</span>
            </div>
          </div>
        </div>

        <div class="col-12 mb-3">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                <i class="fa-solid fa-graduation-cap fs-4 text-primary"></i>
              </div>
              <div>
                <h4 class="fw-bold text-dark mb-1">Learning and Development</h4>
                <p class="text-muted mb-0 small">Manage your training and development interventions.</p>
              </div>
            </div>
            <div class="d-flex gap-2">
              <Link :href="route('profile.pds.learning_and_development.create')" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm">
                <i class="fa-solid fa-plus me-2"></i>Add Training
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
                      <th class="ps-4">Title of Learning & Development</th>
                      <th>From</th>
                      <th>To</th>
                      <th>Hours</th>
                      <th>Type of L&D</th>
                      <th>Conducted / Sponsored By</th>
                      <th>Attachments</th>
                      <th class="pe-4 text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody v-if="props.learning_and_development.data.length">
                    <tr v-for="learning in props.learning_and_development.data" :key="learning.id">
                      <td class="ps-4 fw-medium text-dark">{{ learning.title_of_learning }}</td>
                      <td>{{ learning.inclusive_date_from }}</td>
                      <td>{{ learning.inclusive_date_to }}</td>
                      <td>
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">{{ learning.number_of_hours }} hrs</span>
                      </td>
                      <td>{{ learning.type_of_ld }}</td>
                      <td>{{ learning.conducted_sponsored_by }}</td>
                      <td>
                        <div class="d-flex flex-column gap-1">
                          <a v-for="file in learning.files" :key="file.id" target="_blank" :href="file.src" class="text-decoration-none small">
                            <i class="fa-solid fa-paperclip text-muted me-1"></i>{{ file.filename }}
                          </a>
                          <span v-if="!learning.files || !learning.files.length" class="text-muted fst-italic small">No attachments</span>
                        </div>
                      </td>
                      <td class="pe-4 text-center">
                        <div class="d-flex gap-2 justify-content-center">
                          <Link class="btn btn-light btn-sm text-primary rounded-circle" :href="route('profile.pds.learning_and_development.edit', { learning_and_development: learning.id })" preserve-scroll title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </Link>
                          <Link as="button" class="btn btn-light btn-sm text-danger rounded-circle" method="delete" :href="route('profile.pds.learning_and_development.destroy', { learning_and_development: learning.id })" preserve-scroll :onBefore="confirm" title="Delete">
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
                        No learning and development records found.
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer bg-white border-top-0 py-3" v-if="props.learning_and_development.data.length">
              <Pagination :links="props.learning_and_development.links" />
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="d-flex justify-content-end gap-2">
            <Link :href="route('profile.pds.voluntary_work.index')" type="button" class="btn btn-outline-dark rounded-pill px-4">
              <i class="fa-solid fa-arrow-left me-2" /> Back
            </Link>
            <Link :href="route('profile.pds.other_information.index')" type="button" class="btn btn-dark rounded-pill px-4">
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
  learning_and_development: Object,
})

const confirm = () => window.confirm('Are you sure to delete this training?')
    
</script>