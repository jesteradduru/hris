<template>
  <AuthenticatedLayout>
    <h3>Learning and Development</h3>
    <button v-if="permission.includes('Add L&D Form')" class="btn btn-primary" data-bs-target="#uploadSpmsForm" data-bs-toggle="modal">Upload IDP/Competency Gap Document</button>
    <div v-if="years.length > 0">
      <div v-for="(spmsForm, index) in years" :id="`accordion${index}`" :key="index" class="accordion mt-3">
        <div class="accordion-item">
          <h2 id="headingOne" class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="`#${spmsForm.year}`" aria-expanded="false" aria-controls="collapseOne">
              <b>{{ spmsForm.year }}</b>
            </button>
          </h2>
          <div :id="`${spmsForm.year}`" class="accordion-collapse collapse" aria-labelledby="headingOne" :data-bs-parent="`#accordion${index}`">
            <div class="accordion-body">
              <div class="table-responsive">
                <table class="table table-bordered mt-3 table-sm">
                  <thead>
                    <tr>
                      <th scope="col">DOCUMENT</th>
                      <th scope="col">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in spmsForm.forms" :key="item.id">
                      <td><a :href="item.src" target="_blank">{{ `${item.type} ${item.year}` }} <i class="fa-solid fa-up-right-from-square" /></a></td>
                      <td>
                        <Link v-if="permission.includes('Edit L&D Form')" class="btn btn-success btn-sm" :href="route('lnd_forms.edit', {lnd_form: item.id})"><i class="fa-solid fa-pen" /></Link>
                        <Link v-if="permission.includes('Delete L&D Form')" :onBefore="confirm" class="btn btn-danger btn-sm" method="delete" as="button" :href="route('lnd_forms.destroy', {lnd_form: item.id})"><i class="fa-solid fa-trash" /></Link>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="text-center bg-light mt-4 p-4 rounded">
      No Records
    </div>
      
    <Modal id="uploadSpmsForm">
      <template #header>
        <h5>UPLOAD DOCUMENT</h5>
      </template>
      <template #body>
        <form @submit.prevent="onSubmit">
          <div class="mb-3">
            <label for="" class="form-label">FORM TYPE</label>
            <select id="" v-model="form.type" name="" class="form-control">
              <option value="null">Select one</option>
              <option value="IDP">Individual Development Plan</option>
              <option value="COMPETENCY GAP ASSESSMENT">Competency Gap Assessment</option>
            </select>
            <InputError :message="form.errors.type" />
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Year</label>
            <input
              id=""
              v-model="form.year"
              type="number" class="form-control" name="" aria-describedby="helpId" placeholder=""
              max="2099" min="2000"
            />
            <InputError :message="form.errors.year" />
          </div>
          <div class="mb-3">
            <label for="" class="form-label">ATTACH FILE</label>
            <input
              id=""
              type="file" class="form-control" name="" aria-describedby="helpId"
              placeholder=""
              @change="addFile"
            />
            <small id="helpId" class="form-text text-muted">ONLY PDF FILE IS ALLOWED</small>
            <InputError :message="form.errors.file" />
          </div>
          <button class="btn btn-primary" :disabled="form.processing" type="submit">Submit</button>
        </form>
      </template>
    </Modal>
  </AuthenticatedLayout>
</template>
    
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Modal from '@/Components/Modal.vue'
import {usePage, useForm, Link} from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import moment from 'moment'
import { computed } from 'vue'
  
const props = defineProps({
  spms: Array,
  lndForms: Array,
})
  
const years = computed(() => {
  const years = []
  props.lndForms?.forEach(form => {
    const year = years.filter(y => y.year === form.year)
    if(year.length === 0){
      years.push({
        year: form.year,
        forms: props.lndForms.filter(f => f.year === form.year),
      })
    }
  })
  
  return years
})
  
const permission = usePage().props.auth.permissions.map(p => p.name)
  
const form = useForm({
  type: null,
  year: moment().format('YYYY'),
  file: null,
})
  
const addFile = (e) => {
  form.file = e.target.files
}
  
const onSubmit = (e) => form.post(route('lnd_forms.store'), {
  onSuccess: () => {
    form.reset()
    e.target.reset()
    form.file = null
  },
})

const confirm = () => window.confirm('Are you sure to delete this document?')
  
</script>