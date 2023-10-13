<template>
  <Head title="Job Vacancies" />

  <AdminLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
          <h3>{{ props.job_posting.position }}</h3>
          <div class="d-flex gap-2">
            <!-- <Link
              :href="
                route('admin.recruitment.job_application.index', {
                  job_posting: props.job_posting.id
                })
              "
              class="btn btn-success d-none"
            >
              View Applications
            </Link> -->
            <Link
              :href="
                route('admin.recruitment.job_posting.edit', {
                  job_posting: props.job_posting.id
                })
              "
              class="btn btn-primary"
            >
              Edit
            </Link>
            <Link
              :onBefore="confirm"
              :href="
                route('admin.recruitment.job_posting.destroy', {
                  job_posting: props.job_posting.id
                })
              "
              class="btn btn-danger"
              method="delete"
              as="button"
            >
              Delete
            </Link>
          </div>
        </div>
        <hr />
      </div>
      <div class="col-12 col-md-6">
        <dl>
          <dt>Place of Assignment</dt>
          <dd>{{ props.job_posting.place_of_assignment }}</dd>
          <dt>Plantilla Item No</dt>
          <dd>{{ props.job_posting.plantilla_item_no }}</dd>
          <dt>Salary Grade</dt>
          <dd>{{ props.job_posting.salary_grade }}</dd>
          <dt>Monthly Salary</dt>
          <dd>
            <Salary :value="props.job_posting.monthly_salary" />
          </dd>
          <dt>Eligibility</dt>
          <dd>{{ props.job_posting.eligibility }}</dd>
          <dt>Competency</dt>
          <dd style="white-space: pre-wrap">
            {{ props.job_posting.competency }}
          </dd>
          <dt>Posting Date</dt>
          <dd>{{ props.job_posting.posting_date }}</dd>
          <dt>Closing Date</dt>
          <dd>{{ props.job_posting.closing_date }}</dd>
        </dl>
      </div>
      <div class="col-12 col-md-6">
        <dl>
          <dt>Education</dt>
          <dd>{{ props.job_posting.education }}</dd>
          <dt>Training</dt>
          <dd>{{ props.job_posting.training }}</dd>
          <dt>Work Experience</dt>
          <dd>{{ props.job_posting.work_experience }}</dd>
          <dt>Documents</dt>
          <dd class="text-pre-wrap">{{ props.job_posting.documents }}</dd>
        </dl>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import Salary from '@/Components/Salary.vue'
import { Head, Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
const props = defineProps({
  job_posting: Object,
})

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
    link: route('admin.recruitment.job_posting.index'),
  },
  {
    label: props.job_posting.position,
  },
])

const confirm = () => window.confirm('Are you sure to delete this job posting?')
</script>
