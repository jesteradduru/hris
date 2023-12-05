<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <form @submit.prevent="submitForm">
        <div class="row">
          <div class="col-12">
            <div class="mb-3">
              <label class="form-label">NON-ACADEMIC DISTINCTIONS / RECOGNITION / AWARD</label>
              <input v-model="form.title" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.title" />
            </div>
          </div>
        
        
          <div class="col-12">
            <div class="mb-3">
              <label class="form-label">DEPARTMENT / AGENCY / OFFICE / COMPANY</label>
              <input v-model="form.office" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.office" />
            </div>
          </div>
        
        
          <div class="col-12">
            <div class="mb-3">
              <label class="form-label">DATE AWARDED</label>
              <input v-model="form.date_awarded" type="date" class="form-control form-control-sm" />
              <InputError :message="form.errors.date_awarded" />
            </div>
          </div>
      
        

          <div class="col-12">
            <div class="mb-3">
              <label class="form-label">ATTACHMENT (e.g. Certificate of Award)</label>
              <input id="" type="file" class="form-control form-control-sm" name="" placeholder="" aria-describedby="fileHelpId" multiple @input="addDocument" />
              <small class="form-text text-muted">Accepted file formats: pdf</small>
              <InputError :message="form.errors['documents']" />
              <InputError :message="form.errors['documents.0']" />
            </div>
          </div>
        
        
          <div class="col-12">
            <div class="d-flex gap-2">
              <Link :href="route('profile.pds.non_academic_distinctions.index')" class="btn btn-secondary" :disabled="submitForm.processing" type="submit">  Back</Link>
              <button class="btn btn-success" :disabled="submitForm.processing" type="submit"><Spinner :processing="form.processing" />  Add</button>
            </div>
          </div>
        </div>
      </form>
    </PDSLayout>
  </AuthenticatedLayout>
</template>
  
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import Spinner from '@/Components/Spinner.vue'
import { useForm, Link } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const form = useForm({
  title: '',
  office: '',
  date_awarded: null,
  documents: [],
})
  
const submitForm = () => {
  form.post(route('profile.pds.non_academic_distinctions.store'), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
  })
}

const addDocument = (e) => {
  form.documents = []
  for(const file of e.target.files){
    form.documents.push(file)
  }
}
  
</script>