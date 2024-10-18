<template>
  <Head title="L&D Competency Gap" />
  <LndLayout fluid>
    <Link :href="route('admin.competency_gap.edit', {competency_gap: props.report_id})" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left" /></Link>
    <h3 class="mt-3">Add Training</h3>
    <div class="training-competency-container uppercase shadow-lg">
      <div class="competency-gap">
        <embed :src="lnd_form.src" type="" class="w-100" style="height: 80vh;" />
      </div>
      <!-- training -->
      <div class="training">
        <div class="training-content">
          <b> Learning Interventions Attended</b>
          <div v-if="props.lnd_form.lnd_training.length > 0">
            <ul>
              <li v-for="training in props.lnd_form.lnd_training" :key="training.id" class="mt-2">
                <div class="d-flex justify-content-between">
                  <div>
                    {{ 
                      getTraining(training.training)
                    }}
                    <a :href="training.learning_and_development.files[0].src " target="_blank">Show</a>
                  </div>
                  <div>
                    <Link as="button" :onBefore="confirm" method="delete" class="text-danger border-0" :href="route('admin.competency_training.destroy', {competency_training: training.id})"><i class="fa-solid fa-x" /></Link>
                  </div>
                </div>
              </li>
            </ul>
          </div>

          <div v-else>
            <span class="text-muted">No records</span>
          </div>

          <hr />
        
          

          <!-- filter form -->
          <div class="row">
            <div class="col-12">
              <b> LND Interventions</b>
            </div>
            <div class="col">
              <div class="mb-3">
                <label for="" class="form-label">From</label>
                <input
                  id=""
                  v-model="filterForm.from" type="date" class="form-control" name="" aria-describedby="helpId"
                  placeholder=""
                />
              </div>
            </div>
            <div class="col">
              <div class="mb-3">
                <label for="" class="form-label">To</label>
                <input
                  id=""
                  v-model="filterForm.to" type="date" class="form-control" name="" aria-describedby="helpId" placeholder=""
                />
              </div>
            </div>
            <div class="col-12">
              <button @click="filter">Filter</button>
            </div>
          </div>

          <!-- end of filter form -->
        
          <ul v-if="props.trainings.length > 0" class="mt-3">
            <li v-for="training in props.trainings" :key="training.id">
              <div class="d-flex justify-content-between">
                <div>
                  {{ 
                    getTraining(training)
                  }}
                  <a :href="training.files[0].src " target="_blank">Show</a>
                </div>
                <div>
                  <Link
                    class="text-success border-0"
                    :href="route('admin.competency_training.store', {
                      training_id: training.id,
                      lnd_form_id: props.lnd_form.id,
                      target_staff_id: props.target_staff_id
                    })"
                    method="post"
                    as="button"
                    :only="['lnd_form', 'trainings']"
                  >
                    <i class="fa-solid fa-plus" />
                  </Link>
                </div>
              </div>
            </li>
          </ul>

          <div v-else>
            <span class="text-muted">No records</span>
          </div>
        </div>
      </div>
      <!-- training -->
    </div>
  </LndLayout>
</template>
      
<script setup>
import {Head} from '@inertiajs/vue3'
import LndLayout from '@/Pages/Admin/L&D/Layout/LndLayout.vue'
import {Link, useForm} from '@inertiajs/vue3'
import moment from 'moment'
import './Create.css'

const props = defineProps({
  trainings: Array,
  report_id: String,
  lnd_form: Object,
  target_staff_id: String,
})

const getTraining = (training) => {
  if(training.inclusive_date_from && training.inclusive_date_to){
    return `${training.title_of_learning} (${moment(training.inclusive_date_from).format('MMM D, YYYY')} - ${moment(training.inclusive_date_to).format('MMM D, YYYY')})`
  }else{
    return `${training.title_of_learning}`
  }
}

const confirm = ( ) => window.confirm('Are you sure to remove this training?')

const filterForm = useForm({
  from: null,
  to: null,
})

const filter = () => {
  filterForm.get(route('admin.competency_training.create', {
    report_id: props.report_id,
    lnd_form: props.lnd_form.id,
    user_id: props.lnd_form.user_id,
  }), {
    preserveScroll: true,
    preserveState: true,
  })
}
  
</script>