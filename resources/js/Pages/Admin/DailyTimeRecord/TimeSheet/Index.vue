<template>
  <Head title="Daily Time Record" />
        
  <DTRLayout :crumbs="crumbs">
    <br />
    <div class="table-responsive">
      <table id="tbl-timesheet" bordered class="table table-sm table-bordered">
        <thead>
          <tr>
            <th>
              <input id="" type="checkbox" name="" @change="markAllEntries" />
            </th>
            <th>Employee</th>
            <th>Purpose</th>
            <th>Remarks</th>
            <th>Pass Type</th>
            <th>Date (mm/dd/yyyy)</th>
            <th>Duration</th>
            <th>Created By</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="entry in timesheet" :key="entry.id">
            <td><input id="" :data-id="entry.id" class="entries" type="checkbox" name="" @change="onCheckEntry" /></td>
            <td>
              <span v-if="entry.user">{{ entry.user.name }}</span>
              <span v-else>ALL</span>
            </td>
            <td v-if="entry.purpose === 'pass'">Pass Slip</td>
            <td v-else-if="entry.purpose === 'supp'">Supplementary</td>
            <td v-else-if="entry.purpose === 'off'">Official</td>
            <td>
              <span v-if="entry.remarks"> {{ entry.remarks }}</span>
            </td>
            <td>
              <span v-if="entry.pass_type == 'personal'">Personal</span>
              <span v-else-if="entry.pass_type == 'official'">Official</span>
            </td>
            <td>
              <span v-if="entry.date">{{ getDate(entry.date) }}</span>
            </td>
            <td>
              <div v-if="entry.purpose === 'pass'">
                {{ get12hr(entry.pass_out) }} -
                {{ get12hr(entry.pass_in) }}
              </div>
              <div v-else-if="entry.purpose === 'supp'">
                <span v-if="entry.supp_am_in">In: {{ get12hr(entry.supp_am_in) }}</span>
                <span v-if="entry.supp_am_in && entry.supp_am_out"> - </span>
                <span v-if="entry.supp_am_out">Out: {{ get12hr(entry.supp_am_out) }}</span>
                <br v-if="(entry.supp_am_in && entry.supp_am_out) || (entry.supp_pm_in && entry.supp_pm_out)" />
                <span v-if="entry.supp_pm_in">In: {{ get12hr(entry.supp_pm_in) }}</span>
                <span v-if="entry.supp_pm_in && entry.supp_pm_out"> - </span>
                <span v-if="entry.supp_pm_out">Out: {{ get12hr(entry.supp_pm_out) }}</span>
              </div>
              <div v-else-if="entry.eo_sched_type == 'PARTIAL'">
                {{ get12hr(entry.eo_start) }}
                {{ get12hr(entry.eo_end) }}
              </div>
              <div v-else-if="entry.off_hours">
                <div class="badge bg-success ">{{ entry.off_hours }} HOURS</div>
              </div>
              <div
                v-else-if="(
                  entry.remarks === 'STUDY_LEAVE' ||
                  entry.remarks === 'ON_SCHOLARSHIP' ||
                  entry.remarks === 'REG_OB' ||
                  entry.remarks === 'REG_SPL' ||
                  entry.remarks === 'REG_VL' ||
                  entry.remarks === 'REG_SL' || 
                  entry.remarks === 'REG_FL') ||
                  entry.remarks === 'PATERNITY_LEAVE' ||
                  entry.remarks === 'MATERNITY_LEAVE' &&
                  entry.reg_multiday === 1"
              >
                {{ getDate(entry.reg_start) }} - 
                {{ getDate(entry.reg_end) }}
              </div>
            </td>
            <!-- <td v-else-if="entry.purpose === 'off'">Official Travel, Leave, Holiday, Tardy, WFH</td> -->
            <td>
              <code>
                {{ entry.created_by.username }}<br />
                {{ getDate(entry.created_at) }}
              </code>
            </td>
            <td>
              <!-- <button class="btn btn-sm btn-success"><i class="fa-solid fa-pen" /></button> -->
              <Link :href="route('admin.dtr.timesheet.destroy', {timesheet: entry.id})" as="button" :onBefore="confirm" class="btn btn-sm btn-danger" method="delete"><i class="fa-solid fa-trash" /></Link>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="timesheet == 0" class="text-center">No Data</div>
    </div>
    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addRow"><i class="fa-solid fa-plus" /> Add row</button>
    <button class="btn btn-sm btn-danger" :onBefore="confirm" :disabled="!selectedEntryDeleteForm.selected_entries.length > 0" @click="destroySelected"><i class="fa-solid fa-trash" /> Delete selected</button>

    <Modal modal_id="addRow">
      <template #header>
        <h3>Add Entry</h3>
      </template>
      <template #body>
        <!-- EMPLOYEE -->
        <div class="mb-3">
          <label for="" class="form-label">Employee</label>
          <div class="d-flex gap-3">
            <div>
              <input
                id="allEmployee"
                v-model="entryForm.rdEmployee"
                class="form-check-input"
                type="radio"
                name="rdEmployee"
                value="all"
              />
              <label for="allEmployee">
                &nbsp; All
              </label>
            </div>
            <div>
              <input
                id="multiEmployee"
                v-model="entryForm.rdEmployee"
                class="form-check-input"
                type="radio"
                name="rdEmployee"
                value="multiple"
              />
              <label for="multiEmployee">
                &nbsp; Multiple
              </label>
            </div>
            <div>
              <input
                id="singleEmployee"
                v-model="entryForm.rdEmployee"
                class="form-check-input"
                type="radio"
                name="rdEmployee"
                value="single"
              />
              <label for="singleEmployee">
                &nbsp; Single
              </label>
            </div>
          </div>
          <div v-for="employee in selectedEmployee" :key="employee.id" :value="employee.id">{{ employee.name }} <small style="cursor: pointer" class="text-danger" :data-id="employee.id" @click="deleteEmployee">X</small></div>
          <div class="d-flex align-items-center">
            <select
              v-if="entryForm.rdEmployee !== 'all'"
              id=""
              v-model="entryForm.employee"
              class="form-select form-select-lg"
              name=""
            >
              <option value="">Select one</option>
              <option v-for="employee in employees" :key="employee.id" :value="employee.id">{{ employee.name }}</option>
            </select>
            <div>
              <button v-if="entryForm.rdEmployee=='multiple'" class="btn btn-primary" @click="addEmployee"><i class="fa fa-plus" /></button>
            </div>
          </div>
          <InputError :message="entryForm.errors.employee" />
        </div>
        <!-- PURPOSE -->
        <div class="mb-3">
          <label for="" class="form-label">Purpose</label>
          <select
            id=""
            v-model="entryForm.purpose"
            class="form-select form-select-lg"
            name=""
          >
            <option value="">Select one</option>
            <option value="pass">Pass Slip</option>
            <option value="supp">Supplementary [ Security guard Log ]</option>
            <option value="off">Official Travel, Leave, Holiday, Tardy, WFH</option>
          </select>
          <InputError :message="entryForm.errors.purpose" />
        </div>
        <!-- DATE -->
        <div v-if="entryForm.purpose">
          <!-- PASS SLIP -->
          <!-- DATE -->
          <div v-if="!entryForm.reg_multiday || entryForm.remarks === 'OFFSETTING'" class="mb-3">
            <label for="" class="form-label">Date</label>
            <input
              id=""
              v-model="entryForm.date"
              type="date"
              class="form-control"
              name=""
              aria-describedby="helpId"
              placeholder=""
            />
            <InputError :message="entryForm.errors.date" />
          </div>
          <div v-if="entryForm.purpose === 'pass'" class="mb-3">
            <PassSlip :entryForm="entryForm" />
          </div>
          <!-- SUPPLEMENTARY -->
          <Supplementary :entryForm="entryForm" />
          <!-- OFFICIAL -->
          <div v-if="entryForm.purpose === 'off'">
            <Official :entryForm="entryForm" />
          </div>
        </div>
        <div class="d-flex align-items-center gap-2">
          <button class="btn btn-sm btn-primary mt-3" :disabled="entryForm.processing" @click="onAdd">Add Entry</button>
          <button type="reset" class="btn btn-sm btn-secondary mt-3" :disabled="entryForm.processing" @click="resetForm">Reset Form</button>
        </div>
      </template>
    </Modal>
  </DTRLayout>
