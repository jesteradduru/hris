<template>
  <Head title="Edit Job Vacancy" />

  <AdminLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>Update Job Vacancy</h3>
    <hr />
    <form @submit.prevent="update">
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <div class="d-flex gap-2">
              <label for="" class="form-label">Plantilla</label>
              <a target="_blank" :href="route('admin.recruitment.plantilla.create')">Add Plantilla Position</a>
            </div>
            <select id="" class="form-control" name="" :value="plantilla ? plantilla.id : job_posting.plantilla.id" @change="loadData">
              <option v-for="position in positions" :key="position.id" :value="position.id">{{ `${position.position}, ${position.plantilla_item_no}, ${position.division.abbreviation}` }}</option>
            </select>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label for="place_of_assignment" class="form-label">Place of assignment</label>
            <input
              id="place_of_assignment"
              v-model="form.place_of_assignment"
              type="text"
              class="form-control"
              disabled
            />
            <InputError
              :message="form.errors.place_of_assignment"
            />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label for="salary_grade" class="form-label">Salary Grade</label>
            <input
              id="salary_grade"
              v-model="form.salary_grade"
              type="number"
              class="form-control"
              disabled
            />
            <InputError :message="form.errors.salary_grade" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label for="monthly_salary" class="form-label">Monthly Salary</label>
            <input
              id="monthly_salary"
              v-model="form.monthly_salary"
              type="number"
              class="form-control"
              disabled
            />
            <InputError :message="form.errors.monthly_salary" />
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label for="plantilla_item_no" class="form-label">Platilla Item No.</label>
        <input
          id="plantilla_item_no"
          v-model="form.plantilla_item_no"
          type="text"
          class="form-control"
          disabled
        />
        <InputError :message="form.errors.plantilla_item_no" />
      </div>
      <div class="mb-3">
        <label for="eligibility" class="form-label">Eligibility</label>
        <input
          id="eligibility"
          v-model="form.eligibility"
          type="text"
          class="form-control"
          disabled
        />
        <InputError :message="form.errors.eligibility" />
      </div>
      <div class="mb-3">
        <label for="education" class="form-label">Education</label>
        <input
          id="education"
          v-model="form.education"
          type="text"
          class="form-control"
          disabled
        />
        <InputError :message="form.errors.education" />
      </div>
      <div class="mb-3">
        <label for="training" class="form-label">Training</label>
        <input
          id="training"
          v-model="form.training"
          type="text"
          class="form-control"
          disabled
        />
        <InputError :message="form.errors.training" />
      </div>
      <div class="mb-3">
        <label for="work_experience" class="form-label">Work Experience</label>
        <input
          id="work_experience"
          v-model="form.work_experience"
          type="text"
          class="form-control"
          disabled
        />
        <InputError :message="form.errors.work_experience" />
      </div>
      <div class="mb-3">
        <label for="competency" class="form-label">Competency</label>
        <textarea
          id=" competency"
          v-model="form.competency"
          type="text"
          class="form-control"
          rows="4"
          style="white-space: pre-wrap"
          disabled
        />
        <InputError :message="form.errors.competency" />
      </div>
      <div class="mb-3">
        <label for="posting_date" class="form-label">Posting Date</label>
        <input
          id="posting_date"
          v-model="form.posting_date"
          type="date"
          class="form-control"
        />
        <InputError :message="form.errors.posting_date" />
      </div>
      <div class="mb-3">
        <label for="closing_date" class="form-label">Closing Date</label>
        <input
          id="closing_date"
          v-model="form.closing_date"
          type="date"
          class="form-control"
        />
        <InputError :message="form.errors.closing_date" />
      </div>

      <div class="mb-3">
        <label for="documents" class="form-label">Documents</label>
        <textarea
          id="documents"
          v-model="form.documents"
          type="text"
          class="form-control"
          rows="4"
          style="white-space: pre-wrap"
        />
        <InputError :message="form.errors.documents" />
      </div>

      <div class="mb-3">
        <button class="btn btn-primary" :disabled="form.processing">
          <div
            v-if="form.processing"
            class="spinner-border spinner-border-sm"
            role="status"
          >
            <span class="visually-hidden">Loading...</span>
          </div>
          Update record
        </button>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/InputError.vue'
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import { computed } from 'vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'

const props = defineProps({
  job_posting: Object,
  positions: Array,
  plantilla: Object,
})

const loadData = (e) => {
  const id = e.target.value

  router.visit(route('admin.recruitment.job_posting.edit', {job_posting: props.job_posting.id,plantilla: id}), {
    method: 'get',
  })
}

const form = useForm({
  place_of_assignment: props.plantilla ? props.plantilla.place_of_assignment : props.job_posting.plantilla.place_of_assignment,
  position: props.plantilla ? props.plantilla.position : props.job_posting.plantilla.position,
  salary_grade: props.plantilla ? props.plantilla.salary_grade : props.job_posting.plantilla.salary_grade,
  monthly_salary: props.plantilla ? props.plantilla.monthly_salary : props.job_posting.plantilla.monthly_salary,
  eligibility: props.plantilla ? props.plantilla.eligibility : props.job_posting.plantilla.eligibility,
  education: props.plantilla ? props.plantilla.education : props.job_posting.plantilla.education,
  training: props.plantilla ? props.plantilla.training : props.job_posting.plantilla.training,
  work_experience: props.plantilla ? props.plantilla.work_experience : props.job_posting.plantilla.work_experience,
  competency: props.plantilla ? props.plantilla.competency : props.job_posting.plantilla.competency,
  posting_date: props.job_posting.posting_date,
  closing_date: props.job_posting.closing_date,
  plantilla_item_no: props.plantilla ? props.plantilla.plantilla_item_no : props.job_posting.plantilla.plantilla_item_no,
  documents: props.job_posting.documents,
  plantilla_id: props.plantilla ? props.plantilla.id : props.job_posting.plantilla_id,
})

const update = () =>
  form.put(
    route('admin.recruitment.job_posting.update', {
      job_posting: props.job_posting.id,
    }),
  )

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
    link: route('admin.recruitment.job_posting.show', {
      job_posting: props.job_posting.id,
    }),
  },
  {
    label: 'Edit',
  },
])
</script>
