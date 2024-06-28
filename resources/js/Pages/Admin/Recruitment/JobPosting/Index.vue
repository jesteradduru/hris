<template>
  <Head title="Job Vacancies" />
  <RecruitmentLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>Job Vacancies</h3>
    <div class="d-flex justify-content-between align-items-center">
      <Filter :filters="props.filters" />
      <div>
        <Link
          :href="route('admin.recruitment.job_posting.create')"
          class="btn btn-primary"
        >
          Add Job Vacancy
        </Link>
      </div>
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
            <th>Applicants</th>
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
            <td>{{ item.job_application_count }}</td>
            <td>
              <Link
                :href="
                  route(
                    'admin.recruitment.job_posting.show',
                    { job_posting: item.id }
                  )
                "
                class="btn btn-dark"
              >
                Show
              </Link>
              <Link
                :href="
                  route(
                    'admin.recruitment.job_posting.destroy',
                    { job_posting: item.id }
                  )
                "
                method="delete"
                as="button"
                :onBefore="confirm"
                class="btn btn-danger"
              >
                Delete
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
  </RecruitmentLayout>
</template>

<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue'
import Filter from '@/Pages/Admin//Recruitment/JobPosting/Components/Filter.vue'


const confirm = () => window.confirm('Are you sure to delete this job posting?')

const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Recruitment',
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