</template>
        
<script setup>
import DTRLayout from '@/Pages/Admin/DailyTimeRecord/DTRLayout.vue'
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import moment from 'moment'
import Modal from '@/Components/Modal.vue'
import InputError from '@/Components/InputError.vue'
import PassSlip from './Components/PassSlip.vue'
import Supplementary from './Components/Supplementary.vue'
import Official from './Components/Official.vue'



const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Daily Time Record',
  },
])

const entryForm = useForm({
  rdEmployee: 'single',
  timesheet_id: props.timesheet.id,
  employee: '',
  multiEmployee: [],
  purpose: '',
  date: '',
  pass_type: 'personal',
  pass_out: '',
  pass_in: '',
  supp_am_in: '',
  supp_am_out: '',
  supp_pm_in: '',
  supp_pm_out: '',
  off_title: '',
  eo_start: '',
  eo_end: '',
  off_hours: '',
  eo_sched_type: '',
  remarks: '',
  reg_multiday: false,
  reg_start: '',
  reg_end: '',
})

const onAdd = () => {
  entryForm.post(route('admin.dtr.timesheet.store'), {
    onSuccess: () => resetForm(),
  })
}

const resetForm = () => {
  entryForm.reset(
    'rdEmployee',
    'employee',
    'multiEmployee',
    'purpose',
    'date',
    'pass_type',
    'pass_out',
    'pass_in',
    'supp_am_in',
    'supp_am_out',
    'supp_pm_in',
    'supp_pm_out',
    'off_title',
    'eo_start',
    'eo_end',
    'off_hours',
    'eo_sched_type',
    'remarks',
    'reg_multiday',
    'reg_start',
    'reg_end',
  )
}

