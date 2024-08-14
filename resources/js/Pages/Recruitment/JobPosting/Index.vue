<template>
  <Head title="Job Vacancies" />

  <AuthenticatedLayout>
    <h3>Job Vacancies</h3>
    <BreadCrumbs :crumbs="crumbs" />
    <div class="d-flex justify-content-between align-items-center">
      <Filter :filters="props.filters" />
    </div>
    <div class="table-responsive mt-4">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Place of Assignment</th>
            <th>Position Title</th>
            <th>Plantilla Item No.</th>
            <th>Posting Date</th>
            <th>Closing Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in props.job_vacancies.data" :key="item.id">
            <td>{{ item.plantilla.place_of_assignment }}</td>
            <td>{{ item.plantilla.position }}</td>
            <td>{{ item.plantilla.plantilla_item_no }}</td>
            <td>{{ moment(item.posting_date).format('LL') }}</td>
            <td>{{ moment(item.closing_date).format('LL') }}</td>
            <td>
              <Link
                :href="
                  route('recruitment.job_posting.show', {
                    job_posting: item.id
                  })
                "
                class="btn btn-dark "
              >
                Show
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
      <div
        v-if="!props.job_vacancies.data.length"
        class="text-center text-secondary"
      >
        No records
      </div>
    </div>
    <Pagination
      v-if="props.job_vacancies.data.length"
      :links="props.job_vacancies.links"
    />
  </AuthenticatedLayout>
</template>

<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue'
import Filter from '@/Pages/Recruitment/JobPosting/Components/Filter.vue'

const crumbs = computed(() => [
  {
    label: 'Dashboard',
    link: route('dashboard'),
  },
  {
    label: 'Job Vacancies',
  },
])

const props = defineProps({
  job_vacancies: Object,
  filters: Object,
})
</script>
