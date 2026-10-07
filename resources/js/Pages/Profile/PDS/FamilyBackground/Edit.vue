<template>
  <AuthenticatedLayout>
    <PDSLayout :is-form-dirty="form.isDirty">
      <form @submit.prevent="create_update_family_background">
        <div class="row">
          <div class="col-12 mb-3">
            <div class="d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                <i class="fa-solid fa-users fs-4 text-primary"></i>
              </div>
              <div>
                <h4 class="fw-bold text-dark mb-1">Family Background</h4>
                <p class="text-muted mb-0 small">Please provide details about your family members.</p>
              </div>
            </div>
          </div>

          <!-- SPOUSE -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
              <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark text-uppercase"><i class="fa-solid fa-ring text-primary me-2"></i>Spouse</h6>
                <div class="form-check form-switch mb-0">
                  <input id="spouse_deceased" v-model="form.spouse_deceased" class="form-check-input" type="checkbox" role="switch" />
                  <label class="form-check-label text-muted small" for="spouse_deceased">Deceased</label>
                </div>
              </div>
              <div class="card-body p-4">
                <div class="row g-3">
                  <div class="col-12 col-md-3">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Surname</label>
                    <input v-model="form.spouse_surname" type="text" class="form-control" />
                    <InputError :message="form.errors.spouse_surname" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-3">
                    <label class="form-label text-secondary small text-uppercase fw-medium">First Name</label>
                    <input v-model="form.spouse_first_name" type="text" class="form-control" />
                    <InputError :message="form.errors.spouse_first_name" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-3">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Middle Name</label>
                    <input v-model="form.spouse_middle_name" type="text" class="form-control" />
                    <InputError :message="form.errors.spouse_middle_name" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-3">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Extension (Jr., Sr.)</label>
                    <input v-model="form.spouse_name_extension" type="text" class="form-control" />
                    <InputError :message="form.errors.spouse_name_extension" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Occupation</label>
                    <input v-model="form.spouse_occupation" type="text" class="form-control" />
                    <InputError :message="form.errors.spouse_occupation" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Employer/Business Name</label>
                    <input v-model="form.spouse_employer_business_name" type="text" class="form-control" />
                    <InputError :message="form.errors.spouse_employer_business_name" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Telephone No.</label>
                    <input v-model="form.spouse_telephone_number" type="text" class="form-control" />
                    <InputError :message="form.errors.spouse_telephone_number" class="mt-1" />
                  </div>
                  <div class="col-12">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Business Address</label>
                    <input v-model="form.spouse_business_address" type="text" class="form-control" />
                    <InputError :message="form.errors.spouse_business_address" class="mt-1" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- FATHER -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
              <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark text-uppercase"><i class="fa-solid fa-user-tie text-primary me-2"></i>Father</h6>
                <div class="form-check form-switch mb-0">
                  <input id="fathers_deceased" v-model="form.fathers_deceased" class="form-check-input" type="checkbox" role="switch" />
                  <label class="form-check-label text-muted small" for="fathers_deceased">Deceased</label>
                </div>
              </div>
              <div class="card-body p-4">
                <div class="row g-3">
                  <div class="col-12 col-md-3">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Surname</label>
                    <input v-model="form.fathers_surname" type="text" class="form-control" />
                    <InputError :message="form.errors.fathers_surname" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-3">
                    <label class="form-label text-secondary small text-uppercase fw-medium">First Name</label>
                    <input v-model="form.fathers_first_name" type="text" class="form-control" />
                    <InputError :message="form.errors.fathers_first_name" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-3">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Middle Name</label>
                    <input v-model="form.fathers_middle_name" type="text" class="form-control" />
                    <InputError :message="form.errors.fathers_middle_name" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-3">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Extension (Jr., Sr.)</label>
                    <input v-model="form.fathers_name_extension" type="text" class="form-control" />
                    <InputError :message="form.errors.fathers_name_extension" class="mt-1" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- MOTHER -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
              <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark text-uppercase"><i class="fa-solid fa-person-dress text-primary me-2"></i>Mother (Maiden Name)</h6>
                <div class="form-check form-switch mb-0">
                  <input id="mothers_deceased" v-model="form.mothers_deceased" class="form-check-input" type="checkbox" role="switch" />
                  <label class="form-check-label text-muted small" for="mothers_deceased">Deceased</label>
                </div>
              </div>
              <div class="card-body p-4">
                <div class="row g-3">
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Surname</label>
                    <input v-model="form.mothers_surname" type="text" class="form-control" />
                    <InputError :message="form.errors.mothers_surname" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">First Name</label>
                    <input v-model="form.mothers_first_name" type="text" class="form-control" />
                    <InputError :message="form.errors.mothers_first_name" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Middle Name</label>
                    <input v-model="form.mothers_middle_name" type="text" class="form-control" />
                    <InputError :message="form.errors.mothers_middle_name" class="mt-1" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- CHILDREN -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
              <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark text-uppercase"><i class="fa-solid fa-children text-primary me-2"></i>Children</h6>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addChildren">
                  <i class="fa-solid fa-plus me-1"></i> Add Child
                </button>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0 text-sm">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem;">
                      <tr>
                        <th class="ps-4">Full Name</th>
                        <th>Date of Birth</th>
                        <th class="pe-4 text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody v-if="children.length">
                      <tr v-for="child in children" :key="child.id">
                        <td class="ps-4 fw-medium text-dark">
                          {{ child.fullname }} 
                          <span v-if="child.deceased == 1" class="badge bg-secondary ms-2 fw-normal">Deceased</span>
                        </td>
                        <td>{{ child.date_of_birth }}</td>
                        <td class="pe-4 text-center">
                          <Link :only="['children']" as="button" class="btn btn-light btn-sm text-danger rounded-circle" method="delete" :href="route('profile.pds.children.delete', { children: child.id })" preserve-scroll :onBefore="confirm" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                          </Link>
                        </td>
                      </tr>
                    </tbody>
                    <tbody v-else>
                      <tr>
                        <td colspan="3" class="text-center py-4 text-muted fst-italic">No children records added.</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <button type="submit" :disabled="!form.isDirty && form.wasSuccessful" class="btn btn-primary rounded-pill px-4 shadow-sm fw-medium">
                  <Spinner :processing="form.processing" class="me-2" v-if="form.processing" /> 
                  <span v-if="!form.isDirty && form.wasSuccessful"><i class="fa-solid fa-check me-2"></i>Saved</span>
                  <span v-else><i class="fa-solid fa-save me-2" v-if="!form.processing"></i>Save Changes</span>
                </button>
                <span v-if="form.isDirty" class="text-warning ms-3 small fw-medium"><i class="fa-solid fa-triangle-exclamation me-1"></i>Unsaved changes</span>
              </div>
              <div class="d-flex gap-2">
                <Link :href="route('profile.pds.personal_information.edit')" type="button" :disabled="form.isDirty" class="btn btn-outline-dark rounded-pill px-4">
                  <i class="fa-solid fa-arrow-left me-2" /> Back
                </Link>
                <Link :href="route('profile.pds.educational_background.edit')" type="button" :disabled="form.isDirty" class="btn btn-dark rounded-pill px-4">
                  Next <i class="fa-solid fa-arrow-right ms-2" />
                </Link>
              </div>
            </div>
          </div>
        </div>
      </form>
    </PDSLayout>
  </AuthenticatedLayout>
  <Modal id="addChildren">
    <template #header>
      <h5>Add child</h5>
    </template>
    <template #body>
      <div class="row">
        <div class="col-12">
          <div v-if="childrenForm.recentlySuccessful" class="alert alert-success">Saved</div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input v-model="childrenForm.fullname" type="text" class="form-control form-control-sm" />
            <InputError :message="childrenForm.errors.fullname" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Date of birth</label>
            <input v-model="childrenForm.date_of_birth" type="date" class="form-control form-control-sm" />
            <InputError :message="childrenForm.errors.date_of_birth" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <div class="form-check">
              <input id="deceased" v-model="childrenForm.deceased" class="form-check-input" type="checkbox" value="" />
              <label class="form-check-label" for="deceased">Deceased?</label>
            </div>
          </div>
        </div>
        <div class="col-12">
          <button class="btn btn-success d-block ms-auto" @click="addChild">Add</button>
        </div>
      </div>
    </template>
  </Modal>
