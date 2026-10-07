<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                <i class="fa-solid fa-pen-to-square text-primary"></i>
              </div>
              <h5 class="mb-0 fw-bold text-dark">Edit Voluntary Work</h5>
            </div>
            <div class="card-body p-4">
              <form @submit.prevent="save">
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Name & Address of Organization</label>
                    <input v-model="form.name_address_of_org" type="text" class="form-control" placeholder="Write in full" />
                    <InputError :message="form.errors.name_address_of_org" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">From</label>
                    <input v-model="form.inclusive_date_from" type="date" class="form-control" />
                    <InputError :message="form.errors.inclusive_date_from" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">To</label>
                    <input v-model="form.inclusive_date_to" type="date" class="form-control" />
                    <InputError :message="form.errors.inclusive_date_to" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Number of Hours</label>
                    <div class="input-group">
                      <input v-model="form.number_of_hours" type="number" class="form-control" placeholder="e.g. 40" />
                      <span class="input-group-text bg-light text-muted">hrs</span>
                    </div>
                    <InputError :message="form.errors.number_of_hours" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-6">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Position / Nature of Work</label>
                    <input v-model="form.position_work" type="text" class="form-control" placeholder="Describe your role" />
                    <InputError :message="form.errors.position_work" class="mt-1" />
                  </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                  <span v-if="form.isDirty" class="text-warning small fw-medium"><i class="fa-solid fa-triangle-exclamation me-1"></i>Unsaved changes</span>
                  <span v-else></span>
                  
                  <div class="d-flex gap-2">
                    <Link :href="route('profile.pds.voluntary_work.index')" class="btn btn-light rounded-pill px-4 fw-medium text-secondary" :disabled="form.processing">Cancel</Link>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm" :disabled="form.processing">
                      <Spinner :processing="form.processing" class="me-2" v-if="form.processing" /> 
                      <i class="fa-solid fa-save me-2" v-else></i>Save Changes
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