<template>
  <Head title="Performance Management" />
  <AdminLayout>
    <Link class="btn btn-secondary mb-3 btn-sm" :href="route('admin.spms.index')"><i class="fa-solid fa-arrow-left" /></Link>
    <h3>Edit {{ props.spms.type }}</h3>
    <div class="mb-3">
      <label for="" class="form-label">FORM TYPE</label>
      <select id="" v-model="form.type" name="" class="form-control">
        <option value="null">Select one</option>
        <option value="IPCR">IPCR</option>
        <option value="DPCR">DPCR</option>
        <option value="OPCR">OPCR</option>
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
      <label for="" class="form-label">SEMESTER</label>
      <select id="" v-model="form.semester" name="" class="form-control">
        <option value="null">Select one</option>
        <option value="FIRST">1ST SEMESTER</option>
        <option value="SECOND">2ND SEMESTER</option>
      </select>
      <InputError :message="form.errors.semester" />
    </div>
    <div class="mb-3">
      <label for="" class="form-label">ATTACH FILE 
      </label>
      <a class="d-block" :href="props.spms.src" target="_blank">{{ `${props.spms.semester} SEMESTER ${props.spms.type}` }} <i class="fa-solid fa-up-right-from-square" /></a>
      <input
        id=""
        type="file" class="form-control" name="" aria-describedby="helpId" placeholder=""
        @change="addFile"
      />
      <small id="helpId" class="form-text text-muted">ONLY PDF FILE IS ALLOWED</small>
      <InputError :message="form.errors.file" />
    </div>
    <div class="mb-3">
      <label for="" class="form-label">Rating</label>
      <input
        id=""
        v-model="form.rating" type="number" class="form-control" min="1" max="5" name="" aria-describedby="helpId"
        placeholder=""
      />
      <InputError :message="form.errors.rating" />
    </div>
    <button class="btn btn-primary" :disabled="form.processing" @click="onSubmit">Submit</button>
  </AdminLayout>
</template>
    
<script setup>
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import {useForm, Link, Head} from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
  
const props = defineProps({
  spms: Object,
})

const form = useForm({
  semester: props.spms.semester, 
  type: props.spms.type,
  year: props.spms.year,
  file: null,
  rating: props.spms.rating,
})
  
const addFile = (e) => {
  form.file = e.target.files
}
  
const onSubmit = () => form.patch(route('profile.spms.update', {spm: props.spms.id}), {
  onSuccess: () => {
    form.file = null
  },
})
  
</script>