<template>
  <RecruitmentLayout>
    <Link class="btn btn-secondary btn-sm mb-3" :href="route('admin.recruitment.plantilla.index')"><i class="fa-solid fa-arrow-left" /></Link>
    <div>
      <a href="#" data-bs-toggle="modal" data-bs-target="#loadData">Load data from an exisiting plantilla</a>
    </div>
    <form @submit.prevent="create">
      <div class="row">
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input
              id="position"
              v-model="form.position"
              type="text"
              class="form-control"
            />
            <InputError :message="form.errors.position" />
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
        />
        <InputError :message="form.errors.plantilla_item_no" />
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Division</label>
        <select id="" v-model="form.division_id" class="form-select form-select-lg" name="">
          <option v-for="division in divisions" :key="division.id" :value="division.id">{{ division.name }}</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="eligibility" class="form-label">Eligibility</label>
        <input
          id="eligibility"
          v-model="form.eligibility"
          type="text"
          class="form-control"
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
        />
        <InputError :message="form.errors.education" />
      </div>
      <div class="mb-3">
        <label for="training" class="form-label">Training (no. of hours)</label>
        <div class="form-check">
          <input id="training" v-model="form.training_none_required" class="form-check-input" type="checkbox" value="" />
          <label class="form-check-label" for="training"> None Required </label>
        </div>
        
        <input
          id="training"
          v-model="form.training"
          type="number"
          class="form-control"
          :disabled="form.training_none_required"
        />
        <InputError :message="form.errors.training" />
      </div>
      <div class="mb-3">
        <label for="work_experience" class="form-label">Work Experience (no. of years)</label>
        <div class="form-check">
          <input id="work" v-model="form.work_none_required" class="form-check-input" type="checkbox" value="" />
          <label class="form-check-label" for="work"> None Required </label>
        </div>
        <input
          id="work_experience"
          v-model="form.work_experience"
          type="number"
          class="form-control"
          :disabled="form.work_none_required"
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
        />
        <InputError :message="form.errors.competency" />
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
    <Modal id="loadData">
      <template #header>Load position data</template>
      <template #body>
        <div class="table-responsive">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th scope="col">Plantilla</th>
                <th scope="col">Item No</th>
                <th scope="col">Division</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="position in positions" :key="position.id" class="">
                <td scope="row">{{ position.position }}</td>
                <td>{{ position.plantilla_item_no }}</td>
                <td>{{ position.division?.name }}</td>
                <td class="d-flex ">
                  <div data-bs-toggle="modal" data-bs-target="#loadData">
                    <Link class="btn btn-success btn-sm" :href="route('admin.recruitment.plantilla.create', {plantilla: position.id })">Load</Link>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </template>
    </Modal>
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import Modal from '@/Components/Modal.vue'
import InputError from '@/Components/InputError.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const props = defineProps({
  divisions: Array,
  positions: Array,
  plantilla: Object,
})

const form = useForm({
  place_of_assignment: props.plantilla ? props.plantilla.place_of_assignment : 'NEDA Region 2',
  position: props.plantilla ? props.plantilla.position : null,
  salary_grade: props.plantilla ? props.plantilla.salary_grade : null,
  monthly_salary: props.plantilla ? props.plantilla.monthly_salary : null,
  eligibility: props.plantilla ? props.plantilla.eligibility : null,
  education: props.plantilla ? props.plantilla.education : null,
  training: props.plantilla ? props.plantilla.training : null,
  work_experience: props.plantilla ? props.plantilla.work_experience : null,
  competency: props.plantilla ? props.plantilla.competency : null,
  posting_date: props.plantilla ? props.plantilla.posting_date : null,
  closing_date: props.plantilla ? props.plantilla.closing_date : null,
  plantilla_item_no: props.plantilla ? props.plantilla.plantilla_item_no : null,
  documents: props.plantilla ? props.plantilla.documents : null,
  division_id: props.plantilla ? props.plantilla.division_id : '',
  training_none_required: false,
  work_none_required: false,
})

const create = () =>
  form.post(route('admin.recruitment.plantilla.store'), {
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
</script>