<template>
  <ApplicationLayout :job_posting="job_posting">
    <div v-if="props.application.length > 0" class="alert alert-success d-flex flex-column gap-2">
      <h5>Application submitted</h5>
      <div class="d-flex flex-column">
        <b>E-PDS</b>
        <a target="_blank" :href="route('profile.pds.personal_information.edit')">Personal Data Sheet</a>
      </div>
      <div class="d-flex flex-column">
        <b>Uploaded Documents</b>
        <a v-for="document in application[0].document" :key="document.id" :href="document.src" target="_blank">{{ document.filename }}</a>
      </div>
      <div>
        <Link v-if="permissions.includes('Delete Application')" :onBefore="confirm" method="delete" as="button" :href="route('job_application.destroy', {job_application: props.application[0].id})" class="btn btn-danger btn-md ">Cancel Application</Link>
      </div>
    </div>
    <div v-else>
      <div class="mb-3">
        <h4>Personal Data Sheet</h4>
        <a class="btn btn-primary " :href="route('profile.pds.personal_information.edit')" target="_blank">
          UPDATE PDS
        </a>
      </div>
      <div class="mb-3">
        <h4>Documents</h4>
        <div class="mb-3 text-pre-wrap">
          {{ props.job_posting.documents }}
        </div>
        <form @submit.prevent="submitApplication">
          <div class="mb-3 d-flex gap-2">
            <div>
              <input id="" type="file" class="form-control" name="" placeholder="" aria-describedby="fileHelpId" multiple @input="addDocument" />
            </div>
            <div><button type="reset" class="btn btn-secondary" @click="() => form.reset()">X</button></div>
          </div>
          <p class="form-text text-muted">Accepted file formats: pdf</p>
          <InputError :message="form.errors['documents']" />
          <InputError :message="form.errors['documents.0']" />
          <button type="submit" class="btn btn-success" :disabled="form.processing">
            <Spinner :processing="form.processing" />
            Submit
          </button>
        </form>
      </div>
    </div>
  </ApplicationLayout>
</template>
    
<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3'
import ApplicationLayout from '@/Pages/JobApplication/Layout/ApplicationLayout.vue'
import InputError from '@/Components/InputError.vue'
import Spinner from '@/Components/Spinner.vue'

    
const props = defineProps({
  job_posting: Object,
  application: Object,
})

const form = useForm({
  documents: [],
})

const addDocument = (e) => {
  form.reset()
  for(const file of e.target.files){
    form.documents.push(file)
  }
}

const submitApplication = () => {
  form.post(route('job_application.store', {job_posting: props.job_posting.id}), {
    onSuccess: () => form.reset(),
  })
}

const confirm = () => window.confirm('Are you sure to cancel the job application.')

const permissions = usePage().props.auth.permissions.map(p => p.name)

</script>
    