const addEmployee = () => {
  if(!entryForm.multiEmployee.includes(entryForm.employee)){
    entryForm.multiEmployee.push(entryForm.employee)
  }else{
    alert('Employee already exists!')
  }
}

const selectedEmployee = computed(() => {
  return props.employees.filter(employee => entryForm.multiEmployee.includes(employee.id))
})

const deleteEmployee = (e) => {
  const userID = e.target.getAttribute('data-id')
  console.log(entryForm.multiEmployee.filter(employee => employee != userID))

  entryForm.multiEmployee = entryForm.multiEmployee.filter(employee => employee != userID)
}
      
const props = defineProps({
  employees: Array,
  timesheet: Object,
})

const get12hr = (time) => {
  return moment(time, 'HH:mm').format('hh:mm A')
}

const getDate = (date) => {
  return moment(date).format('MMM, DD, Y')
}

const markAllEntries = (e) => {

  const entries = document.querySelectorAll('.entries')

  entries.forEach(entry => {
    entry.checked = e.target.checked
  })

  entries.forEach(entry => {
    if(entry.checked){
      selectedEntryDeleteForm.selected_entries.push(entry.getAttribute('data-id'))
    }else{
      selectedEntryDeleteForm.selected_entries = []
    }
  })
}

const selectedEntryDeleteForm = useForm({
  selected_entries: [],
})

const onCheckEntry = (e) => {
  if(e.target.checked){
    selectedEntryDeleteForm.selected_entries.push(e.target.getAttribute('data-id'))
  }else{
    selectedEntryDeleteForm.selected_entries = selectedEntryDeleteForm.selected_entries.filter(entry => entry !== e.target.getAttribute('data-id'))
  }
}

const destroySelected = () => {
  if(!window.confirm('Are you sure?')) return

  const entries = document.querySelectorAll('.entries')
  const selectedEntries = []

  entries.forEach(entry => {
    if(entry.checked){
      selectedEntries.push(entry.getAttribute('data-id'))
    }
  })

  selectedEntryDeleteForm.selected_entries = selectedEntries

  // console.log(selectedEntries)
  selectedEntryDeleteForm.post(route('admin.dtr.timesheet.deleteSelected'))
}

const confirm = () => window.confirm('Are you sure?')
  
</script>

<style>
  #tbl-timesheet {
    font-size: 11pt;
  }
</style>