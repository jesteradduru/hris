<template>
  <ProfileLayout>
    <PDSLayout :is-form-dirty="form.isDirty">
      <form @submit.prevent="save">
        <!-- Some borders are removed -->
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <div class="form-group">
              <div class="form-label">34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be apppointed,</div>
              <div class="container">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <label for="q-34" class="form-label">a.  within the third degree?</label>
                    <div>
                      <div class="form-check form-check-inline">
                        <input id="34.a.yes" v-model="form.thirty_four_a" class="form-check-input" type="radio" name="34.a" value="Yes" />
                        <label class="form-check-label" for="34.a.yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input id="34.a.no" v-model="form.thirty_four_a" class="form-check-input" type="radio" name="34.a" value="No" />
                        <label class="form-check-label" for="34.a.no">No</label>
                      </div>
                    </div>
                    <InputError :message="form.errors.thirty_four_a" />
                  </li>
                  <li class="list-group-item">
                    <label for="q-34" class="form-label">b. within the fourth degree (for Local Government Unit - Career Employees)?</label>
                    <div>
                      <div class="form-check form-check-inline">
                        <input id="34.b.yes" v-model="form.thirty_four_b" class="form-check-input" type="radio" name="34.b" value="Yes" />
                        <label class="form-check-label" for="34.b.yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input id="34.b.no" v-model="form.thirty_four_b" class="form-check-input" type="radio" name="34.b" value="No" />
                        <label class="form-check-label" for="34.b.no">No</label>
                      </div>
                    </div>
                    <InputError :message="form.errors.thirty_four_b" />
                  </li>
                </ul>
                <div v-if="_34_both_yes" class="mb-3 mt-2">
                  <input
                    id=""
                    type="text" class="form-control" name="" aria-describedby="helpId" placeholder="If yes, give details:"
                  />
                </div>
              </div>
            </div>
          </li>

          
          <li class="list-group-item">
            <div class="form-group">
              <div>35. a. Have you ever been found guilty of any administrative offense?</div>
              <div class="container">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <div>
                      <div class="form-check form-check-inline">
                        <input id="35.a.yes" v-model="form.thirty_five_a" class="form-check-input" type="radio" name="35.a" value="Yes" />
                        <label class="form-check-label" for="35.a.yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input id="35.a.no" v-model="form.thirty_five_a" class="form-check-input" type="radio" name="35.a" value="No" />
                        <label class="form-check-label" for="35.a.no">No</label>
                      </div>
                      <InputError :message="form.errors.thirty_five_a" />
                    </div>
                    <div v-if="form.thirty_five_a === 'Yes'" class="mb-3 mt-2">
                      <input
                        id=""
                        v-model="form.thirty_five_a_if_yes" type="text" class="form-control" name="" aria-describedby="helpId" placeholder="If yes, give details:"
                      />
                    </div>
                  </li>

                  
                  <li class="list-group-item">
                    <label for="q-34" class="form-label">b. within the fourth degree (for Local Government Unit - Career Employees)?</label>
                    <div>
                      <div class="form-check form-check-inline">
                        <input id="35.b.yes" v-model="form.thirty_five_b" class="form-check-input" type="radio" name="35.b" value="Yes" />
                        <label class="form-check-label" for="35.b.yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input id="35.b.no" v-model="form.thirty_five_b" class="form-check-input" type="radio" name="35.b" value="No" />
                        <label class="form-check-label" for="35.b.no">No</label>
                      </div>
                      <InputError :message="form.errors.thirty_five_b" />
                    </div>
                    <div v-if="form.thirty_five_b === 'Yes'">
                      <div class="mb-3 mt-2">
                        <input
                          id=""
                          v-model="form.thirty_five_b_if_yes_date" type="date" class="form-control" name="" aria-describedby="helpId" placeholder="DATE FILED"
                        />
                        <InputError :message="form.errors.thirty_five_b_if_yes_date" />
                      </div>
                      <div class="mb-3 mt-2">
                        <input
                          id=""
                          v-model="form.thirty_five_b_if_yes_case" type="text" class="form-control" name="" aria-describedby="helpId" placeholder="STATUS OF CASE/S"
                        />
                        <InputError :message="form.errors.thirty_five_b_if_yes_case" />
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </li>



          <li class="list-group-item">
            <div class="form-group">
              <div>36.&nbsp;Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</div>
              <div class="container">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <div>
                      <div class="form-check form-check-inline">
                        <input id="36.a.yes" v-model="form.thirty_six" class="form-check-input" type="radio" name="36.a" value="Yes" />
                        <label class="form-check-label" for="36.a.yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input id="36.a.no" v-model="form.thirty_six" class="form-check-input" type="radio" name="36.a" value="No" />
                        <label class="form-check-label" for="36.a.no">No</label>
                      </div>
                      <InputError :message="form.errors.thirty_six" />
                    </div>
                    <div v-if="form.thirty_six === 'Yes'" class="mb-3 mt-2">
                      <input
                        id=""
                        v-model="form.thirty_six_if_yes" type="text" class="form-control" name="" aria-describedby="helpId" placeholder="If yes, give details:"
                      />
                      <InputError :message="form.errors.thirty_six_if_yes" />
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </li>


          <li class="list-group-item">
            <div class="form-group">
              <div>37.&nbsp;Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</div>
              <div class="container">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <div>
                      <div class="form-check form-check-inline">
                        <input id="37.a.yes" v-model="form.thirty_seven" class="form-check-input" type="radio" name="37.a" value="Yes" />
                        <label class="form-check-label" for="37.a.yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input id="37.a.no" v-model="form.thirty_seven" class="form-check-input" type="radio" name="37.a" value="No" />
                        <label class="form-check-label" for="37.a.no">No</label>
                      </div>
                      <InputError :message="form.errors.thirty_seven" />
                    </div>
                    <div v-if="form.thirty_seven === 'Yes'" class="mb-3 mt-2">
                      <input
                        id=""
                        v-model="form.thirty_seven_if_yes" type="text" class="form-control" name="" aria-describedby="helpId" placeholder="If yes, give details:"
                      />
                      <InputError :message="form.errors.thirty_seven_if_yes" />
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </li>


          <li class="list-group-item">
            <div class="form-group">
              <div>38. a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?</div>
              <div class="container">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <div>
                      <div class="form-check form-check-inline">
                        <input id="38.a.yes" v-model="form.thirty_eight_a" class="form-check-input" type="radio" name="38.a" value="Yes" />
                        <label class="form-check-label" for="38.a.yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input id="38.a.no" v-model="form.thirty_eight_a" class="form-check-input" type="radio" name="38.a" value="No" />
                        <label class="form-check-label" for="38.a.no">No</label>
                      </div>
                      <InputError :message="form.errors.thirty_eight_a" />
                    </div>
                    <div v-if="form.thirty_eight_a === 'Yes'" class="mb-3 mt-2">
                      <input
                        id=""
                        v-model="form.thirty_eight_a_if_yes" type="text" class="form-control" name="" aria-describedby="helpId" placeholder="If yes, give details:"
                      />
                      <InputError :message="form.errors.thirty_eight_a_if_yes" />
                    </div>
                  </li>

                  
                  <li class="list-group-item">
                    <label for="q-34" class="form-label">b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</label>
                    <div>
                      <div class="form-check form-check-inline">
                        <input id="38.b.yes" v-model="form.thirty_eight_b" class="form-check-input" type="radio" name="38.b" value="Yes" />
                        <label class="form-check-label" for="38.b.yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input id="38.b.no" v-model="form.thirty_eight_b" class="form-check-input" type="radio" name="38.b" value="No" />
                        <label class="form-check-label" for="38.b.no">No</label>
                      </div>
                      <InputError :message="form.errors.thirty_eight_b" />
                    </div>
                    <div v-if="form.thirty_eight_b === 'Yes'" class="mb-3 mt-2">
                      <input
                        id=""
                        v-model="form.thirty_eight_b_if_yes" type="text" class="form-control" name="" aria-describedby="helpId" placeholder="If yes, give details:"
                      />
                      <InputError :message="form.errors.thirty_eight_b_if_yes" />
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </li>


          <li class="list-group-item">
            <div class="form-group">
              <div>39.&nbsp;Have you acquired the status of an immigrant or permanent resident of another country?</div>
              <div class="container">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <div>
                      <div class="form-check form-check-inline">
                        <input id="39.a.yes" v-model="form.thirty_nine" class="form-check-input" type="radio" name="39.a" value="Yes" />
                        <label class="form-check-label" for="39.a.yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input id="39.a.no" v-model="form.thirty_nine" class="form-check-input" type="radio" name="39.a" value="No" />
                        <label class="form-check-label" for="39.a.no">No</label>
                      </div>
                      <InputError :message="form.errors.thirty_nine" />
                    </div>
                    <div v-if="form.thirty_nine === 'Yes'" class="mb-3 mt-2">
                      <input
                        id=""
                        v-model="form.thirty_nine_if_yes" type="text" class="form-control" name="" aria-describedby="helpId" placeholder="If yes, give details (country)"
                      />
                      <InputError :message="form.errors.thirty_nine_if_yes" />
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </li>
          

          <li class="list-group-item">
            <div class="form-group">
              <div class="form-label">40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</div>
              <div class="container">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <label for="q-40" class="form-label">a.  Are you a member of any indigenous group?</label>
                    <div>
                      <div class="form-check form-check-inline">
                        <input id="40.a.yes" v-model="form.fourty_a" class="form-check-input" type="radio" name="40.a" value="Yes" />
                        <label class="form-check-label" for="40.a.yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input id="40.a.no" v-model="form.fourty_a" class="form-check-input" type="radio" name="40.a" value="No" />
                        <label class="form-check-label" for="40.a.no">No</label>
                      </div>
                      <InputError :message="form.errors.fourty_a" />
                    </div>
                    <div v-if="form.fourty_a === 'Yes'" class="mb-3 mt-2">
                      <input
                        id=""
                        v-model="form.fourty_a_if_yes" type="text" class="form-control" name="" aria-describedby="helpId"
                        placeholder="If yes, give details:"
                      />
                      <InputError :message="form.errors.fourty_a_if_yes" />
                    </div>
                  </li>
                  <li class="list-group-item">
                    <label for="q-40" class="form-label">b. Are you a person with disability?</label>
                    <div>
                      <div class="form-check form-check-inline">
                        <input id="40.b.yes" v-model="form.fourty_b" class="form-check-input" type="radio" name="40.b" value="Yes" />
                        <label class="form-check-label" for="40.b.yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input id="40.b.no" v-model="form.fourty_b" class="form-check-input" type="radio" name="40.b" value="No" />
                        <label class="form-check-label" for="40.b.no">No</label>
                      </div>
                      <InputError :message="form.errors.fourty_b" />
                    </div>
                    <div v-if="form.fourty_b === 'Yes'" class="mb-3 mt-2">
                      <input
                        id=""
                        v-model="form.fourty_b_if_yes" type="text" class="form-control" name="" aria-describedby="helpId" placeholder="If yes, give details:"
                      />
                      <InputError :message="form.errors.fourty_b_if_yes" />
                    </div>
                  </li>
                  <li class="list-group-item">
                    <label for="q-40" class="form-label">c. Are you a solo parent?</label>
                    <div>
                      <div class="form-check form-check-inline">
                        <input id="40.c.yes" v-model="form.fourty_c" class="form-check-input" type="radio" name="40.c" value="Yes" />
                        <label class="form-check-label" for="40.c.yes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input id="40.c.no" v-model="form.fourty_c" class="form-check-input" type="radio" name="40.c" value="No" />
                        <label class="form-check-label" for="40.c.no">No</label>
                      </div>
                      <InputError :message="form.errors.fourty_c" />
                    </div>
                    <div v-if="form.fourty_c === 'Yes'" class="mb-3 mt-2">
                      <input
                        id=""
                        v-model="form.fourty_c_if_yes" type="text" class="form-control" name="" aria-describedby="helpId" placeholder="If yes, give details:"
                      />
                      <InputError :message="form.errors.fourty_c_if_yes" />
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </li>
        </ul>

        <div class="mb-3 d-flex gap-2 justify-content-between">
          <div class="d-flex gap-2">
            <div class="d-flex align-items-center">
              <b v-if="form.isDirty" class="text-danger form-status">Not Saved</b>
            </div>
            <button
              type="submit" :disabled="!form.isDirty && form.wasSuccessful"
              class="btn btn-success"
            >
              <Spinner :processing="form.processing" /> {{ !form.isDirty &&
                form.wasSuccessful ? 'Saved' : 'Save' }}
            </button>
          </div>
          <div class="d-flex gap-2">
            <Link
              :href="route('profile.pds.other_information.index')" type="button"
              class="btn btn-dark"
            >
              <i class="fa-solid fa-arrow-left" />
            </Link>
            <Link
              :href="route('profile.pds.reference_id.index')" type="button"
              class="btn btn-dark"
            >
              <i class="fa-solid fa-arrow-right" />
            </Link>
          </div>
        </div>
      </form>
    </PDSLayout>
  </ProfileLayout>
</template>
  
<script setup>
import Spinner from '@/Components/Spinner.vue'
import { useForm, Link } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import ListBadge from '@/Components/ListBadge.vue'
import ProfileLayout from '@/Pages/Profile/Layout/ProfileLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import { computed } from 'vue'
  
const props = defineProps({
  questions: Object,
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
  return form.thirty_four_a === 'Yes' && form.thirty_four_b === 'Yes'

})
  
</script>