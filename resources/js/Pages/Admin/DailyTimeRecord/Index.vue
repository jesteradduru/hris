<template>
  <Head title="Daily Time Record" />
  
  <DTRLayout :crumbs="crumbs">
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
    <Link class="btn btn-secondary btn-sm mb-3 ms-auto d-block" as="button" method="post" :href="route('admin.dtr.getDtr')"><i class="fa-solid fa-refresh" /> Refresh DTR</Link>
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
      <div class="d-flex align-items-center justify-content-between gap-4">
        <div class="d-flex align-items-center gap-2">
          <label for="">Show</label>
          <select
            id=""
            v-model="filterForm.entryPerPage"
            class="form-select"
            name=""
            @change="filter"
          >
            <option value="15">15</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
          <span>entries</span>
        </div>
        <Pagination :links="dtrs.links" style="margin-bottom: 0;" />
      </div>
    </div>
  </DTRLayout>
</template>
  
<script setup>
import DTRLayout from '@/Pages/Admin/DailyTimeRecord/DTRLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue'
import {debounce} from 'lodash'

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
  entryPerPage: props.filters.entryPerPage ? props.filters.entryPerPage : 15,
})

const filter = debounce((e) => {
  filterForm.get(route('admin.dtr.dtr.index'), {
    preserveState: true,
  })
}, 1000)
  
</script>
  