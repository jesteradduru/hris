<template>
  <Head title="Job Vacancies" />
  
  <AdminLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>Daily Time Record</h3>

    <div class="row">
      <div class="col-12 col-md-4">
        <div class="mb-3">
          <input
            id=""
            v-model="filterForm.user_id" type="text" class="form-control" name="" aria-describedby="helpId" placeholder="Search" @keyup="filter"
          />
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th scope="col">User</th>
            <th scope="col">Date Time</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="dtr in dtrs.data" :key="dtr.id" class="">
            <td v-if="dtr.user">{{ dtr.user.name }}</td>
            <td v-else>{{ dtr.user_id }}</td>
            <td>{{ moment(dtr.date_time).format('MMM DD, y hh:mm A') }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <Pagination :links="dtrs.links" />
  </AdminLayout>
</template>
  
<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue'
import {debounce} from 'lodash'
// import Filter from '@/Pages/Admin//Recruitment/JobPosting/Components/Filter.vue'
  
const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Daily Time Record',
  },
])

const props = defineProps({
  dtrs: Object,
  filters: Object,
})

const filterForm = useForm({
  user_id: props.filters.user_id,
})

const filter = debounce((e) => {
  filterForm.get(route('admin.daily_time_record.index'), {
    preserveState: true,
  })
}, 1000)
  
</script>
  