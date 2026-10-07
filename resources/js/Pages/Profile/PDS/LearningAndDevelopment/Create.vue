
<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          
          <div class="alert alert-info border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
            <i class="fa-solid fa-circle-info fs-4 me-3 text-info"></i>
            <div>
              <h6 class="fw-bold mb-1">Reminder</h6>
              <span class="small">To validate the Learning and Development Intervention/Training, please attach the certificate.</span>
            </div>
          </div>

          <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                <i class="fa-solid fa-graduation-cap text-primary"></i>
              </div>
              <h5 class="mb-0 fw-bold text-dark">Add Learning and Development</h5>
            </div>
            <div class="card-body p-4">
              <form @submit.prevent="add">
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Title of Learning and Development Interventions / Training Programs</label>
                    <input v-model="form.title_of_learning" type="text" class="form-control" placeholder="Write in full" />
                    <InputError :message="form.errors.title_of_learning" class="mt-1" />
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

                  <div class="col-12 col-md-4">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Number of Hours</label>
                    <div class="input-group">
                      <input v-model="form.number_of_hours" type="number" class="form-control" placeholder="e.g. 8" />
                      <span class="input-group-text bg-light text-muted">hrs</span>
                    </div>
                    <InputError :message="form.errors.number_of_hours" class="mt-1" />
                  </div>

                  <div class="col-12 col-md-8">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Type of L&D</label>
                    <input v-model="form.type_of_ld" type="text" class="form-control" placeholder="(Managerial / Supervisory / Technical / etc.)" />
                    <InputError :message="form.errors.type_of_ld" class="mt-1" />
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Conducted / Sponsored By</label>
                    <input v-model="form.conducted_sponsored_by" type="text" class="form-control" placeholder="Write in full" />
                    <InputError :message="form.errors.conducted_sponsored_by" class="mt-1" />
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-medium text-secondary small text-uppercase">Attachment (e.g. Certificates)</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light"><i class="fa-solid fa-file-pdf text-danger"></i></span>
                      <input type="file" class="form-control" multiple @input="addDocument" accept=".pdf" />
                    </div>
                    <div class="form-text text-muted small"><i class="fa-solid fa-circle-info me-1"></i>Accepted file formats: pdf</div>
                    <InputError :message="form.errors['documents']" class="mt-1" />
                    <InputError :message="form.errors['documents.0']" class="mt-1" />
                  </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                  <span v-if="form.isDirty" class="text-warning small fw-medium"><i class="fa-solid fa-triangle-exclamation me-1"></i>Unsaved changes</span>
                  <span v-else></span>
                  
                  <div class="d-flex gap-2">
                    <Link :href="route('profile.pds.learning_and_development.index')" class="btn btn-light rounded-pill px-4 fw-medium text-secondary" :disabled="form.processing">Cancel</Link>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm" :disabled="!form.isDirty && form.wasSuccessful">
                      <Spinner :processing="form.processing" class="me-2" v-if="form.processing" /> 
                      <span v-if="!form.isDirty && form.wasSuccessful"><i class="fa-solid fa-check me-2"></i>Added</span>
                      <span v-else><i class="fa-solid fa-save me-2" v-if="!form.processing"></i>Save Training</span>
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

const form = useForm({
  title_of_learning: null,
  inclusive_date_from: null,
  inclusive_date_to: null,
  number_of_hours: null,
  type_of_ld: null,
  conducted_sponsored_by: null,
  documents: [],
})

const add = () => {
  form.post(route('profile.pds.learning_and_development.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    },
  })
}

const addDocument = (e) => {
  form.documents = []
  for(const file of e.target.files){
    form.documents.push(file)
  }
}
</script>