<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <form @submit.prevent="addEligibility">
        <div class="row">
          <div class="col-12">
            <div class="mb-3">
              <label class="form-label">Eligibility</label>
              <input v-model="eligibilityForm.cs_board_bar_ces_csee_barangay_drivers" type="text" class="form-control form-control-sm" />
              <InputError :message="eligibilityForm.errors.cs_board_bar_ces_csee_barangay_drivers" />
            </div>
          </div>
        
        
          <div class="col-12">
            <div class="mb-3">
              <label class="form-label">RATING(If applicable)</label>
              <input v-model="eligibilityForm.rating" type="text" class="form-control form-control-sm" />
              <InputError :message="eligibilityForm.errors.rating" />
            </div>
          </div>
        
        
          <div class="col-12">
            <div class="mb-3">
              <label class="form-label">DATE OF EXAMINATION/CONFERNMENT</label>
              <input v-model="eligibilityForm.date_of_exam_conferment" type="date" class="form-control form-control-sm" />
              <InputError :message="eligibilityForm.errors.date_of_exam_conferment" />
            </div>
          </div>
        
        
          <div class="col-12">
            <div class="mb-3">
              <label class="form-label">PLACE OF EXAMINATION/CONFERNMENT</label>
              <input v-model="eligibilityForm.place_of_exam_conferment" type="text" class="form-control form-control-sm" />
              <InputError :message="eligibilityForm.errors.place_of_exam_conferment" />
            </div>
          </div>
        
        
          <div class="col-12">
            <div class="mb-3">
              <label class="form-label">LICENSE NUMBER</label>
              <input v-model="eligibilityForm.license_number" type="text" class="form-control form-control-sm" />
              <InputError :message="eligibilityForm.errors.license_number" />
            </div>
          </div>
                
        
          <div class="col-12">
            <div class="mb-3">
              <label class="form-label">LICENSE DATE OF VALIDITY</label>
              <input v-model="eligibilityForm.license_date_of_validity" type="date" class="form-control form-control-sm" />
              <InputError :message="eligibilityForm.errors.license_date_of_validity" />
            </div>
          </div>
        
        
          <div class="col-12">
            <div class="d-flex gap-2">
              <Link :href="route('profile.pds.civil_service_eligibility.index')" class="btn btn-secondary" :disabled="addEligibility.processing" type="submit">  Back</Link>
              <button class="btn btn-success" :disabled="addEligibility.processing" type="submit"><Spinner :processing="eligibilityForm.processing" />  Add</button>
            </div>
          </div>
        </div>
      </form>
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
})
  
const addEligibility = () => {
  eligibilityForm.post(route('profile.pds.civil_service_eligibility.store'), {
    preserveScroll: true,
    onSuccess: () => eligibilityForm.reset(),
  })
}
  
  
</script>