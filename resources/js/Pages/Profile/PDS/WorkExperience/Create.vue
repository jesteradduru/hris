<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                <i class="fa-solid fa-briefcase text-primary"></i>
              </div>
              <h5 class="mb-0 fw-bold text-dark">Add Work Experience</h5>
            </div>
            <div class="card-body p-4">
              <form @submit.prevent="addWork">
                <div class="row g-3">
                  <!-- Dates -->
                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">From</label>
                    <input v-model="workForm.inclusive_date_from" type="date" class="form-control" />
                    <InputError :message="workForm.errors.inclusive_date_from" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <label class="form-label mb-0 fw-medium text-secondary small text-uppercase">To</label>
                      <div class="form-check form-switch mb-0">
                        <input id="training" v-model="workForm.to_present" class="form-check-input" type="checkbox" role="switch" />
                        <label class="form-check-label small text-muted" for="training">Present</label>
                      </div>
                    </div>
                    <input v-model="workForm.inclusive_date_to" :disabled="workForm.to_present" type="date" class="form-control" />
                    <InputError :message="workForm.errors.inclusive_date_to" class="mt-1" />
                  </div>

                  <!-- Details -->
                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Position Title</label>
                    <input v-model="workForm.position_title" type="text" class="form-control" placeholder="Write in full / Do not abbreviate" />
                    <InputError :message="workForm.errors.position_title" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Department / Agency / Office / Company</label>
                    <input v-model="workForm.dept_agency_office_company" type="text" class="form-control" placeholder="Write in full / Do not abbreviate" />
                    <InputError :message="workForm.errors.dept_agency_office_company" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Name of Office/Unit</label>
                    <input v-model="workForm.name_of_office_unit" type="text" class="form-control" placeholder="Write in full / Do not abbreviate" />
                    <InputError :message="workForm.errors.name_of_office_unit" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Office Address</label>
                    <input v-model="workForm.office_address" type="text" class="form-control" />
                    <InputError :message="workForm.errors.office_address" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Immediate Supervisor</label>
                    <input v-model="workForm.immediate_supervisor" type="text" class="form-control" />
                    <InputError :message="workForm.errors.immediate_supervisor" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Monthly Salary</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light text-muted">₱</span>
                      <input v-model="workForm.monthly_salary" type="text" class="form-control" placeholder="0.00" />
                    </div>
                    <InputError :message="workForm.errors.monthly_salary" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Salary/Job/Pay Grade (if applicable)</label>
                    <input v-model="workForm.paygrade" type="text" class="form-control" placeholder="e.g. 12-1" />
                    <InputError :message="workForm.errors.paygrade" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Status of Appointment</label>
                    <input v-model="workForm.status_of_appointment" type="text" class="form-control" />
                    <InputError :message="workForm.errors.status_of_appointment" class="mt-1" />
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-medium text-secondary small text-uppercase d-block">Government Service</label>
                    <div class="d-flex gap-3">
                      <div class="form-check">
                        <input id="govt_yes" v-model="workForm.govt_service" class="form-check-input" type="radio" name="govt_service" value="1" />
                        <label class="form-check-label" for="govt_yes">Yes</label>
                      </div>
                      <div class="form-check">
                        <input id="govt_no" v-model="workForm.govt_service" class="form-check-input" type="radio" name="govt_service" value="0" />
                        <label class="form-check-label" for="govt_no">No</label>
                      </div>
                    </div>
                    <InputError :message="workForm.errors.govt_service" class="mt-1" />
                  </div>

                  <!-- Textareas -->
                  <div class="col-12">
                    <label class="form-label fw-medium text-secondary small text-uppercase">List of Accomplishments</label>
                    <textarea v-model="workForm.list_of_accomplishments" class="form-control" rows="3" placeholder="- Start with a hyphen on each new item"></textarea>
                    <InputError :message="workForm.errors.list_of_accomplishments" class="mt-1" />
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Summary of Duties</label>
                    <textarea v-model="workForm.summary_of_duties" class="form-control" rows="3" placeholder="- Start with a hyphen on each new item"></textarea>
                    <InputError :message="workForm.errors.summary_of_duties" class="mt-1" />
                  </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                  <span v-if="workForm.isDirty" class="text-warning small fw-medium"><i class="fa-solid fa-triangle-exclamation me-1"></i>Unsaved changes</span>
                  <span v-else></span>
                  
                  <div class="d-flex gap-2">
                    <Link :href="route('profile.pds.work_experience.index')" class="btn btn-light rounded-pill px-4 fw-medium text-secondary" :disabled="workForm.processing">Cancel</Link>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm" :disabled="!workForm.isDirty && workForm.wasSuccessful">
                      <Spinner :processing="workForm.processing" class="me-2" v-if="workForm.processing" /> 
                      <span v-if="!workForm.isDirty && workForm.wasSuccessful"><i class="fa-solid fa-check me-2"></i>Added</span>
                      <span v-else><i class="fa-solid fa-save me-2" v-if="!workForm.processing"></i>Save Experience</span>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </PDSLayout>
  </AuthenticatedLayout>
</template>

<script setup>
import Spinner from '@/Components/Spinner.vue'
import { useForm, Link } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'

const workForm = useForm({
  inclusive_date_from: null,
  inclusive_date_to: null,
  position_title: null,
  dept_agency_office_company: null,
  name_of_office_unit: null,
  office_address: null,
  immediate_supervisor: null,
  monthly_salary: null,
  paygrade: null,
  status_of_appointment: null,
  govt_service: null,
  list_of_accomplishments: null,
  summary_of_duties: null,
  to_present: false,
})

const addWork = () => {
  if(workForm.to_present){
    workForm.inclusive_date_to = null
  }
  workForm.post(route('profile.pds.work_experience.store'), {
    preserveScroll: true,
    onSuccess: () => {
      workForm.reset()
    },
  })
}
</script>