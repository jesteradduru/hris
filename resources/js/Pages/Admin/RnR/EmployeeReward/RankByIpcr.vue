<template>
  <EmployeeRewardLayout :reward="reward">
    <div class="row my-3">
      <div class="col-2">
        <div class="mb-3">
          <label for="" class="form-label">Division</label>
          <select
            id=""
            v-model="filterForm.division"
            class="form-select form-select-sm"
            name=""
            @change="onFilter"
          >
            <option value="All">All</option>
            <option v-for="division in divisions" :key="division.id" :value="division.id">{{ division.abbreviation }}</option>
          </select>
        </div>
      </div>
      <div class="col-2">
        <div class="mb-3">
          <label for="" class="form-label">IPCR Year</label>
          <select
            id=""
            v-model="filterForm.year"
            class="form-select form-select-sm"
            name=""
            @change="onFilter"
          >
            <option value="2024">2024</option>
            <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
          </select>
        </div>
      </div>
      <div class="col-3">
        <div class="mb-3">
          <label for="" class="form-label">Technical/Non-Technical</label>
          <select
            id=""
            v-model="filterForm.employee_type"
            class="form-select form-select-sm"
            name=""
            @change="onFilter"
          >
            <option value="">All</option>
            <option value="tech">Technical</option>
            <option value="non-tech">Non-Technical</option>
          </select>
        </div>
      </div>
    </div>

    <!-- employee table -->
    <div
      class="table-responsive"
    >
      <table
        class="table table-bordered table-sm"
      >
        <thead>
          <tr>
            <th scope="col">RANK</th>
            <th scope="col">NAME</th>
            <th scope="col">FIRST SEMESTER</th>
            <th scope="col">SECOND SEMESTER</th>
            <th scope="col">AVERAGE RATING</th>
            <th scope="col">DIVISION</th>
            <th scope="col">ACTION</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(employee, index) in employees" :key="employee.id" class="">
            <td scope="row">{{ index + 1 }}</td>
            <td>{{ employee.name }}</td>
            <td>
              {{ employee.first ? employee.first : 'None' }}
              <a v-if="employee.first_link" :href="employee.first_link" target="_blank"><i class="fa-solid fa-up-right-from-square" /></a>
            </td>
            <td>
              {{ employee.second ? employee.second : 'None' }}
              <a v-if="employee.second_link" :href="employee.second_link" target="_blank"><i class="fa-solid fa-up-right-from-square" /></a>
            </td>
            <td>{{ employee.average }}</td>
            <td>{{ employee.division }}</td>
            <td>
              <button :data-id="employee.id" class="btn btn-success btn-sm">
                Add
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- employee table -->
  </EmployeeRewardLayout>
</template>

<script setup>
import EmployeeRewardLayout from '@/Pages/Admin/RnR/EmployeeReward/Layout/EmployeeRewardLayout.vue'
import {useForm} from '@inertiajs/vue3'
import moment from 'moment'

const props = defineProps({
  reward: Object,
  divisions: Array,
  years: Array,
  employees: Array,
})

const filterForm = useForm({
  division: 'All',
  year: moment().format('Y'),
  employee_type: '',
})

const onFilter = () => {
  filterForm.get(route('admin.employees.rewards.rank_by_ipcr', {reward: props.reward.id}), {
    preserveScroll: true,
    preserveState: true,
  })
}

</script>