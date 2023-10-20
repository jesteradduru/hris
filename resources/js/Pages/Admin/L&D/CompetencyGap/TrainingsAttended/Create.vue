<template>
  <Head title="L&D Competency Gap" />
  <LndLayout fluid>
    <Link :href="route('admin.competency_gap.edit', {competency_gap: props.report_id})" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left" /></Link>
    <h3 class="mt-3">Add Training</h3>
    <div class="row">
      <div class="col-10">
        <embed :src="lnd_form.src" type="" class="w-100" style="height: 80vh;" />
      </div>
      <div class="col-2">
        <b> Competency Gaps Trainings Attended</b>
        <ul>
          <li v-for="training in props.lnd_form.lnd_training" :key="training.id">
            {{ 
              `${training.training.title_of_learning} (${moment(training.training.inclusive_date_from).format('MMM D, YYYY')} - ${moment(training.training.inclusive_date_to).format('MMM D, YYYY')})`
            }}
          </li>
        </ul>
        <b> Trainings Attended</b>
        <ul>
          <li v-for="training in props.trainings" :key="training.id">
            {{ 
              `${training.title_of_learning} (${moment(training.inclusive_date_from).format('MMM D, YYYY')} - ${moment(training.inclusive_date_to).format('MMM D, YYYY')})`
            }}
            <Link
              class="btn btn-success btn-sm"
              :href="route('admin.competency_training.store', {
                training_id: training.id,
                lnd_form_id: props.lnd_form.id
              })"
              method="post"
              as="button"
              :only="['lnd_form', 'trainings']"
            >
              <i class="fa-solid fa-plus" />
            </Link>
          </li>
        </ul>
      </div>
    </div>
  </LndLayout>
</template>
      
<script setup>
import {Head, useForm} from '@inertiajs/vue3'
import LndLayout from '@/Pages/Admin/L&D/Layout/LndLayout.vue'
import {Link} from '@inertiajs/vue3'
import moment from 'moment'
import InputError from '@/Components/InputError.vue'
  
const props = defineProps({
  trainings: Array,
  report_id: Number,
  lnd_form: Object,
  trainings: Array,
})
  
</script>