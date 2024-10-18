<template>
  <Head title="L&D Competency Gap" />
  <LndLayout fluid>
    <Link :href="route('admin.idp.index')" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left" /></Link>
    <div class="training-competency-container shadow-lg mt-3">
      <div class="competency-gap">
        <embed :src="idp.src" type="" class="w-100" style="height: 80vh;" />
      </div>
      <!-- accomplishment form -->
      <div class="training">
        <div class="mb-3">
          <ul>
            <li v-for="acc in props.idp.idp_accomplishment" :key="acc.id" class="mt-2">
              <div class="d-flex justify-content-between">
                <div>
                  {{ acc.activity }}
                </div>
                <div>
                  <Link as="button" :onBefore="confirm" method="delete" class="text-danger border-0" :href="route('admin.idp_accomplishment.destroy', {idp_accomplishment: acc.id})"><i class="fa-solid fa-x" /></Link>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <form @submit.prevent="onSubmit">
          <div class="training-content">
            <div class="mb-3">
              <label for="" class="form-label">ACTIVITY</label>
              <input
                id=""
                v-model="form.activity" type="text" class="form-control" name="" aria-describedby="helpId"
                placeholder=""
              />
              <InputError :message="form.errors.activity" />
            </div>
            <div class="mb-3">
              <label for="" class="form-label">ATTACHMENT</label>
              <input
                id=""
                type="file" class="form-control" name="" aria-describedby="helpId" placeholder=""
                @change="addFile"
              />
              <InputError :message="form.errors['file']" />
              <InputError :message="form.errors['file.0']" />
            </div>
            
            <button type="submit" class="btn btn-success">ADD</button>
          </div>
        </form>
      </div>
    </div>
  </LndLayout>
</template>
      
<script setup>
import {Head} from '@inertiajs/vue3'
import LndLayout from '@/Pages/Admin/L&D/Layout/LndLayout.vue'
import {Link, useForm} from '@inertiajs/vue3'
import moment from 'moment'
import InputError from '@/Components/InputError.vue'
import '@/Pages/Admin/L&D/CompetencyGap/TrainingsAttended/Create.css'

  
const props = defineProps({
  idp: Object,
})

// const getTraining = (training) => {
//   if(training.inclusive_date_from && training.inclusive_date_to){
//     return `${training.title_of_learning} (${moment(training.inclusive_date_from).format('MMM D, YYYY')} - ${moment(training.inclusive_date_to).format('MMM D, YYYY')})`
//   }else{
//     return `${training.title_of_learning}`
//   }
// }

const confirm = ( ) => window.confirm('Are you sure to remove this record?')


const form = useForm({
  activity: '',
  file: [],
})

const addFile = (e) => {
  form.file = e.target.files
}
  

const onSubmit = () => form.post(route('admin.idp_accomplishment.store', {lnd_form_id: props.idp.id}), {
  onSuccess: () => {
    form.file = []
    form.activity = ''
  },
})
  
</script>