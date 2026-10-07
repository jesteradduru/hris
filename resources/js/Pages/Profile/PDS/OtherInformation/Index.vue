<template>
  <AuthenticatedLayout>
    <PDSLayout :is-form-dirty="form.isDirty">
      
      <!-- Special Skills & Hobbies / Memberships -->
      <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
              <i class="fa-solid fa-star text-primary"></i>
            </div>
            <h5 class="mb-0 fw-bold text-dark">Special Skills and Hobbies &amp; Memberships</h5>
          </div>
          <Link class="btn btn-outline-primary btn-sm rounded-pill px-3" :href="route('profile.pds.other_information.edit')">
            <i class="fa-solid fa-pen me-1"></i> Edit
          </Link>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-sm">
              <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem;">
                <tr>
                  <th class="ps-4 w-50">Special Skills and Hobbies</th>
                  <th class="w-50">Membership in Association / Organization</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="ps-4 p-3 align-top">
                    <BulletedList :lists="skills" v-if="skills.length" />
                    <span v-else class="text-muted fst-italic small">No special skills listed.</span>
                  </td>
                  <td class="p-3 align-top">
                    <BulletedList :lists="membership_in_assoc_org" v-if="membership_in_assoc_org.length" />
                    <span v-else class="text-muted fst-italic small">No memberships listed.</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
      <!-- 34-40 Questions -->
      <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
          <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
            <i class="fa-solid fa-clipboard-question text-primary"></i>
          </div>
          <h5 class="mb-0 fw-bold text-dark">Questionnaire (Items 34-40)</h5>
        </div>
        <div class="card-body p-4 bg-light bg-opacity-50">
          <form @submit.prevent="save">
            <div class="d-flex flex-column gap-4">
              
              <!-- Q34 -->
              <div class="bg-white p-4 rounded-4 shadow-sm border">
                <p class="fw-medium mb-3">34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be apppointed,</p>
                <div class="ps-4 border-start border-3 border-primary ms-2 mb-3">
                  <label class="form-label mb-2">a. within the third degree?</label>
                  <div class="d-flex gap-4 mb-2">
                    <div class="form-check custom-radio">
                      <input id="34.a.yes" v-model="form.thirty_four_a" class="form-check-input" type="radio" value="Yes" />
                      <label class="form-check-label" for="34.a.yes">Yes</label>
                    </div>
                    <div class="form-check custom-radio">
                      <input id="34.a.no" v-model="form.thirty_four_a" class="form-check-input" type="radio" value="No" />
                      <label class="form-check-label" for="34.a.no">No</label>
                    </div>
                  </div>
                  <InputError :message="form.errors.thirty_four_a" />
                </div>
                
                <div class="ps-4 border-start border-3 border-primary ms-2 mb-3">
                  <label class="form-label mb-2">b. within the fourth degree (for Local Government Unit - Career Employees)?</label>
                  <div class="d-flex gap-4 mb-2">
                    <div class="form-check custom-radio">
                      <input id="34.b.yes" v-model="form.thirty_four_b" class="form-check-input" type="radio" value="Yes" />
                      <label class="form-check-label" for="34.b.yes">Yes</label>
                    </div>
                    <div class="form-check custom-radio">
                      <input id="34.b.no" v-model="form.thirty_four_b" class="form-check-input" type="radio" value="No" />
                      <label class="form-check-label" for="34.b.no">No</label>
                    </div>
                  </div>
                  <InputError :message="form.errors.thirty_four_b" />
                </div>

                <div v-if="_34_both_yes" class="mt-3">
                  <input v-model="form.thirty_four_a_b_if_yes" type="text" class="form-control" placeholder="If yes, give details:" />
                  <InputError :message="form.errors.thirty_four_a_b_if_yes" class="mt-1" />
                </div>
              </div>

              <!-- Q35 -->
              <div class="bg-white p-4 rounded-4 shadow-sm border">
                <div class="mb-4">
                  <p class="fw-medium mb-3">35. a. Have you ever been found guilty of any administrative offense?</p>
                  <div class="d-flex gap-4 mb-2 ms-2">
                    <div class="form-check custom-radio">
                      <input id="35.a.yes" v-model="form.thirty_five_a" class="form-check-input" type="radio" value="Yes" />
                      <label class="form-check-label" for="35.a.yes">Yes</label>
                    </div>
                    <div class="form-check custom-radio">
                      <input id="35.a.no" v-model="form.thirty_five_a" class="form-check-input" type="radio" value="No" />
                      <label class="form-check-label" for="35.a.no">No</label>
                    </div>
                  </div>
                  <InputError :message="form.errors.thirty_five_a" />
                  <div v-if="form.thirty_five_a === 'Yes'" class="mt-3">
                    <input v-model="form.thirty_five_a_if_yes" type="text" class="form-control" placeholder="If yes, give details:" />
                    <InputError :message="form.errors.thirty_five_a_if_yes" class="mt-1" />
                  </div>
                </div>

                <div>
                  <p class="fw-medium mb-3">b. Have you been criminally charged before any court?</p>
                  <div class="d-flex gap-4 mb-2 ms-2">
                    <div class="form-check custom-radio">
                      <input id="35.b.yes" v-model="form.thirty_five_b" class="form-check-input" type="radio" value="Yes" />
                      <label class="form-check-label" for="35.b.yes">Yes</label>
                    </div>
                    <div class="form-check custom-radio">
                      <input id="35.b.no" v-model="form.thirty_five_b" class="form-check-input" type="radio" value="No" />
                      <label class="form-check-label" for="35.b.no">No</label>
                    </div>
                  </div>
                  <InputError :message="form.errors.thirty_five_b" />
                  <div v-if="form.thirty_five_b === 'Yes'" class="mt-3 row g-2">
                    <div class="col-md-6">
                      <input v-model="form.thirty_five_b_if_yes_date" type="text" class="form-control" placeholder="Date Filed" />
                      <InputError :message="form.errors.thirty_five_b_if_yes_date" class="mt-1" />
                    </div>
                    <div class="col-md-6">
                      <input v-model="form.thirty_five_b_if_yes_case" type="text" class="form-control" placeholder="Status of Case/s" />
                      <InputError :message="form.errors.thirty_five_b_if_yes_case" class="mt-1" />
                    </div>
                  </div>
                </div>
              </div>

              <!-- Q36 -->
              <div class="bg-white p-4 rounded-4 shadow-sm border">
                <p class="fw-medium mb-3">36. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</p>
                <div class="d-flex gap-4 mb-2 ms-2">
                  <div class="form-check custom-radio">
                    <input id="36.a.yes" v-model="form.thirty_six" class="form-check-input" type="radio" value="Yes" />
                    <label class="form-check-label" for="36.a.yes">Yes</label>
                  </div>
                  <div class="form-check custom-radio">
                    <input id="36.a.no" v-model="form.thirty_six" class="form-check-input" type="radio" value="No" />
                    <label class="form-check-label" for="36.a.no">No</label>
                  </div>
                </div>
                <InputError :message="form.errors.thirty_six" />
                <div v-if="form.thirty_six === 'Yes'" class="mt-3">
                  <input v-model="form.thirty_six_if_yes" type="text" class="form-control" placeholder="If yes, give details:" />
                  <InputError :message="form.errors.thirty_six_if_yes" class="mt-1" />
                </div>
              </div>

              <!-- Q37 -->
              <div class="bg-white p-4 rounded-4 shadow-sm border">
                <p class="fw-medium mb-3">37. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</p>
                <div class="d-flex gap-4 mb-2 ms-2">
                  <div class="form-check custom-radio">
                    <input id="37.a.yes" v-model="form.thirty_seven" class="form-check-input" type="radio" value="Yes" />
                    <label class="form-check-label" for="37.a.yes">Yes</label>
                  </div>
                  <div class="form-check custom-radio">
                    <input id="37.a.no" v-model="form.thirty_seven" class="form-check-input" type="radio" value="No" />
                    <label class="form-check-label" for="37.a.no">No</label>
                  </div>
                </div>
                <InputError :message="form.errors.thirty_seven" />
                <div v-if="form.thirty_seven === 'Yes'" class="mt-3">
                  <input v-model="form.thirty_seven_if_yes" type="text" class="form-control" placeholder="If yes, give details:" />
                  <InputError :message="form.errors.thirty_seven_if_yes" class="mt-1" />
                </div>
              </div>

              <!-- Q38 -->
              <div class="bg-white p-4 rounded-4 shadow-sm border">
                <div class="mb-4">
                  <p class="fw-medium mb-3">38. a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?</p>
                  <div class="d-flex gap-4 mb-2 ms-2">
                    <div class="form-check custom-radio">
                      <input id="38.a.yes" v-model="form.thirty_eight_a" class="form-check-input" type="radio" value="Yes" />
                      <label class="form-check-label" for="38.a.yes">Yes</label>
                    </div>
                    <div class="form-check custom-radio">
                      <input id="38.a.no" v-model="form.thirty_eight_a" class="form-check-input" type="radio" value="No" />
                      <label class="form-check-label" for="38.a.no">No</label>
                    </div>
                  </div>
                  <InputError :message="form.errors.thirty_eight_a" />
                  <div v-if="form.thirty_eight_a === 'Yes'" class="mt-3">
                    <input v-model="form.thirty_eight_a_if_yes" type="text" class="form-control" placeholder="If yes, give details:" />
                    <InputError :message="form.errors.thirty_eight_a_if_yes" class="mt-1" />
                  </div>
                </div>

                <div>
                  <p class="fw-medium mb-3">b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</p>
                  <div class="d-flex gap-4 mb-2 ms-2">
                    <div class="form-check custom-radio">
                      <input id="38.b.yes" v-model="form.thirty_eight_b" class="form-check-input" type="radio" value="Yes" />
                      <label class="form-check-label" for="38.b.yes">Yes</label>
                    </div>
                    <div class="form-check custom-radio">
                      <input id="38.b.no" v-model="form.thirty_eight_b" class="form-check-input" type="radio" value="No" />
                      <label class="form-check-label" for="38.b.no">No</label>
                    </div>
                  </div>
                  <InputError :message="form.errors.thirty_eight_b" />
                  <div v-if="form.thirty_eight_b === 'Yes'" class="mt-3">
                    <input v-model="form.thirty_eight_b_if_yes" type="text" class="form-control" placeholder="If yes, give details:" />
                    <InputError :message="form.errors.thirty_eight_b_if_yes" class="mt-1" />
                  </div>
                </div>
              </div>

              <!-- Q39 -->
              <div class="bg-white p-4 rounded-4 shadow-sm border">
                <p class="fw-medium mb-3">39. Have you acquired the status of an immigrant or permanent resident of another country?</p>
                <div class="d-flex gap-4 mb-2 ms-2">
                  <div class="form-check custom-radio">
                    <input id="39.a.yes" v-model="form.thirty_nine" class="form-check-input" type="radio" value="Yes" />
                    <label class="form-check-label" for="39.a.yes">Yes</label>
                  </div>
                  <div class="form-check custom-radio">
                    <input id="39.a.no" v-model="form.thirty_nine" class="form-check-input" type="radio" value="No" />
                    <label class="form-check-label" for="39.a.no">No</label>
                  </div>
                </div>
                <InputError :message="form.errors.thirty_nine" />
                <div v-if="form.thirty_nine === 'Yes'" class="mt-3">
                  <input v-model="form.thirty_nine_if_yes" type="text" class="form-control" placeholder="If yes, give details (country)" />
                  <InputError :message="form.errors.thirty_nine_if_yes" class="mt-1" />
                </div>
              </div>

              <!-- Q40 -->
              <div class="bg-white p-4 rounded-4 shadow-sm border">
                <p class="fw-medium mb-3">40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</p>
                
                <div class="ps-4 border-start border-3 border-primary ms-2 mb-3">
                  <label class="form-label mb-2">a. Are you a member of any indigenous group?</label>
                  <div class="d-flex gap-4 mb-2">
                    <div class="form-check custom-radio">
                      <input id="40.a.yes" v-model="form.fourty_a" class="form-check-input" type="radio" value="Yes" />
                      <label class="form-check-label" for="40.a.yes">Yes</label>
                    </div>
                    <div class="form-check custom-radio">
                      <input id="40.a.no" v-model="form.fourty_a" class="form-check-input" type="radio" value="No" />
                      <label class="form-check-label" for="40.a.no">No</label>
                    </div>
                  </div>
                  <InputError :message="form.errors.fourty_a" />
                  <div v-if="form.fourty_a === 'Yes'" class="mt-2">
                    <input v-model="form.fourty_a_if_yes" type="text" class="form-control" placeholder="If yes, give details:" />
                    <InputError :message="form.errors.fourty_a_if_yes" class="mt-1" />
                  </div>
                </div>

                <div class="ps-4 border-start border-3 border-primary ms-2 mb-3">
                  <label class="form-label mb-2">b. Are you a person with disability?</label>
                  <div class="d-flex gap-4 mb-2">
                    <div class="form-check custom-radio">
                      <input id="40.b.yes" v-model="form.fourty_b" class="form-check-input" type="radio" value="Yes" />
                      <label class="form-check-label" for="40.b.yes">Yes</label>
                    </div>
                    <div class="form-check custom-radio">
                      <input id="40.b.no" v-model="form.fourty_b" class="form-check-input" type="radio" value="No" />
                      <label class="form-check-label" for="40.b.no">No</label>
                    </div>
                  </div>
                  <InputError :message="form.errors.fourty_b" />
                  <div v-if="form.fourty_b === 'Yes'" class="mt-2">
                    <input v-model="form.fourty_b_if_yes" type="text" class="form-control" placeholder="If yes, please specify ID No:" />
                    <InputError :message="form.errors.fourty_b_if_yes" class="mt-1" />
                  </div>
                </div>

                <div class="ps-4 border-start border-3 border-primary ms-2 mb-3">
                  <label class="form-label mb-2">c. Are you a solo parent?</label>
                  <div class="d-flex gap-4 mb-2">
                    <div class="form-check custom-radio">
                      <input id="40.c.yes" v-model="form.fourty_c" class="form-check-input" type="radio" value="Yes" />
                      <label class="form-check-label" for="40.c.yes">Yes</label>
                    </div>
                    <div class="form-check custom-radio">
                      <input id="40.c.no" v-model="form.fourty_c" class="form-check-input" type="radio" value="No" />
                      <label class="form-check-label" for="40.c.no">No</label>
                    </div>
                  </div>
                  <InputError :message="form.errors.fourty_c" />
                  <div v-if="form.fourty_c === 'Yes'" class="mt-2">
                    <input v-model="form.fourty_c_if_yes" type="text" class="form-control" placeholder="If yes, please specify ID No:" />
                    <InputError :message="form.errors.fourty_c_if_yes" class="mt-1" />
                  </div>
                </div>

              </div>
            </div>

            <hr class="my-4">
            <div class="d-flex justify-content-between align-items-center">
              <span v-if="form.isDirty" class="text-warning small fw-medium"><i class="fa-solid fa-triangle-exclamation me-1"></i>Unsaved changes in Questionnaire</span>
              <span v-else></span>
              <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm" :disabled="!form.isDirty && form.wasSuccessful">
                <Spinner :processing="form.processing" class="me-2" v-if="form.processing" /> 
                <span v-if="!form.isDirty && form.wasSuccessful"><i class="fa-solid fa-check me-2"></i>Saved</span>
                <span v-else><i class="fa-solid fa-save me-2" v-if="!form.processing"></i>Save Questionnaire</span>
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- References & ID -->
      <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
              <i class="fa-solid fa-id-card text-primary"></i>
            </div>
            <h5 class="mb-0 fw-bold text-dark">References and Valid ID</h5>
          </div>
          <Link class="btn btn-outline-primary btn-sm rounded-pill px-3" :href="route('profile.pds.reference_id.edit')">
            <i class="fa-solid fa-pen me-1"></i> Edit
          </Link>
        </div>
        <div class="card-body p-4">
          
          <h6 class="fw-bold mb-3 text-secondary text-uppercase small">Character References</h6>
          <div class="table-responsive mb-4">
            <table class="table table-hover align-middle border mb-0 text-sm">
              <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem;">
                <tr>
                  <th class="ps-3">Name</th>
                  <th>Address</th>
                  <th>Contact Information</th>
                </tr>
              </thead>
              <tbody v-if="props.reference_id">
                <tr>
                  <td class="ps-3 fw-medium">{{ props.reference_id.references_name_one || '-' }}</td>
                  <td>{{ props.reference_id.references_address_one || '-' }}</td>
                  <td>{{ props.reference_id.references_telephone_one || '-' }}</td>
                </tr>
                <tr>
                  <td class="ps-3 fw-medium">{{ props.reference_id.references_name_two || '-' }}</td>
                  <td>{{ props.reference_id.references_address_two || '-' }}</td>
                  <td>{{ props.reference_id.references_telephone_two || '-' }}</td>
                </tr>
                <tr>
                  <td class="ps-3 fw-medium">{{ props.reference_id.references_name_three || '-' }}</td>
                  <td>{{ props.reference_id.references_address_three || '-' }}</td>
                  <td>{{ props.reference_id.references_telephone_three || '-' }}</td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td colspan="3" class="text-center py-4 text-muted fst-italic">No references provided.</td>
                </tr>
              </tbody>
            </table>
          </div>

          <h6 class="fw-bold mb-3 text-secondary text-uppercase small">Government Issued ID</h6>
          <div class="bg-light bg-opacity-50 border rounded-4 p-3">
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <span class="d-block text-muted small text-uppercase fw-medium">ID Type</span>
                <span class="fw-medium text-dark">{{ props.reference_id?.government_issued_id || '-' }}</span>
              </div>
              <div class="col-12 col-md-6">
                <span class="d-block text-muted small text-uppercase fw-medium">ID / License / Passport No.</span>
                <span class="fw-medium text-dark">{{ props.reference_id?.id_license_passport_number || '-' }}</span>
              </div>
              <div class="col-12 col-md-6">
                <span class="d-block text-muted small text-uppercase fw-medium">Date / Place of Issuance</span>
                <span class="fw-medium text-dark">{{ props.reference_id?.date_place_of_issuance || '-' }}</span>
              </div>
              <div class="col-12 col-md-6">
                <span class="d-block text-muted small text-uppercase fw-medium">Scanned Copy</span>
                <span v-if="reference_id?.files && reference_id.files.length" class="fw-medium">
                  <a target="_blank" :href="reference_id.files[0].src" class="text-decoration-none">
                    <i class="fa-solid fa-paperclip me-1 text-muted"></i>{{ reference_id.files[0].filename }}
                  </a>
                </span>
                <span v-else class="text-dark">-</span>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="col-12 mt-4">
        <div class="d-flex justify-content-end gap-2">
          <Link :href="route('profile.pds.learning_and_development.index')" type="button" class="btn btn-outline-dark rounded-pill px-4">
            <i class="fa-solid fa-arrow-left me-2" /> Back
          </Link>
          <Link :href="route('profile.pds.page_four_questions.edit')" type="button" class="btn btn-dark rounded-pill px-4">
            Next <i class="fa-solid fa-arrow-right ms-2" />
          </Link>
        </div>
      </div>
      
    </PDSLayout>
  </AuthenticatedLayout>
