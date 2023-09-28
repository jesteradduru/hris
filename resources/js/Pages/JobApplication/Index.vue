<template>
  <ApplicationLayout :job_posting="job_posting">
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
        <p class="form-text text-muted">Accepted file formats: pdf, png, jpeg</p>
        <InputError :message="form.errors['documents']" />
        <InputError :message="form.errors['documents.0']" />
        <button type="submit" class="btn btn-success">Submit</button>
      </form>
    </div>
  </ApplicationLayout>
</template>
    
<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import ApplicationLayout from '@/Pages/JobApplication/Layout/ApplicationLayout.vue'
import InputError from '@/Components/InputError.vue'
    
const props = defineProps({
  job_posting: Object,
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
    
</script>
    