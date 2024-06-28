<template>
  <Head title="Daily Time Record" />
    
  <DTRLayout :crumbs="crumbs">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Timesheet Form Name</th>
          <th>Date</th>
          <th>Created by</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="timesheet in timesheets" :key="timesheet.id">
          <td>{{ timesheet.name }}</td>
          <td>{{ moment(timesheet.created_at).format('MMM D, Y') }}</td>
          <td>{{ timesheet.user.name }}</td>
          <td>
            <Link :href="route('admin.dtr.timesheet.index', {timesheet_draft: timesheet.id})" class="btn btn-sm btn-success"><i class="fa-solid fa-pen" /></Link>
            <Link as="button" method="delete" :href="route('admin.dtr.timesheet_draft.destroy', {timesheet_draft: timesheet.id})" :onBefore="confirm" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash" /></Link>
          </td>
        </tr>
      </tbody>
    </table>
    <button data-bs-toggle="modal" data-bs-target="#AddTimeSheet" class="btn btn-sm btn-success"><i class="fa-solid fa-plus" /> Add TimeSheet Form</button>
    <Modal modal_id="AddTimeSheet">
      <template #header>
        <h3>Add Timesheet Form</h3>
      </template>
      <template #body>
        <form @submit.prevent="add">
          <div class="mb-3">
            <label for="" class="form-label">Name</label>
            <input
              id=""
              v-model="form.name"
              type="text"
              class="form-control"
              aria-describedby="helpId"
              placeholder=""
            />
            <InputError :message="form.errors.name" />
          <!-- <small id="helpId" class="form-text text-muted">Help text</small> -->
          </div>
          <button :disabled="form.processing" type="submit" class="btn btn-sm btn-primary">Add TimeSheet Form</button>
        </form>
      </template>
    </Modal>
  </DTRLayout>
</template>
    
<script setup>
import DTRLayout from '@/Pages/Admin/DailyTimeRecord/DTRLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import Modal from '@/Components/Modal.vue'
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue'
import {debounce} from 'lodash'
import InputError from '@/Components/InputError.vue'
  
const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Daily Time Record',
  },
])

const form = useForm({
  name: '',
})

const add = () => form.post(route('admin.dtr.timesheet_draft.store'))
  
const props = defineProps({
  timesheets: Array,
})
  
const confirm = () => window.confirm('Are you sure?')
</script>
    