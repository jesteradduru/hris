<template>
  <Box id="performance" class="mb-3">
    <template #header>Performance Rating</template>
    <div v-if="isEmployee">
      <div
        class="table-responsive"
      >
        <table
          class="table table-sm table-bordered"
        >
          <thead>
            <tr>
              <th scope="col">Semester</th>
              <th scope="col">Rating</th>
              <th v-if="applicant.spms.length > 0">Equivalent Rating (70)</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(ipcr, index) in applicant.spms" :id="`ipcr${ipcr.id}`" :key="ipcr.id" class="">
              <td scope="row">
                <a :href="ipcr.src" target="_blank">{{ `${ipcr.semester} SEMESTER ${ipcr.year}` }} <i class="fa-solid fa-up-right-from-square" /></a>
              </td>
              <td>{{ ipcr.rating }}</td>
              <td v-if="index === 0 && applicant.performanceComputation" rowspan="2">{{ applicant.performanceComputation.equivalent }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div v-else>
      <button v-if="!applicant.pes_rating" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addSpmsRating">Add Rating</button>
      <div
        v-else
        class="table-responsive"
      >
        <table
          class="table table-sm table-bordered"
        >
          <thead>
            <tr>
              <th scope="col">Semester</th>
              <th scope="col">Rating</th>
              <th v-if="applicant.pes_rating">Equivalent Rating (70)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>FIRST SEMESTER</td>
              <td>{{ applicant.pes_rating.first_rating }}</td>
              <td rowspan="2">{{ applicant.performanceComputation.equivalent }}</td>
            </tr>
            <tr>
              <td>SECOND SEMESTER</td>
              <td>{{ applicant.pes_rating.second_rating }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </Box>
  <Modal id="addSpmsRating">
    <template #header>
      <h5>Add PES Rating</h5>
    </template>
    <template #body>
      <div class="mb-3">
        <label for="" class="form-label">FIRST</label>
        <input
          id=""
          v-model="form.first_rating" type="number" class="form-control" min="1" max="5" name=""
          aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="form.errors.first_rating" />
      </div>
      <div class="mb-3">
        <label for="" class="form-label">SECOND</label>
        <input
          id=""
          v-model="form.second_rating" type="number" class="form-control" min="1" max="5" name=""
          aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="form.errors.second_rating" />
      </div>
      <button class="btn btn-primary" :disabled="form.processing" @click="onSubmit">Submit</button>
    </template>
  </Modal>
</template>
        
<script setup>
  
import Modal from '@/Components/Modal.vue'
import Box from '../UI/Box.vue'
import {useForm} from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
  
const props = defineProps({
  withControls: Boolean,
  isEmployee: Boolean,
  applicant: Object,
  posting_id: Number,
  latest_spms: Array,
})
console.log(props.latest_spms)
const form = useForm({
  first_rating: null,
  second_rating: null,
})

const onSubmit = () => {
  form.post(route('admin.recruitment.pes.store', {user_id: props.applicant.id, job_posting_id: props.posting_id}))
}

</script>