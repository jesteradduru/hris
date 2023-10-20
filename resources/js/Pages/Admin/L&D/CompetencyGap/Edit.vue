<template>
  <Head title="L&D Competency Gap" />
  <LndLayout>
    <Link :href="route('admin.competency_gap.index')" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left" /></Link>
    <h3 class="mt-3">Edit Report</h3>
    <div class="mt-3">
      <div class="mb-3">
        <label for="" class="form-label">Year</label>
        <input
          id=""
          v-model="form.year" type="text" class="form-control" name="" aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="form.errors.year" />
      </div>

      <h6>Priority List</h6>
      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th scope="col">NAME</th>
              <th scope="col">COMPETENCY GAP ASSESSMENT</th>
              <th scope="col">TRAININGS ATTENDED</th>
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
                <ul>
                  <li v-for="training in lndForm.lnd_training" :key="training.id">
                    {{ 
                      `${training.training.title_of_learning} (${moment(training.training.inclusive_date_from).format('MMM D, YYYY')} - ${moment(training.training.inclusive_date_to).format('MMM D, YYYY')})`
                    }}
                  </li>
                </ul>
                <Link
                  :href="route('admin.competency_training.create', 
                               {report_id: props.report.id, lnd_form: lndForm.id, user_id: employee.user.id})" 
                  class="btn btn-sm btn-success"
                >
                  <i class="fa-solid fa-plus" />
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      
      <div class="mb-3">
        <h6>Employees</h6>
        <div class="mb-3">
          <input
            id=""
            type="text" class="form-control" name="" aria-describedby="helpId" placeholder="Search" @keyup="onSearchChange"
          />
        </div>
        <ul class="list-group">
          <li v-for="employee in searchResult" :key="employee.id" class="list-group-item">
            {{ employee.name }}
            <button class="btn btn-sm btn-success" :data-emp-id="employee.id" @click="onAddEmployee"><i style="pointer-events: none;" class="fa-solid fa-plus" /></button>
          </li>
        </ul>
      </div>

      <button type="button" class="btn btn-primary" @click="onSubmit">Save Report</button>
    </div>
  </LndLayout>
</template>
    
<script setup>
import {Head, useForm} from '@inertiajs/vue3'
import LndLayout from '@/Pages/Admin/L&D/Layout/LndLayout.vue'
import {Link} from '@inertiajs/vue3'
import {computed, ref} from 'vue'
import moment from 'moment'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  employees: Array,
  report: Object,
})

const form = useForm({
  targettedEmployees: [],
  year: props.report.year,
})


const textSearch = ref('')

const searchResult = computed(() => {
  return props.employees.filter(emp => {
    const target = form.targettedEmployees.map(t => t.id)
    return emp.name.toLowerCase().includes(textSearch.value.toLowerCase()) && !target.includes(emp.id)
  })
})


const onSearchChange = (e) => textSearch.value = e.target.value

const onAddEmployee = (e) => {
  const employee = props.employees.filter(emp => emp.id == e.target.getAttribute('data-emp-id'))
  if(employee.length > 0){
    form.targettedEmployees.push({
      id: employee[0].id,
      name: employee[0].name,
    })
  }

}

const onRemoveEmployee = (e) => {
  const id = e.target.getAttribute('data-emp-id')
  form.targettedEmployees = form.targettedEmployees.filter(t => {
    return t.id != id
  })

}



const onSubmit = () => {
  form.post(route('admin.competency_gap.store'), {
    onSuccess: form.reset(),
  })
}
</script>