</template>
    
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'
import BulletedList from '@/Components/BulletedList.vue'
import Accordion from '@/Components/Accordion.vue'
import { computed } from 'vue'
import Spinner from '@/Components/Spinner.vue'
import InputError from '@/Components/InputError.vue'
    
const props = defineProps({
  other_information: Object,
  questions: Object,
  distinctions: Object,
  reference_id: Object,
})
    
const skills = computed(() => {
  return props.other_information?.special_skills_hobbies ? props.other_information.special_skills_hobbies.split(',').filter((list) => {
    const trimList = list.trim()
    return trimList !== ''
  }) : []
})

const none_academic_distinctions = computed(() => {
  return props.other_information?.none_academic_distinctions ? props.other_information.none_academic_distinctions.split(',').filter((list) => {
    const trimList = list.trim()
    return trimList !== ''
  }) : []
})

const membership_in_assoc_org = computed(() => {
  return props.other_information?.membership_in_assoc_org ? props.other_information.membership_in_assoc_org.split(',').filter((list) => {
    const trimList = list.trim()
    return trimList !== ''
  }) : []
})

let form = null
  
if(props.questions){
  form = useForm({
    thirty_four_a: props.questions.thirty_four_a,
    thirty_four_b: props.questions.thirty_four_b,
    thirty_four_a_b_if_yes: props.questions.thirty_four_a_b_if_yes,
    thirty_five_a: props.questions.thirty_five_a,
    thirty_five_a_if_yes: props.thirty_five_a_if_yes,
    thirty_five_b: props.questions.thirty_five_b,
    thirty_five_b_if_yes_date: props.questions.thirty_five_b_if_yes_date,
    thirty_five_b_if_yes_case: props.questions.thirty_five_b_if_yes_case,
    thirty_six: props.questions.thirty_six,
    thirty_six_if_yes: props.questions.thirty_six_if_yes,
    thirty_seven: props.questions.thirty_seven,
    thirty_seven_if_yes: props.questions.thirty_seven_if_yes,
    thirty_eight_a: props.questions.thirty_eight_a,
    thirty_eight_a_if_yes: props.questions.thirty_eight_a_if_yes,
    thirty_eight_b: props.questions.thirty_eight_b,
    thirty_eight_b_if_yes: props.questions.thirty_eight_b_if_yes,
    thirty_nine: props.questions.thirty_nine,
    thirty_nine_if_yes: props.questions.thirty_nine_if_yes,
    fourty_a: props.questions.fourty_a,
    fourty_a_if_yes: props.questions.fourty_a_if_yes,
    fourty_b: props.questions.fourty_b,
    fourty_b_if_yes: props.questions.fourty_b_if_yes,
    fourty_c: props.questions.fourty_c,
    fourty_c_if_yes: props.questions.fourty_c_if_yes,
  })
}else{
  form = useForm({
    thirty_four_a: null,
    thirty_four_b: null,
    thirty_four_a_b_if_yes: null,
    thirty_five_a: null,
    thirty_five_a_if_yes: null,
    thirty_five_b: null,
    thirty_five_b_if_yes_date: null,
    thirty_five_b_if_yes_case: null,
    thirty_six: null,
    thirty_six_if_yes: null,
    thirty_seven: null,
    thirty_seven_if_yes: null,
    thirty_eight_a: null,
    thirty_eight_a_if_yes: null,
    thirty_eight_b: null,
    thirty_eight_b_if_yes: null,
    thirty_nine: null,
    thirty_nine_if_yes: null,
    fourty_a: null,
    fourty_a_if_yes: null,
    fourty_b: null,
    fourty_b_if_yes: null,
    fourty_c: null,
    fourty_c_if_yes: null,
  })
}
  
const save = () => {
  form.post(route('profile.pds.page_four_questions.store_or_update', { page_four_questions: props.questions?.id }), {
    preserveScroll: true,
  })
}

const _34_both_yes = computed(() => {
  return form.thirty_four_a === 'Yes' || form.thirty_four_b === 'Yes'

})
</script>