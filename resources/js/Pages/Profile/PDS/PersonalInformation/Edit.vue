
<template>
  <AuthenticatedLayout>
    <PDSLayout :is-form-dirty="form.isDirty">
      <form @submit.prevent="create_update_personal_info">
        <div class="row">
          <!-- PERSONAL INFORMATION -->
          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="surname" class="form-label">Surname</label>
              <input id="surname" v-model="form.surname" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.surname" />
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="first_name" class="form-label">First Name</label>
              <input
                id="first_name" v-model="form.first_name" type="text"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.first_name" />
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="middle_name" class="form-label">Middle Name</label>
              <input
                id="middle_name" v-model="form.middle_name" type="text"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.middle_name" />
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="name_extension" class="form-label">Name Extension</label>
              <input
                id="name_extension" v-model="form.name_extension" type="text"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.name_extension" />
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="date_of_birth" class="form-label">Date of Birth</label>
              <input
                id="date_of_birth" v-model="form.date_of_birth" type="date"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.date_of_birth" />
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="place_of_birth" class="form-label">Place of Birth</label>
              <input
                id="place_of_birth" v-model="form.place_of_birth" type="text"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.place_of_birth" />
            </div>
          </div>

          <!-- GENDER -->

          <div class="col-12 col-md-2">
            <div class="mb-3">
              <label for="sex" class="form-label">Sex</label>
              <div class="form-check">
                <input
                  id="male" v-model="form.sex" type="radio" class="form-check-input" name="sex"
                  value="male"
                />
                <label class="form-check-label" for="male">Male</label>
              </div>
              <div class="form-check">
                <input
                  id="female" v-model="form.sex" type="radio" class="form-check-input" name="sex"
                  value="female"
                />
                <label class="form-check-label" for="female">Female</label>
              </div>
              <InputError :message="form.errors.sex" />
            </div>
          </div>

          <!-- CIVIL STATUS -->
          <div class="col-12 col-md-4">
            <div class="mb-3">
              <label for="sex" class="form-label">Civil Status</label>
              <div class="d-flex gap-2">
                <div>
                  <div class="form-check">
                    <input
                      id="single" v-model="form.civil_status" type="radio" class="form-check-input"
                      name="civil_status" value="single"
                    />
                    <label class="form-check-label" for="single">Single</label>
                  </div>
                  <div class="form-check">
                    <input
                      id="married" v-model="form.civil_status" type="radio"
                      class="form-check-input" name="civil_status" value="married"
                    />
                    <label class="form-check-label" for="married">Married</label>
                  </div>
                </div>
                <div>
                  <div class="form-check">
                    <input
                      id="widowed" v-model="form.civil_status" type="radio"
                      class="form-check-input" name="civil_status" value="widowed"
                    />
                    <label class="form-check-label" for="widowed">Widowed</label>
                  </div>
                  <div class="form-check">
                    <input
                      id="separated" v-model="form.civil_status" type="radio"
                      class="form-check-input" name="civil_status" value="separated"
                    />
                    <label class="form-check-label" for="separated">Separated</label>
                  </div>
                </div>
                <div>
                  <div class="form-check">
                    <input
                      id="others" v-model="form.civil_status" type="radio" class="form-check-input"
                      name="civil_status" value="others"
                    />
                    <label class="form-check-label" for="others">Others</label>
                  </div>
                  <div class="form-group">
                    <input
                      v-if="form.civil_status === 'others'" id="others" v-model="form.other_civil_status"
                      type="text" placeholder="Type here" :required="form.civil_status"
                      class="form-control form-control-sm" name="civil_status"
                    />
                  </div>
                </div>
              </div>
              <InputError :message="form.errors.civil_status" />
            </div>
          </div>

          <div class="col-12 col-md-2">
            <div class="mb-3">
              <label for="height" class="form-label">Height (m)</label>
              <input id="height" v-model="form.height" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.height" />
            </div>
          </div>

          <div class="col-12 col-md-2">
            <div class="mb-3">
              <label for="weight" class="form-label">Weight (kg)</label>
              <input id="weight" v-model="form.weight" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.weight" />
            </div>
          </div>

          <div class="col-12 col-md-2">
            <div class="mb-3">
              <label for="blood_type" class="form-label">Blood Type</label>
              <input v-model="form.blood_type" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.blood_type" />
            </div>
          </div>

          <div class="col-12 col-md-2">
            <div class="mb-3">
              <label for="gsis_id_number" class="form-label">GSIS No.</label>
              <input v-model="form.gsis_id_number" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.gsis_id_number" />
            </div>
          </div>

          <div class="col-12 col-md-2">
            <div class="mb-3">
              <label class="form-label">PAGIBIG No.</label>
              <input v-model="form.pagibig_id_number" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.pagibig_id_number" />
            </div>
          </div>

          <div class="col-12 col-md-2">
            <div class="mb-3">
              <label class="form-label">Philhealth No.</label>
              <input v-model="form.philhealth_number" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.philhealth_number" />
            </div>
          </div>

          <div class="col-12 col-md-2">
            <div class="mb-3">
              <label class="form-label">SSS No.</label>
              <input v-model="form.sss_number" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.sss_number" />
            </div>
          </div>

          <div class="col-12 col-md-2">
            <div class="mb-3">
              <label class="form-label">TIN No.</label>
              <input v-model="form.tin_number" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.tin_number" />
            </div>
          </div>

          <div class="col-12 col-md-2">
            <div class="mb-3">
              <label class="form-label">Agency Employee No.</label>
              <input v-model="form.agency_employee_number" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.agency_employee_number" />
            </div>
          </div>


          <div class="col-12 col-md-2">
            <div class="mb-3">
              <label for="filipino" class="form-label">Citizenship</label>
              <div class="form-check">
                <input
                  id="filipino" v-model="form.filipino" type="checkbox" class="form-check-input"
                  :checked="form.filipino" name="filipino"
                />
                <label class="form-check-label" for="filipino">Filipino</label>
              </div>
              <div class="form-check">
                <input
                  id="dual_citizenship" v-model="form.dual_citizenship" type="checkbox"
                  class="form-check-input" name="dual_citizenship"
                  :checked="form.dual_citizenship"
                />
                <label class="form-check-label" for="dual_citizenship">Dual Citizenship</label>
              </div>
            </div>
          </div>

          <div v-if="form.dual_citizenship" class="col-12 col-md-2">
            <label for="dual_citizenship" class="form-label">Dual Citizenship</label>

            <div class="form-check">
              <input id="by_birth" v-model="form.by_birth" type="checkbox" class="form-check-input" />
              <label class="form-check-label" for="by_birth">by birth</label>
            </div>

            <div class="form-check">
              <input
                id="by_naturalization" v-model="form.by_naturalization" type="checkbox"
                class="form-check-input"
              />
              <label class="form-check-label" for="by_naturalization">by naturalization</label>
            </div>
          </div>

          <div
            v-if="form.dual_citizenship &&
              (form.by_birth || form.by_naturalization)
            " class="col-12 col-md-2"
          >
            <div class="mb-3">
              <label for="country" class="form-label">Country</label>
              <select
                id="country" v-model="form.country" type="text" class="form-control form-control-sm"
                :required="form.dual_citizenship"
              >
                <option value="">Select Country</option>
                <option v-for="country in countries" :value="country.name">
                  {{ country.name }}
                </option>
              </select>
              <InputError :message="form.errors.country" />
            </div>
          </div>

          <!-- RESIDENTIAL ADDRESS -->

          <div class="col-12">
            <h5>Residential Address</h5>
          </div>

          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">House/Block/Lot No.</label>
              <input
                v-model="form.r_address_house_block_lot_number" type="text"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.r_address_house_block_lot_number" />
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Street</label>
              <input v-model="form.r_address_street" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.r_address_street" />
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Subdivision/Village</label>
              <input
                v-model="form.r_address_subdivision_village" type="text"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.r_address_subdivision_village" />
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Barangay</label>
              <input v-model="form.r_address_barangay" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.r_address_barangay" />
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">City/Municipality</label>
              <input
                v-model="form.r_address_city_municipality" type="text"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.r_address_city_municipality" />
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Province</label>
              <input v-model="form.r_address_province" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.r_address_province" />
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Zipcode</label>
              <input v-model="form.r_address_zipcode" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.r_address_zipcode" />
            </div>
          </div>

          <!-- PERMANENT ADDRESS -->

          <div class="col-12">
            <div class="d-flex gap-3">
              <h5>Permanent Address</h5>
              <div class="form-check">
                <input
                  id="same_address" v-model="form.same_address" type="checkbox"
                  class="form-check-input" :checked="form.same_address == 1" name="same_address"
                />
                <label class="form-check-label" for="same_address">Same as residential address.</label>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">House/Block/Lot No.</label>
              <input
                v-model="form.p_address_house_block_lot_number" type="text" :disabled="form.same_address"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.p_address_house_block_lot_number" />
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Street</label>
              <input
                v-model="form.p_address_street" type="text" :disabled="form.same_address"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.p_address_street" />
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Subdivision/Village</label>
              <input
                v-model="form.p_address_subdivision_village" type="text" :disabled="form.same_address"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.p_address_subdivision_village" />
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Barangay</label>
              <input
                v-model="form.p_address_barangay" type="text" :disabled="form.same_address"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.p_address_barangay" />
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">City/Municipality</label>
              <input
                v-model="form.p_address_city_municipality" type="text" :disabled="form.same_address"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.p_address_city_municipality" />
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Province</label>
              <input
                v-model="form.p_address_province" type="text" :disabled="form.same_address"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.p_address_province" />
            </div>
          </div>
          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Zipcode</label>
              <input
                v-model="form.p_address_zipcode" type="text" :disabled="form.same_address"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.p_address_zipcode" />
            </div>
          </div>

          <!-- Contact Information -->
          <div class="col-12">
            <h5>Contact Information</h5>
          </div>

          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Telephone No.</label>
              <input v-model="form.telephone_number" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.telephone_number" />
            </div>
          </div>

          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Mobile No.</label>
              <input v-model="form.mobile_number" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.mobile_number" />
            </div>
          </div>

          <div class="col-12 col-md-3">
            <div class="mb-3">
              <label class="form-label">Email Address</label>
              <input
                v-model="form.email_address" type="email" style="text-transform: none;"
                class="form-control form-control-sm"
              />
              <InputError :message="form.errors.email_address" />
            </div>
          </div>

          <div class="col-12">
            <div class="d-flex justify-content-between">
              <div>
                <button
                  type="submit" :disabled="!form.isDirty && form.wasSuccessful"
                  class="btn btn-success"
                >
                  <Spinner :processing="form.processing" /> 
                  <span
                    v-if="!form.isDirty &&
                      form.wasSuccessful"
                  ><i class="bi-file-earmark-check" /> Saved</span>
                  <span v-else><i v-if="!form.processing" class="bi-file-earmark-arrow-up" /> Save</span>
                </button>
                <b v-if="form.isDirty" class="text-danger form-status ms-2">Not Saved</b>
              </div>
              <div class="d-flex gap-2">
                <Link
                  :href="route('profile.pds.family_background.edit')" as="button"
                  :disabled="form.isDirty" class="btn btn-dark"
                >
                  <i v-if="!form.processing" class="fa-solid fa-arrow-right" />
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


