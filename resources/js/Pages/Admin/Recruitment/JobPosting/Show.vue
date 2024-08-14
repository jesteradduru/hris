<template>
  <Head title="Job Vacancies" />

  <RecruitmentLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
          <h3>{{ props.job_posting.plantilla.position }}</h3>
          <div class="d-flex">
            <div v-if="!isClosed">
              <Link
                :href="
                  route('admin.recruitment.job_posting.edit', {
                    job_posting: props.job_posting.id
                  })
                "
                class="btn btn-success me-2"
              >
                <i class="fa-solid fa-pen" />
              </Link>
              <Link
                :onBefore="confirm"
                :href="
                  route('admin.recruitment.job_posting.destroy', {
                    job_posting: props.job_posting.id
                  })
                "
                class="btn btn-danger me-2"
                method="delete"
                as="button"
              >
                <i class="fa-solid fa-trash" />
              </Link>
            </div>
            <div v-else>
              <Link
                :href="
                  route('admin.recruitment.job_posting.application_history.index', {
                    job_posting: props.job_posting.id
                  })
                "
                class="btn btn-primary"
              >
                VIEW APPLICATION HISTORY
              </Link>
            </div>
          </div>
        </div>
        <hr />
      </div>
      <div class="col-12 col-md-6">
        <dl>
          <dt>Place of Assignment</dt>
          <dd>{{ `${job_posting.plantilla.place_of_assignment}` }}</dd>
          <dt>Plantilla Item No</dt>
          <dd>{{ job_posting.plantilla.plantilla_item_no }}</dd>
          <dt>Salary Grade</dt>
          <dd>{{ job_posting.plantilla.salary_grade }}</dd>
          <dt>Monthly Salary</dt>
          <dd>
            <Salary :value="job_posting.plantilla.monthly_salary" />
          </dd>
          <dt>Eligibility</dt>
          <dd>{{ job_posting.plantilla.eligibility }}</dd>
          <dt>Competency</dt>
          <dd style="white-space: pre-wrap">
            {{ job_posting.plantilla.competency }}
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
          <dd>{{ job_posting.plantilla.education }}</dd>
          <dt>Training</dt>
          <dd>
            {{ job_posting.plantilla.training }}
            <span v-if="job_posting.plantilla.training == null">None Required</span>
          </dd>
          <dt>Work Experience</dt>
          <dd>
            {{ job_posting.plantilla.work_experience }}
            <span v-if="job_posting.plantilla.work_experience == null">None Required</span>
          </dd>
          <dt>Required Documents</dt>
          <dd class="text-pre-wrap">{{ job_posting.documents }}</dd>
        </dl>
      </div>
    </div>
  </RecruitmentLayout>
</template>

<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import Salary from '@/Components/Salary.vue'
import { Head, Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import RecruitmentLayout from '../Layout/RecruitmentLayout.vue'
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
    label: props.job_posting.plantilla.position,
  },
])

const confirm = () => window.confirm('Are you sure to delete this job posting?')
</script>
