<template>
  <Head title="L&D Competency Gap" />
  <LndLayout>
    <Link :href="route('admin.competency_gap.index')" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left" /></Link>
    <h3 class="mt-3">CY {{ form.year }} Learning and Development Program Monitoring</h3>
    <div class="mt-3">
      <h6>Priority List</h6>
      <div class="table-responsive uppercase">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th scope="col">NAME</th>
              <th scope="col">COMPETENCY GAP ASSESSMENT</th>
              <th scope="col">TRAININGS ATTENDED</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody v-for="employee in props.report.target_staff" :key="employee.id" class="">
            <tr v-for="(lndForm, index) in employee.user.lnd_form" :key="lndForm.id">
              <td v-if="index === 0" scope="row" :rowspan="employee.user.lnd_form.length">{{ employee.user.name }}</td>
              <td>
                <a :href="lndForm.src" target="_blank">
                  {{ `${lndForm.type} ${lndForm.year}` }}
                </a>
              </td>
              <td>
                <ul v-if="lndForm.lnd_training.length > 0">
                  <li v-for="training in lndForm.lnd_training" :key="training.id">
                    {{ 
                      getTraining(training.training)
                    }}
                  </li>
                </ul>
                <Link
                  :href="route('admin.competency_training.create')" 
                  :data="{report_id: props.report.id, lnd_form: lndForm.id, user_id: employee.user.id, target_staff_id: employee.id}"
                  class="btn btn-sm btn-secondary"
                >
                  <i class="fa-solid fa-pen" />&nbsp;&nbsp;EDIT TRAININGS
                </Link>
              </td>
              <td>
                <Link
                  as="button"
                  method="delete"
                  :onBefore="confirm"
                  :href="route('admin.competency_gap.removePriority', 
                               {target_staff: employee.id})" 
                  class="btn btn-sm btn-danger"
                >
                  <i class="fa-solid fa-trash" />
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="row">
        <div class="col">
          <div> Total Number of Targeted Staff	</div>
          <i class="fa-solid fa-users" /> {{ report.status.total_targetted_staff }}
        </div>
        <div class="col">
          <div>
            Total Number of Staff with Learning Intervention
          </div>
          <i class="fa-solid fa-certificate" /> {{ report.status.total_learning_intervention }}
        </div>
        <div class="col">
          <div>
            Percentage 
          </div>{{ report.status.percentage }} <i class="fa-solid fa-percentage" />
        </div>
      </div>

      <hr />
      
      <div class="row mb-3">
        <h6 class="col-12">Employees</h6>
        <div class="mb-3 col-3">
          <input
            id=""
            type="text" class="form-control" name="" aria-describedby="helpId" placeholder="Search" @keyup="onSearchChange"
          />
        </div>
        <ul v-if="searchResult.length" class="list-group px-3">
          <li v-for="employee in searchResult" :key="employee.id" class="list-group-item">
            {{ employee.name }}
            <Link method="post" as="button" :href="route('admin.competency_gap.addPriority', {report_id: props.report.id, user_id: employee.id})" class="btn btn-sm btn-success" :data-emp-id="employee.id" @click="onAddEmployee"><i style="pointer-events: none;" class="fa-solid fa-plus" :only="['report']" /></Link>
          </li>
        </ul>
        <div v-else class="text-muted text-secondary">
          No records
        </div>
      </div>
    </div>
  </LndLayout>
</template>
    
<script setup>
import {Head, useForm} from '@inertiajs/vue3'
import LndLayout from '@/Pages/Admin/L&D/Layout/LndLayout.vue'
import {Link} from '@inertiajs/vue3'
import {computed, ref} from 'vue'
import moment from 'moment'

const props = defineProps({
  employees: Array,
  report: Object,
})

const form = useForm({
  year: props.report.year,
})


const textSearch = ref('')

const searchResult = computed(() => {
  return props.employees.filter(emp => {
    const target = props.report.target_staff.map(t => t.user.id)
    return emp.name.toLowerCase().includes(textSearch.value.toLowerCase()) && !target.includes(emp.id)
  })
})


const onSearchChange = (e) => textSearch.value = e.target.value


const getTraining = (training) => {
  if(training.inclusive_date_from && training.inclusive_date_to){
    return `${training.title_of_learning} (${moment(training.inclusive_date_from).format('MMM D, YYYY')} - ${moment(training.inclusive_date_to).format('MMM D, YYYY')})`
  }else{
    return `${training.title_of_learning}`
  }
}


const confirm = () => window.confirm('Are you sure to remove this staff from priority list?')


</script>