</template>

<script setup>
import Spinner from '@/Components/Spinner.vue'
import { useForm, Link } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import Modal from '@/Components/Modal.vue'

const props = defineProps({
  children: Array,
  family_background: Object,
})

let form = null

if (props.family_background) {
  form = useForm({
    spouse_surname: props.family_background.spouse_surname,
    spouse_first_name: props.family_background.spouse_first_name,
    spouse_name_extension: props.family_background.spouse_name_extension,
    spouse_middle_name: props.family_background.spouse_middle_name,
    spouse_occupation: props.family_background.spouse_occupation,
    spouse_employer_business_name: props.family_background.spouse_employer_business_name,
    spouse_business_address: props.family_background.spouse_business_address,
    spouse_telephone_number: props.family_background.spouse_telephone_number,
    fathers_surname: props.family_background.fathers_surname,
    fathers_first_name: props.family_background.fathers_first_name,
    fathers_name_extension: props.family_background.fathers_name_extension,
    fathers_middle_name: props.family_background.fathers_middle_name,
    mothers_surname: props.family_background.mothers_surname,
    mothers_first_name: props.family_background.mothers_first_name,
    mothers_middle_name: props.family_background.mothers_middle_name,
    mothers_deceased: props.family_background.mothers_deceased == 1,
    fathers_deceased: props.family_background.fathers_deceased == 1,
    spouse_deceased: props.family_background.spouse_deceased == 1,
  })
} else {
  form = useForm({
    spouse_surname: null,
    spouse_first_name: null,
    spouse_name_extension: null,
    spouse_middle_name: null,
    spouse_occupation: null,
    spouse_employer_business_name: null,
    spouse_business_address: null,
    spouse_telephone_number: null,
    fathers_surname: null,
    fathers_first_name: null,
    fathers_name_extension: null,
    fathers_middle_name: null,
    mothers_surname: null,
    mothers_first_name: null,
    mothers_middle_name: null,
    mothers_deceased: null,
    fathers_deceased: null,
    spouse_deceased: null,
  })
}

const create_update_family_background = () => {
  form.post(route('profile.pds.family_background.store_or_update'), {
    preserveScroll: true,
  })
}


const childrenForm = useForm({
  fullname: null,
  date_of_birth: null,
  deceased: null,
})

const addChild = () => childrenForm.post(route('profile.pds.family_background.store_child'), {
  preserveScroll: true,
  onSuccess: () => childrenForm.reset(),
})


const confirm = () => window.confirm('Are you sure?')
</script>