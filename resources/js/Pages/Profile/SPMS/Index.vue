<template>
  <AuthenticatedLayout>
    <h3>Performance Management</h3>
    <button v-if="permission.includes('Add SPMS')" class="btn btn-primary" data-bs-target="#uploadSpmsForm" data-bs-toggle="modal">Add SPMS</button>
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
                <table class="table table-bordered mt-3">
                  <thead>
                    <tr>
                      <th scope="col">SEMESTER</th>
                      <th scope="col">RATING</th>
                      <th scope="col">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in spmsForm.forms" :key="item.id">
                      <td><a :href="item.src" target="_blank">{{ `${item.semester} SEMESTER ${item.type}` }} <i class="fa-solid fa-up-right-from-square" /></a></td>
                      <td>
                        {{ item.rating }}
                        <b>
                          {{ item.rating == 5 ? 'Outstanding' : null }}
                          {{ item.rating < 5 && item.rating >= 4 ? 'Very Satisfactory' : null }}
                          {{ item.rating < 4 && item.rating >= 3 ? 'Satisfactory' : null }}
                          {{ item.rating < 3 && item.rating >= 2 ? 'Unsatisfactory' : null }}
                          {{ item.rating < 2 && item.rating >= 1 ? 'Poor' : null }}
                        </b>
                      </td>
                      <td>
                        <Link v-if="permission.includes('Edit SPMS')" class="btn btn-success btn-sm" :href="route('profile.spms.edit', {spm: item.id})"><i class="fa-solid fa-pen" /></Link>
                        <Link v-if="permission.includes('Delete SPMS')" :onBefore="confirm" class="btn btn-danger btn-sm" method="delete" as="button" :href="route('profile.spms.destroy', {spm: item.id})"><i class="fa-solid fa-trash" /></Link>
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
        <h5>Add Performance Management</h5>
      </template>
      <template #body>
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
          <label for="" class="form-label">ATTACH FILE</label>
          <input
            id=""
            type="file" class="form-control" name="" aria-describedby="helpId" placeholder=""
            @change="addFile"
          />
          <small id="helpId" class="form-text text-muted">ONLY PDF FILE IS ALLOWED</small>
          <InputError :message="form.errors['file.0']" />
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
})

const years = computed(() => {
  const years = []
  props.spms?.forEach(form => {
    const year = years.filter(y => y.year === form.year)
    if(year.length === 0){
      years.push({
        year: form.year,
        forms: props.spms.filter(f => f.year === form.year),
      })
    }
  })

  return years
})

const permission = usePage().props.auth.permissions.map(p => p.name)

const form = useForm({
  semester: null, 
  type: null,
  year: moment().format('YYYY'),
  file: null,
  rating: null,
})

const addFile = (e) => {
  form.file = e.target.files
}

const onSubmit = () => form.post(route('profile.spms.store', {
  onSuccess: () => {
    form.file = null
  },
}))

const confirm = () => window.confirm('Are you sure?')

</script>