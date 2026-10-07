<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <div class="row">
        <div class="col-12 mb-3">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                <i class="fa-solid fa-hand-holding-heart fs-4 text-primary"></i>
              </div>
              <div>
                <h4 class="fw-bold text-dark mb-1">Voluntary Work</h4>
                <p class="text-muted mb-0 small">Manage your civic and voluntary work involvements.</p>
              </div>
            </div>
            <div class="d-flex gap-2">
              <Link :href="route('profile.pds.voluntary_work.create')" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm">
                <i class="fa-solid fa-plus me-2"></i>Add Voluntary Work
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
                      <th class="ps-4">Name & Address of Organization</th>
                      <th>From</th>
                      <th>To</th>
                      <th>Number of Hours</th>
                      <th>Position / Nature of Work</th>
                      <th class="pe-4 text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody v-if="props.voluntary_works.data.length">
                    <tr v-for="voluntary_work in props.voluntary_works.data" :key="voluntary_work.id">
                      <td class="ps-4 fw-medium text-dark">{{ voluntary_work.name_address_of_org }}</td>
                      <td>{{ voluntary_work.inclusive_date_from }}</td>
                      <td>{{ voluntary_work.inclusive_date_to }}</td>
                      <td>
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">{{ voluntary_work.number_of_hours }} hrs</span>
                      </td>
                      <td>{{ voluntary_work.position_work }}</td>
                      <td class="pe-4 text-center">
                        <div class="d-flex gap-2 justify-content-center">
                          <Link class="btn btn-light btn-sm text-primary rounded-circle" :href="route('profile.pds.voluntary_work.edit', { voluntary_work: voluntary_work.id })" preserve-scroll title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </Link>
                          <Link as="button" class="btn btn-light btn-sm text-danger rounded-circle" method="delete" :href="route('profile.pds.voluntary_work.destroy', { voluntary_work: voluntary_work.id })" preserve-scroll title="Delete">
                            <i class="fa-solid fa-trash"></i>
                          </Link>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td colspan="6" class="text-center py-5 text-muted fst-italic">
                        <i class="fa-solid fa-folder-open fs-3 d-block mb-2 text-black-50"></i>
                        No voluntary work records found.
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer bg-white border-top-0 py-3" v-if="props.voluntary_works.data.length">
              <Pagination :links="props.voluntary_works.links" />
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="d-flex justify-content-end gap-2">
            <Link :href="route('profile.pds.work_experience.index')" type="button" class="btn btn-outline-dark rounded-pill px-4">
              <i class="fa-solid fa-arrow-left me-2" /> Back
            </Link>
            <Link :href="route('profile.pds.learning_and_development.index')" type="button" class="btn btn-dark rounded-pill px-4">
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
  voluntary_works: Object,
})
  
</script>