// if (props.personal_information) {
//   form = useForm({
//     surname: props.personal_information.surname,
//     first_name: props.personal_information.first_name,
//     middle_name: props.personal_information.middle_name,
//     name_extension: props.personal_information.name_extension,
//     date_of_birth: props.personal_information.date_of_birth,
//     place_of_birth: props.personal_information.place_of_birth,
//     sex: props.personal_information.sex,
//     height: props.personal_information.height,
//     weight: props.personal_information.weight,
//     blood_type: props.personal_information.blood_type,
//     gsis_id_number: props.personal_information.gsis_id_number,
//     pagibig_id_number: props.personal_information.pagibig_id_number,
//     sss_number: props.personal_information.sss_number,
//     philhealth_number: props.personal_information.philhealth_number,
//     tin_number: props.personal_information.tin_number,
//     agency_employee_number: props.personal_information.agency_employee_number,
//     r_address_house_block_lot_number: props.personal_information.r_address_house_block_lot_number,
//     r_address_street: props.personal_information.r_address_street,
//     r_address_subdivision_village: props.personal_information.r_address_subdivision_village,
//     r_address_barangay: props.personal_information.r_address_barangay,
//     r_address_city_municipality: props.personal_information.r_address_city_municipality,
//     r_address_zipcode: props.personal_information.r_address_zipcode,
//     r_address_province: props.personal_information.r_address_province,

