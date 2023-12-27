<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <form @submit.prevent="addWork">
        <div class="row">
          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">FROM</label>
              <input
                id=""
                v-model="workForm.inclusive_date_from" type="date" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="workForm.errors.inclusive_date_from" />
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">TO</label>
              <div class="form-check">
                <input id="training" v-model="workForm.to_present" class="form-check-input" type="checkbox" value="" />
                <label class="form-check-label" for="training"> Present </label>
              </div>
              <input
                id=""
                v-model="workForm.inclusive_date_to"
                :disabled="workForm.to_present" type="date" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="workForm.errors.inclusive_date_to" />
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">POSITION TITLE</label>
              <input
                id=""
                v-model="workForm.position_title" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="workForm.errors.position_title" /> 
              <p class="form-text text-muted">
                Write in full/Do not abbreviate
              </p>
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">DEPARTMENT / AGENCY / OFFICE / COMPANY</label>
              <input
                id=""
                v-model="workForm.dept_agency_office_company" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="workForm.errors.dept_agency_office_company" />  
              <p class="form-text text-muted">
                Write in full/Do not abbreviate
              </p>
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">NAME OF OFFICE/UNIT</label>
              <input
                id=""
                v-model="workForm.name_of_office_unit" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="workForm.errors.name_of_office_unit" />
              <p class="form-text text-muted">
                Write in full/Do not abbreviate
              </p>
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">OFFICE ADDRESS</label>
              <input
                id=""
                v-model="workForm.office_address" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="workForm.errors.office_address" />
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">IMMEDIATE SUPERVISOR</label>
              <input
                id=""
                v-model="workForm.immediate_supervisor" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="workForm.errors.immediate_supervisor" />
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">MONTHLY SALARY</label>
              <input
                id=""
                v-model="workForm.monthly_salary" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="workForm.errors.monthly_salary" /> 
              <p class="text-muted form-text">
                e.g. 12000.00
              </p> 
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">SALARY/ JOB/ PAY GRADE</label>
              <input
                id=""
                v-model="workForm.paygrade" type="text" class="form-control form-control-sm" step="any" name=""
                placeholder=""
              />
              <InputError :message="workForm.errors.paygrade" />
              <p class="form-text text-muted">
                (if applicable)& STEP  (Format "00-0")/ INCREMENT
              </p>
            </div>
          </div>



          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">STATUS OF APPOINTMENT</label>
              <input
                id=""
                v-model="workForm.status_of_appointment" type="text" class="form-control form-control-sm" step="any" name=""
                placeholder=""
              />
              <InputError :message="workForm.errors.status_of_appointment" />
            </div>
          </div>


          <div class="form-group col-6">
            <label for="" class="form-label">GOVERNMENT SERVICE</label>
            <div class="mb-3">
              <div class="form-check form-check-inline">
                <input id="govt_yes" v-model="workForm.govt_service" class="form-check-input" type="radio" name="govt_service" value="1" />
                <label class="form-check-label" for="govt_yes">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input id="govt_no" v-model="workForm.govt_service" class="form-check-input" type="radio" name="govt_service" value="0" />
                <label class="form-check-label" for="govt_no">No</label>
              </div>
              <InputError :message="workForm.errors.govt_service" />
            </div>
          </div>


          <div class="form-group col-12">
            <div class="mb-3">
              <label for="" class="form-label">LIST OF ACCOMPLISHMENTS</label>
              <textarea id="" v-model="workForm.list_of_accomplishments" class="form-control" name="" rows="3" />
              <p class="form-text text-muted">
                Start with a hyphen on each new item
              </p>
              <InputError :message="workForm.errors.list_of_accomplishments" /> 
            </div>
          </div>


          <div class="form-group col-12">
            <div class="mb-3">
              <label for="" class="form-label">SUMMARY OF DUTIES</label>
              <textarea id="" v-model="workForm.summary_of_duties" class="form-control" name="" rows="3" />
              <p class="form-text text-muted">
                Start with a hyphen on each new item
              </p>
              <InputError :message="workForm.errors.summary_of_duties" />
            </div>
          </div>

          <div class="col-12">
            <div class="d-flex gap-2">
              <div class="d-flex align-items-center">
                <b v-if="workForm.isDirty" class="text-danger form-status">Not Saved</b>
              </div>
              <Link :href="route('profile.pds.work_experience.index')" class="btn btn-secondary" :disabled="workForm.processing" type="submit">  Back</Link>
              <button
                type="submit" :disabled="!workForm.isDirty && workForm.wasSuccessful"
                class="btn btn-success"
              >
                <Spinner :processing="workForm.processing" /> {{ !workForm.isDirty &&
                  workForm.wasSuccessful ? 'Added' : 'Add' }}
              </button>
            </div>
          </div>
        </div>
      </form>
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