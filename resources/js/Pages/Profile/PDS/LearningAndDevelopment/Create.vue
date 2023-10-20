<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <form @submit.prevent="add">
        <div class="row">
          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAMS</label>
              <input
                id=""
                v-model="form.title_of_learning" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="form.errors.title_of_learning" /> 
              <p class="form-text text-muted">
                Write in full
              </p>
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">FROM</label>
              <input
                id=""
                v-model="form.inclusive_date_from" type="date" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="form.errors.inclusive_date_from" />
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">TO</label>
              <input
                id=""
                v-model="form.inclusive_date_to" type="date" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="form.errors.inclusive_date_to" />
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">NUMBER OF HOURS</label>
              <input
                id=""
                v-model="form.number_of_hours" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="form.errors.number_of_hours" /> 
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">Type of LD</label>
              <input
                id=""
                v-model="form.type_of_ld" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <p class="text-muted form-text">
                ( Managerial/ Supervisory/
                Technical/etc) 
              </p>
              <InputError :message="form.errors.type_of_ld" />  
            </div>
          </div>


          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">CONDUCTED/SPONSORED BY</label>
              <input
                id=""
                v-model="form.conducted_sponsored_by" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <p class="text-muted form-text">
                Write in full
              </p>
              <InputError :message="form.errors.conducted_sponsored_by" />  
            </div>
          </div>


          <div class="col-12">
            <div class="d-flex gap-2">
              <div class="d-flex align-items-center">
                <b v-if="form.isDirty" class="text-danger form-status">Not Saved</b>
              </div>
              <Link :href="route('profile.pds.learning_and_development.index')" class="btn btn-secondary" :disabled="form.processing" type="submit">  Back</Link>
              <button
                type="submit" :disabled="!form.isDirty && form.wasSuccessful"
                class="btn btn-success"
              >
                <Spinner :processing="form.processing" /> {{ !form.isDirty &&
                  form.wasSuccessful ? 'Added' : 'Add' }}
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

const form = useForm({
  title_of_learning: null,
  inclusive_date_from: null,
  inclusive_date_to: null,
  number_of_hours: null,
  type_of_ld: null,
  conducted_sponsored_by: null,
})

const add = () => {
  form.post(route('profile.pds.learning_and_development.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    },
  })
}
</script>