//     p_address_house_block_lot_number: props.personal_information.p_address_house_block_lot_number,
//     p_address_street: props.personal_information.p_address_street,
//     p_address_subdivision_village: props.personal_information.p_address_subdivision_village,
//     p_address_barangay: props.personal_information.p_address_barangay,
//     p_address_city_municipality: props.personal_information.p_address_city_municipality,
//     p_address_zipcode: props.personal_information.p_address_zipcode,
//     p_address_province: props.personal_information.p_address_province,

//     telephone_number: props.personal_information.telephone_number,
//     mobile_number: props.personal_information.mobile_number,
//     email_address: props.personal_information.email_address,

//     civil_status: props.personal_information.civil_status,
//     other_civil_status: props.personal_information.other_civil_status,
//     dual_citizenship: props.personal_information.dual_citizenship == 1,
//     filipino: props.personal_information.filipino == 1,
//     by_birth: props.personal_information.by_birth == 1,
//     by_naturalization: props.personal_information.by_naturalization == 1,
//     country: props.personal_information.country,
//     same_address: props.personal_information.same_address == 1,
//   })
// } else {
//   form = useForm({
//     surname: null,
//     first_name: null,
//     middle_name: null,
//     name_extension: null,
//     date_of_birth: null,
//     place_of_birth: null,
//     sex: null,
//     height: null,
//     weight: null,
//     blood_type: null,
//     gsis_id_number: null,
//     pagibig_id_number: null,
//     sss_number: null,
//     philhealth_number: null,
//     tin_number: null,
//     agency_employee_number: null,
//     r_address_house_block_lot_number: null,
//     r_address_street: null,
//     r_address_subdivision_village: null,
//     r_address_barangay: null,
//     r_address_city_municipality: null,
//     r_address_zipcode: null,
//     r_address_province: null,

//     p_address_house_block_lot_number: null,
//     p_address_street: null,
//     p_address_subdivision_village: null,
//     p_address_barangay: null,
//     p_address_city_municipality: null,
//     p_address_zipcode: null,
//     p_address_province: null,

//     telephone_number: null,
//     mobile_number: null,
//     email_address: null,

//     civil_status: null,
//     other_civil_status: null,
//     dual_citizenship: false,
//     filipino: false,
//     by_birth: false,
//     by_naturalization: false,
//     country: null,
//     same_address: false,
//   })
// }

const create_update_personal_info = () => {
  form.post(route('profile.pds.personal_information.store_or_update'), {
    preserveScroll: true,
  })
}

</script>
