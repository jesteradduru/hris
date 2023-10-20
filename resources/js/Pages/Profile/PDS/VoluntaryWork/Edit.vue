<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <form @submit.prevent="save">
        <div class="row">
          <div class="form-group col-6">
            <div class="mb-3">
              <label for="" class="form-label">NAME & ADDRESS OF ORGANIZATION</label>
              <input
                id=""
                v-model="form.name_address_of_org" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="form.errors.name_address_of_org" /> 
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
              <label for="" class="form-label">POSITION / NATURE OF WORK</label>
              <input
                id=""
                v-model="form.position_work" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="form.errors.position_work" />  
            </div>
          </div>


          <div class="col-12">
            <div class="d-flex gap-2">
              <div class="d-flex align-items-center">
                <b v-if="form.isDirty" class="text-danger form-status">Not Saved</b>
              </div>
              <Link :href="route('profile.pds.voluntary_work.index')" class="btn btn-secondary" :disabled="form.processing" type="submit">  Back</Link>
              <button
                type="submit" :disabled="!form.isDirty && form.wasSuccessful"
                class="btn btn-success"
              >
                <Spinner :processing="form.processing" /> {{ !form.isDirty &&
                  form.wasSuccessful ? 'Updated' : 'Update' }}
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

const props = defineProps({
  voluntary_work: Object,
})

const form = useForm({
  name_address_of_org: props.voluntary_work.name_address_of_org,
  inclusive_date_from: props.voluntary_work.inclusive_date_from,
  inclusive_date_to: props.voluntary_work.inclusive_date_to,
  number_of_hours: props.voluntary_work.number_of_hours,
  position_work: props.voluntary_work.position_work,
})

const save = () => {
  form.put(route('profile.pds.voluntary_work.update', {voluntary_work: props.voluntary_work.id}), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    },
  })
}
</script>