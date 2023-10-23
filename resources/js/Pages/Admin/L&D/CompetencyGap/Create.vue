<template>
  <Head title="L&D Competency Gap" />
  <LndLayout>
    <Link :href="route('admin.competency_gap.index')" class="btn btn-secondary btn-sm"><i class="fa-solid fa-arrow-left" /></Link>
    <h3 class="mt-3">Create Report</h3>
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
      <ul class="list-group list-group-numbered mb-3">
        <li v-for="employee in form.targettedEmployees" :key="employee.id" class="list-group-item">
          {{ employee.name }}
          <button class="btn btn-sm btn-danger" :data-emp-id="employee.id" @click="onRemoveEmployee"><i style="pointer-events: none;" class="fa-solid fa-x" /></button>
        </li>
      </ul>
      
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
})

const form = useForm({
  targettedEmployees: [],
  year: moment().format('YYYY'),
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
    onSuccess: () => form.reset(),
  })
}
</script>