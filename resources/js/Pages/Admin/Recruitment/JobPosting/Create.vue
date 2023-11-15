<template>
  <Head title="Job Vacancies" />

  <AdminLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>Add Job Vacancy</h3>
    <hr />
    <form @submit.prevent="create">
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <div class="d-flex gap-2">
              <label for="" class="form-label">Plantilla</label>
              <a target="_blank" :href="route('admin.recruitment.plantilla.create')">Add Plantilla Position</a>
            </div>
            <select id="" class="form-control" name="" :value="plantilla ? plantilla.id : ''" @change="loadData">
              <option value="">Select one</option>
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
        <label for="documents" class="form-label">Requirements</label>
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
          Add record
        </button>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import InputError from '@/Components/InputError.vue'
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import { computed } from 'vue'

const props = defineProps({
  positions: Array,
  plantilla: Object,
})

const form = useForm({
  place_of_assignment: props.plantilla ? props.plantilla.place_of_assignment : null,
  position: props.plantilla ? props.plantilla.position : null,
  salary_grade: props.plantilla ? props.plantilla.salary_grade : null,
  monthly_salary: props.plantilla ? props.plantilla.monthly_salary : null,
  eligibility: props.plantilla ? props.plantilla.eligibility : null,
  education: props.plantilla ? props.plantilla.education : null,
  training: props.plantilla ? props.plantilla.training : null,
  work_experience: props.plantilla ? props.plantilla.work_experience : null,
  competency: props.plantilla ? props.plantilla.competency : null,
  plantilla_item_no: props.plantilla ? props.plantilla.plantilla_item_no : null,
  posting_date: null,
  closing_date: null,
  documents: null,
})

const create = () =>
  form.post(route('admin.recruitment.job_posting.store', {plantilla: props.plantilla.id}), {
    onSuccess: () => {
      form.place_of_assignment = null
      form.position = null
      form.salary_grade = null
      form.monthly_salary = null
      form.eligibility = null
      form.education = null
      form.training = null
      form.work_experience = null
      form.competency = null
      form.posting_date = null
      form.closing_date = null
      form.plantilla_item_no = null
      form.documents = null
    },
  })

const loadData = (e) => {
  const id = e.target.value
  router.visit(route('admin.recruitment.job_posting.create', {plantilla: id}), {
    method: 'get',
    preserveScroll: true,
  })
}

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
    label: 'Add',
  },
])
</script>
