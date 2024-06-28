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
              <button :data-id="employee.user_id" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addReward" @click="() => onSelectUser(employee)">
                Add
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- employee table -->

    <Modal modal_id="addReward">
      <template #header>Add Reward</template>
      <template #body>
        <div class="form-group mb-2">
          <div class="form-text">Award</div>
          <input
            id=""
            :value="reward.title"
            type="text" class="form-control form-control-sm" name="" aria-describedby="helpId"
            disabled
          />
        </div>
        <div class="form-group mb-2">
          <label for="" class="form-text">Awarded To</label>
          <input
            id=""
            :value="awardForm.user?.name"
            type="text" class="form-control form-control-sm" name="" aria-describedby="helpId" disabled
            required
          />
        </div>
        <div class="form-group mb-2">
          <label for="" class="form-text">Date Awarded:</label>
          <input
            id=""
            v-model="awardForm.dateAwarded"
            type="date" class="form-control form-control-sm" name="" aria-describedby="helpId"
          />
          <InputError :message="awardForm.errors.date_awarded" />
        </div>
        <button class="btn btn-sm btn-success" @click="addReward">Save</button>
      </template>
    </Modal>
  </EmployeeRewardLayout>
</template>

<script setup>
import EmployeeRewardLayout from '@/Pages/Admin/RnR/EmployeeReward/Layout/EmployeeRewardLayout.vue'
import {useForm, router} from '@inertiajs/vue3'
import moment from 'moment'
import Modal from '@/Components/Modal.vue'

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

const awardForm = useForm({
  user: null, 
  dateAwarded: null,
})


const onSelectUser = (data) => {
  awardForm.user = data
}

const onFilter = () => {
  filterForm.get(route('admin.employees.rewards.rank_by_ipcr', {reward: props.reward.id}), {
    preserveScroll: true,
    preserveState: true,
  })
}

const addReward = () => {
  const employee_id = awardForm.user.user_id

  // console.log(employee_id)

  awardForm.post(route('admin.employees.rewards.store', {
    user: employee_id,
    reward_id: props.reward.id,
    date_awarded: awardForm.dateAwarded,
  }), {
    onSuccess: () => {
      awardForm.user = null
      awardForm.dateAwarded = null
    },
  })
}
  
</script>