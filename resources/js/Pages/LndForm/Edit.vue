<template>
  <Head title="Performance Management" />
  <AuthenticatedLayout>
    <Link class="btn btn-secondary mb-3 btn-sm" :href="route('lnd_forms.index')"><i class="fa-solid fa-arrow-left" /></Link>
    <h3>EDIT {{ props.lndForm.type }}</h3>
    <form enctype="multipart/form-data" @submit.prevent="onSubmit">
      <div class="mb-3">
        <label for="" class="form-label">TYPE</label>
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
        <label for="" class="form-label">ATTACH FILE 
        </label>
        <a class="d-block" :href="props.lndForm.src" target="_blank">{{ `${props.lndForm.type} ${props.lndForm.year}` }} <i class="fa-solid fa-up-right-from-square" /></a>
        <input
          id=""
          type="file" class="form-control" name="" aria-describedby="helpId" placeholder=""
          @change="addFile"
        />
        <small id="helpId" class="form-text text-muted">ONLY PDF FILE IS ALLOWED</small>
        <InputError :message="form.errors.file" />
      </div>
      <button class="btn btn-primary" :disabled="form.processing">Submit</button>
    </form>
  </AuthenticatedLayout>
</template>
    
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {useForm, Link, Head} from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
  
const props = defineProps({
  lndForm: Object,
})

const form = useForm({
  _method: 'put',
  type: props.lndForm.type,
  year: props.lndForm.year,
  file: null,
})
  
const addFile = (e) => {
  form.file = e.target.files
}
  

const onSubmit = () => form.post(route('lnd_forms.update', {lnd_form: props.lndForm.id}), {
  onSuccess: () => form.file = null,
})
  
</script>