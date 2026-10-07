
<template>
  <AuthenticatedLayout>
    <PDSLayout :is-form-dirty="form.isDirty">
      <form @submit.prevent="create_update_personal_info">
        <div class="row">
          <div class="col-12 mb-3">
            <div class="d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                <i class="fa-solid fa-address-card fs-4 text-primary"></i>
              </div>
              <div>
                <h4 class="fw-bold text-dark mb-1">Personal Information</h4>
                <p class="text-muted mb-0 small">Update your basic personal details.</p>
              </div>
            </div>
          </div>

          <!-- Basic Details Card -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
              <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark text-uppercase"><i class="fa-solid fa-user text-primary me-2"></i>Basic Details</h6>
              </div>
              <div class="card-body p-4">
                <div class="row g-3">
                  <div class="col-12 col-md-3">
                    <label for="surname" class="form-label text-secondary small text-uppercase fw-medium">Surname</label>
                    <input id="surname" v-model="form.surname" type="text" class="form-control" />
                    <InputError :message="form.errors.surname" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-3">
                    <label for="first_name" class="form-label text-secondary small text-uppercase fw-medium">First Name</label>
                    <input id="first_name" v-model="form.first_name" type="text" class="form-control" />
                    <InputError :message="form.errors.first_name" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-3">
                    <label for="middle_name" class="form-label text-secondary small text-uppercase fw-medium">Middle Name</label>
                    <input id="middle_name" v-model="form.middle_name" type="text" class="form-control" />
                    <InputError :message="form.errors.middle_name" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-3">
                    <label for="name_extension" class="form-label text-secondary small text-uppercase fw-medium">Extension (Jr., Sr.)</label>
                    <input id="name_extension" v-model="form.name_extension" type="text" class="form-control" />
                    <InputError :message="form.errors.name_extension" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label for="date_of_birth" class="form-label text-secondary small text-uppercase fw-medium">Date of Birth</label>
                    <input id="date_of_birth" v-model="form.date_of_birth" type="date" class="form-control" />
                    <InputError :message="form.errors.date_of_birth" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-8">
                    <label for="place_of_birth" class="form-label text-secondary small text-uppercase fw-medium">Place of Birth</label>
                    <input id="place_of_birth" v-model="form.place_of_birth" type="text" class="form-control" />
                    <InputError :message="form.errors.place_of_birth" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-3">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Sex</label>
                    <div class="d-flex gap-3 mt-2">
                      <div class="form-check">
                        <input id="male" v-model="form.sex" type="radio" class="form-check-input" name="sex" value="male" />
                        <label class="form-check-label" for="male">Male</label>
                      </div>
                      <div class="form-check">
                        <input id="female" v-model="form.sex" type="radio" class="form-check-input" name="sex" value="female" />
                        <label class="form-check-label" for="female">Female</label>
                      </div>
                    </div>
                    <InputError :message="form.errors.sex" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-9">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Civil Status</label>
                    <div class="d-flex flex-wrap gap-3 mt-2 align-items-center">
                      <div class="form-check">
                        <input id="single" v-model="form.civil_status" type="radio" class="form-check-input" name="civil_status" value="single" />
                        <label class="form-check-label" for="single">Single</label>
                      </div>
                      <div class="form-check">
                        <input id="married" v-model="form.civil_status" type="radio" class="form-check-input" name="civil_status" value="married" />
                        <label class="form-check-label" for="married">Married</label>
                      </div>
                      <div class="form-check">
                        <input id="widowed" v-model="form.civil_status" type="radio" class="form-check-input" name="civil_status" value="widowed" />
                        <label class="form-check-label" for="widowed">Widowed</label>
                      </div>
                      <div class="form-check">
                        <input id="separated" v-model="form.civil_status" type="radio" class="form-check-input" name="civil_status" value="separated" />
                        <label class="form-check-label" for="separated">Separated</label>
                      </div>
                      <div class="form-check d-flex align-items-center gap-2">
                        <input id="others" v-model="form.civil_status" type="radio" class="form-check-input" name="civil_status" value="others" />
                        <label class="form-check-label" for="others">Others</label>
                        <input v-if="form.civil_status === 'others'" v-model="form.other_civil_status" type="text" placeholder="Specify" class="form-control form-control-sm ms-2" style="width: 150px;" />
                      </div>
                    </div>
                    <InputError :message="form.errors.civil_status" class="mt-1" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Physical Attributes & Background Card -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
              <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark text-uppercase"><i class="fa-solid fa-weight-scale text-primary me-2"></i>Physical Attributes & Background</h6>
              </div>
              <div class="card-body p-4">
                <div class="row g-3">
                  <div class="col-6 col-md-3">
                    <label for="height" class="form-label text-secondary small text-uppercase fw-medium">Height (m)</label>
                    <input id="height" v-model="form.height" type="text" class="form-control" />
                    <InputError :message="form.errors.height" class="mt-1" />
                  </div>
                  <div class="col-6 col-md-3">
                    <label for="weight" class="form-label text-secondary small text-uppercase fw-medium">Weight (kg)</label>
                    <input id="weight" v-model="form.weight" type="text" class="form-control" />
                    <InputError :message="form.errors.weight" class="mt-1" />
                  </div>
                  <div class="col-6 col-md-3">
                    <label for="blood_type" class="form-label text-secondary small text-uppercase fw-medium">Blood Type</label>
                    <input v-model="form.blood_type" type="text" class="form-control" />
                    <InputError :message="form.errors.blood_type" class="mt-1" />
                  </div>
                  <div class="col-6 col-md-3">
                    <label for="religion" class="form-label text-secondary small text-uppercase fw-medium">Religion</label>
                    <input id="religion" v-model="form.religion" type="text" class="form-control" />
                    <InputError :message="form.errors.religion" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-6">
                    <label for="etnicity" class="form-label text-secondary small text-uppercase fw-medium">Ethnicity</label>
                    <input id="etnicity" v-model="form.ethnicity" type="text" class="form-control" />
                    <InputError :message="form.errors.ethnicity" class="mt-1" />
                  </div>
                  
                  <div class="col-12 col-md-6">
                    <label class="form-label text-secondary small text-uppercase fw-medium d-block">Citizenship</label>
                    <div class="d-flex flex-wrap gap-3 mt-2">
                      <div class="form-check">
                        <input id="filipino" v-model="form.filipino" type="checkbox" class="form-check-input" :checked="form.filipino" />
                        <label class="form-check-label" for="filipino">Filipino</label>
                      </div>
                      <div class="form-check">
                        <input id="dual_citizenship" v-model="form.dual_citizenship" type="checkbox" class="form-check-input" :checked="form.dual_citizenship" />
                        <label class="form-check-label" for="dual_citizenship">Dual Citizenship</label>
                      </div>
                    </div>
                  </div>

                  <template v-if="form.dual_citizenship">
                    <div class="col-12 col-md-6 mt-3">
                      <label class="form-label text-secondary small text-uppercase fw-medium d-block">Dual Citizenship By</label>
                      <div class="d-flex gap-3 mt-2">
                        <div class="form-check">
                          <input id="by_birth" v-model="form.by_birth" type="checkbox" class="form-check-input" />
                          <label class="form-check-label" for="by_birth">Birth</label>
                        </div>
                        <div class="form-check">
                          <input id="by_naturalization" v-model="form.by_naturalization" type="checkbox" class="form-check-input" />
                          <label class="form-check-label" for="by_naturalization">Naturalization</label>
                        </div>
                      </div>
                    </div>
                    <div v-if="form.by_birth || form.by_naturalization" class="col-12 col-md-6 mt-3">
                      <label for="country" class="form-label text-secondary small text-uppercase fw-medium">Country</label>
                      <select id="country" v-model="form.country" class="form-select" :required="form.dual_citizenship">
                        <option value="">Select Country</option>
                        <option v-for="country in countries" :key="country.name" :value="country.name">{{ country.name }}</option>
                      </select>
                      <InputError :message="form.errors.country" class="mt-1" />
                    </div>
                  </template>
                </div>
              </div>
            </div>
          </div>

          <!-- Identification Numbers Card -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
              <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark text-uppercase"><i class="fa-solid fa-id-card text-primary me-2"></i>Identification Numbers</h6>
              </div>
              <div class="card-body p-4">
                <div class="row g-3">
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">UMID No.</label>
                    <input v-model="form.gsis_id_number" type="text" class="form-control" />
                    <InputError :message="form.errors.gsis_id_number" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">PAGIBIG No.</label>
                    <input v-model="form.pagibig_id_number" type="text" class="form-control" />
                    <InputError :message="form.errors.pagibig_id_number" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Philhealth No.</label>
                    <input v-model="form.philhealth_number" type="text" class="form-control" />
                    <InputError :message="form.errors.philhealth_number" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">PhilSys No. (PSN)</label>
                    <input v-model="form.sss_number" type="text" class="form-control" />
                    <InputError :message="form.errors.sss_number" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">TIN No.</label>
                    <input v-model="form.tin_number" type="text" class="form-control" />
                    <InputError :message="form.errors.tin_number" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Agency Employee No.</label>
                    <input v-model="form.agency_employee_number" type="text" class="form-control" />
                    <InputError :message="form.errors.agency_employee_number" class="mt-1" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Residential Address -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
              <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark text-uppercase"><i class="fa-solid fa-house text-primary me-2"></i>Residential Address</h6>
              </div>
              <div class="card-body p-4">
                <div class="row g-3">
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">House/Block/Lot No.</label>
                    <input v-model="form.r_address_house_block_lot_number" type="text" class="form-control" />
                    <InputError :message="form.errors.r_address_house_block_lot_number" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-8">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Street</label>
                    <input v-model="form.r_address_street" type="text" class="form-control" />
                    <InputError :message="form.errors.r_address_street" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Subdivision/Village</label>
                    <input v-model="form.r_address_subdivision_village" type="text" class="form-control" />
                    <InputError :message="form.errors.r_address_subdivision_village" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Barangay</label>
                    <input v-model="form.r_address_barangay" type="text" class="form-control" />
                    <InputError :message="form.errors.r_address_barangay" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">City/Municipality</label>
                    <input v-model="form.r_address_city_municipality" type="text" class="form-control" />
                    <InputError :message="form.errors.r_address_city_municipality" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-8">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Province</label>
                    <input v-model="form.r_address_province" type="text" class="form-control" />
                    <InputError :message="form.errors.r_address_province" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Zipcode</label>
                    <input v-model="form.r_address_zipcode" type="text" class="form-control" />
                    <InputError :message="form.errors.r_address_zipcode" class="mt-1" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Permanent Address -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
              <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h6 class="mb-0 fw-bold text-dark text-uppercase"><i class="fa-solid fa-map-location-dot text-primary me-2"></i>Permanent Address</h6>
                <div class="form-check form-switch mb-0">
                  <input id="same_address" v-model="form.same_address" class="form-check-input" type="checkbox" role="switch" :checked="form.same_address" />
                  <label class="form-check-label text-muted small" for="same_address">Same as residential</label>
                </div>
              </div>
              <div class="card-body p-4">
                <div class="row g-3">
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">House/Block/Lot No.</label>
                    <input v-model="form.p_address_house_block_lot_number" type="text" class="form-control" :disabled="form.same_address" />
                    <InputError :message="form.errors.p_address_house_block_lot_number" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-8">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Street</label>
                    <input v-model="form.p_address_street" type="text" class="form-control" :disabled="form.same_address" />
                    <InputError :message="form.errors.p_address_street" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Subdivision/Village</label>
                    <input v-model="form.p_address_subdivision_village" type="text" class="form-control" :disabled="form.same_address" />
                    <InputError :message="form.errors.p_address_subdivision_village" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Barangay</label>
                    <input v-model="form.p_address_barangay" type="text" class="form-control" :disabled="form.same_address" />
                    <InputError :message="form.errors.p_address_barangay" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">City/Municipality</label>
                    <input v-model="form.p_address_city_municipality" type="text" class="form-control" :disabled="form.same_address" />
                    <InputError :message="form.errors.p_address_city_municipality" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-8">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Province</label>
                    <input v-model="form.p_address_province" type="text" class="form-control" :disabled="form.same_address" />
                    <InputError :message="form.errors.p_address_province" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Zipcode</label>
                    <input v-model="form.p_address_zipcode" type="text" class="form-control" :disabled="form.same_address" />
                    <InputError :message="form.errors.p_address_zipcode" class="mt-1" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Contact Information -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
              <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark text-uppercase"><i class="fa-solid fa-address-book text-primary me-2"></i>Contact Information</h6>
              </div>
              <div class="card-body p-4">
                <div class="row g-3">
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Telephone No.</label>
                    <input v-model="form.telephone_number" type="text" class="form-control" />
                    <InputError :message="form.errors.telephone_number" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Mobile No.</label>
                    <input v-model="form.mobile_number" type="text" class="form-control" />
                    <InputError :message="form.errors.mobile_number" class="mt-1" />
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="form-label text-secondary small text-uppercase fw-medium">Email Address</label>
                    <input v-model="form.email_address" type="email" class="form-control" />
                    <InputError :message="form.errors.email_address" class="mt-1" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Footer Actions -->
          <div class="col-12 mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm">
              <div class="d-flex align-items-center">
                <button type="submit" :disabled="!form.isDirty && form.wasSuccessful" class="btn btn-primary rounded-pill px-4 shadow-sm fw-medium">
                  <Spinner :processing="form.processing" class="me-2" v-if="form.processing" /> 
                  <span v-if="!form.isDirty && form.wasSuccessful"><i class="fa-solid fa-check me-2"></i>Saved</span>
                  <span v-else><i class="fa-solid fa-save me-2" v-if="!form.processing"></i>Save Changes</span>
                </button>
                <span v-if="form.isDirty" class="text-warning ms-3 small fw-medium"><i class="fa-solid fa-triangle-exclamation me-1"></i>Unsaved changes</span>
              </div>
              <div class="d-flex gap-2 mt-3 mt-md-0">
                <Link :href="route('profile.pds.family_background.edit')" as="button" :disabled="form.isDirty" class="btn btn-dark rounded-pill px-4">
                  Next <i v-if="!form.processing" class="fa-solid fa-arrow-right ms-2" />
                </Link>
              </div>
            </div>
          </div>
        </div>
      </form>
    </PDSLayout>
  </AuthenticatedLayout>
