<template>
  <Head title="Daily Time Record" />
          
  <DTRLayout :crumbs="crumbs">
    <form @submit.prevent="exportDTR">
      <div class="mb-3">
        <label for="" class="form-label">Year</label>
        <select
          id=""
          v-model="yearNow"
          class="form-select form-select-lg"
          name=""
        >
          <option selected>Select one</option>
          <option :value="yearNow">{{ yearNow }}</option>
          <option :value="yearNow-1">{{ yearNow-1 }}</option>
          <option :value="yearNow-2">{{ yearNow-2 }}</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Month</label>
        <select
          id=""
          v-model="monthNow"
          class="form-select form-select-lg"
          name=""
        >
          <option selected>Select one</option>
          <option value="01">January</option>
          <option value="02">February</option>
          <option value="03">March</option>
          <option value="04">April</option>
          <option value="05">May</option>
          <option value="06">June</option>
          <option value="07">July</option>
          <option value="08">August</option>
          <option value="09">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
      </div>
      <a :href="route('admin.dtr.export', {...form.data()})" target="_blank">Export</a>
    </form>
  </DTRLayout>
</template>
          
<script setup>
import DTRLayout from '@/Pages/Admin/DailyTimeRecord/DTRLayout.vue'
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue'
import {debounce} from 'lodash'
import Modal from '@/Components/Modal.vue'
import InputError from '@/Components/InputError.vue'
  
  
const confirm = () => window.confirm('Are you sure?')

const yearNow = moment().format('Y')
const monthNow = moment().format('MM')

const form = useForm({
  year: yearNow,
  month: monthNow,
})



    
</script>
          