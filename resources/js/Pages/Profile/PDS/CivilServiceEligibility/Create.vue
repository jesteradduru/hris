<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
          <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                <i class="fa-solid fa-certificate text-primary"></i>
              </div>
              <h5 class="mb-0 fw-bold text-dark">Add New Eligibility</h5>
            </div>
            <div class="card-body p-4">
              <form @submit.prevent="addEligibility">
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Eligibility</label>
                    <input v-model="eligibilityForm.cs_board_bar_ces_csee_barangay_drivers" type="text" class="form-control" placeholder="e.g. Civil Service Professional" />
                    <InputError :message="eligibilityForm.errors.cs_board_bar_ces_csee_barangay_drivers" class="mt-1" />
                  </div>
                
                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Rating (If applicable)</label>
                    <input v-model="eligibilityForm.rating" type="text" class="form-control" placeholder="e.g. 85.50" />
                    <InputError :message="eligibilityForm.errors.rating" class="mt-1" />
                  </div>
                
                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Date of Examination / Conferment</label>
                    <input v-model="eligibilityForm.date_of_exam_conferment" type="date" class="form-control" />
                    <InputError :message="eligibilityForm.errors.date_of_exam_conferment" class="mt-1" />
                  </div>
                
                  <div class="col-12">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Place of Examination / Conferment</label>
                    <input v-model="eligibilityForm.place_of_exam_conferment" type="text" class="form-control" placeholder="City, Province" />
                    <InputError :message="eligibilityForm.errors.place_of_exam_conferment" class="mt-1" />
                  </div>
                
                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">License Number</label>
                    <input v-model="eligibilityForm.license_number" type="text" class="form-control" placeholder="If applicable" />
                    <InputError :message="eligibilityForm.errors.license_number" class="mt-1" />
                  </div>
                        
                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">License Date of Validity</label>
                    <input v-model="eligibilityForm.license_date_of_validity" type="date" class="form-control" />
                    <InputError :message="eligibilityForm.errors.license_date_of_validity" class="mt-1" />
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Attachment</label>
                    <input type="file" class="form-control" multiple @input="addDocument" accept=".pdf" />
                    <small class="form-text text-muted d-block mt-1"><i class="fa-solid fa-circle-info me-1"></i>Accepted file formats: PDF</small>
                    <InputError :message="eligibilityForm.errors['documents']" class="mt-1" />
                    <InputError :message="eligibilityForm.errors['documents.0']" class="mt-1" />
                  </div>
                </div>
                
                <hr class="my-4">
                
                <div class="d-flex justify-content-end gap-2">
                  <Link :href="route('profile.pds.civil_service_eligibility.index')" class="btn btn-light rounded-pill px-4 fw-medium text-secondary">Cancel</Link>
                  <button class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm" :disabled="eligibilityForm.processing" type="submit">
                    <Spinner :processing="eligibilityForm.processing" class="me-2" v-if="eligibilityForm.processing" />
                    <i class="fa-solid fa-save me-2" v-else></i> Save Eligibility
                  </button>
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
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import Spinner from '@/Components/Spinner.vue'
import { useForm, Link } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const eligibilityForm = useForm({
  cs_board_bar_ces_csee_barangay_drivers: null,
  rating: null,
  date_of_exam_conferment: null,
  place_of_exam_conferment: null,
  license_number: null,
  license_date_of_validity: null,
  documents: [],
})
  
const addEligibility = () => {
  eligibilityForm.post(route('profile.pds.civil_service_eligibility.store'), {
    preserveScroll: true,
    onSuccess: () => eligibilityForm.reset(),
  })
}

const addDocument = (e) => {
  eligibilityForm.documents = []
  for(const file of e.target.files){
    eligibilityForm.documents.push(file)
  }
}
  
</script>