</template>

<script setup>
import Spinner from '@/Components/Spinner.vue'
import countries from '@/json/countries.json'
import { useForm, Link } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'

const props = defineProps({
  personal_information: Object,
  profile: Object,
})

const emit = defineEmits(['change-nav'])

let form = useForm({
  surname: props.personal_information ? props.personal_information.surname : props.profile.surname,
  first_name: props.personal_information ? props.personal_information.first_name : props.profile.first_name,
  middle_name: props.personal_information ? props.personal_information.middle_name : props.profile.middle_name,
  name_extension: props.personal_information ? props.personal_information.name_extension : props.profile.name_extension,
  date_of_birth: props.personal_information ? props.personal_information.date_of_birth : null,
  place_of_birth: props.personal_information ? props.personal_information.place_of_birth : null,
  sex: props.personal_information ? props.personal_information.sex : null,
  height: props.personal_information ? props.personal_information.height : null,
  weight: props.personal_information ? props.personal_information.weight : null,
  blood_type: props.personal_information ? props.personal_information.blood_type : null,
  gsis_id_number: props.personal_information ? props.personal_information.gsis_id_number : null,
  pagibig_id_number: props.personal_information ? props.personal_information.pagibig_id_number : null,
  sss_number: props.personal_information ? props.personal_information.sss_number : null,
  philhealth_number: props.personal_information ? props.personal_information.philhealth_number : null,
  tin_number: props.personal_information ? props.personal_information.tin_number : null,
  agency_employee_number: props.personal_information ? props.personal_information.agency_employee_number : null,
  r_address_house_block_lot_number: props.personal_information ? props.personal_information.r_address_house_block_lot_number : null,
  r_address_street: props.personal_information ? props.personal_information.r_address_street : null,
  r_address_subdivision_village: props.personal_information ? props.personal_information.r_address_subdivision_village : null,
  r_address_barangay: props.personal_information ? props.personal_information.r_address_barangay : null,
  r_address_city_municipality: props.personal_information ? props.personal_information.r_address_city_municipality : null,
  r_address_zipcode: props.personal_information ? props.personal_information.r_address_zipcode : null,
  r_address_province: props.personal_information ? props.personal_information.r_address_province : null,
  ethnicity: props.personal_information ? props.personal_information.ethnicity : null,
  religion: props.personal_information ? props.personal_information.religion : null,

  p_address_house_block_lot_number: props.personal_information ? props.personal_information.p_address_house_block_lot_number : null,
  p_address_street: props.personal_information ? props.personal_information.p_address_street : null,
  p_address_subdivision_village: props.personal_information ? props.personal_information.p_address_subdivision_village : null,
  p_address_barangay: props.personal_information ? props.personal_information.p_address_barangay : null,
  p_address_city_municipality: props.personal_information ? props.personal_information.p_address_city_municipality : null,
  p_address_zipcode: props.personal_information ? props.personal_information.p_address_zipcode : null,
  p_address_province: props.personal_information ? props.personal_information.p_address_province : null,

  telephone_number: props.personal_information ? props.personal_information.telephone_number : null,
  mobile_number: props.personal_information ? props.personal_information.mobile_number : null,
  email_address: props.personal_information ? props.personal_information.email_address : null,

  civil_status: props.personal_information ? props.personal_information.civil_status : null,
  other_civil_status: props.personal_information ? props.personal_information.other_civil_status : null,
  dual_citizenship: props.personal_information ? props.personal_information.dual_citizenship == 1 : false,
  filipino: props.personal_information ? props.personal_information.filipino == 1 : false,
  by_birth: props.personal_information ? props.personal_information.by_birth == 1 : false,
  by_naturalization: props.personal_information ? props.personal_information.by_naturalization == 1 : false,
  country: props.personal_information ? props.personal_information.country : null,
  same_address: props.personal_information ? props.personal_information.same_address == 1 : false,
})


const create_update_personal_info = () => {
  form.post(route('profile.pds.personal_information.store_or_update'), {
    preserveScroll: true,
  })
}

</script>
