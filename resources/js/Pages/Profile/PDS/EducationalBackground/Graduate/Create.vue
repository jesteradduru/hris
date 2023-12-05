<template>
  <AuthenticatedLayout>
    <PDSLayout :is-form-dirty="addForm.isDirty">
      <div class="row">
        <div class="col-12">
          <div v-if="addForm.recentlySuccessful" class="alert alert-success">Saved</div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">NAME OF SCHOOL</label>
            <input v-model="addForm.name_of_school" type="text" class="form-control form-control-sm" />
            <InputError :message="addForm.errors.name_of_school" />
          </div>
        </div>
  
  
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">BASIC EDUCATION/DEGREE/COURSE</label>
            <input v-model="addForm.basic_ed_degree_course" type="text" class="form-control form-control-sm" />
            <p class="form-text text-muted">
              Write in full
            </p>
            <InputError :message="addForm.errors.basic_ed_degree_course" />
          </div>
        </div>
  
  
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">From</label>
            <input v-model="addForm.period_from" type="number" class="form-control form-control-sm" />
            <InputError :message="addForm.errors.period_from" />
          </div>
        </div>
  
  
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">To</label>
            <input v-model="addForm.period_to" type="number" class="form-control form-control-sm" />
            <InputError :message="addForm.errors.period_to" />
          </div>
        </div>
  
  
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">HIGHEST LEVEL/UNITS EARNED (if not graduated)</label>
            <input v-model="addForm.highest_lvl_units_earned" type="number" class="form-control form-control-sm" />
            <InputError :message="addForm.errors.highest_lvl_units_earned" />
          </div>
        </div>
  
  
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">YEAR GRADUATED</label>
            <input v-model="addForm.year_graduated" type="number" class="form-control form-control-sm" />
            <InputError :message="addForm.errors.year_graduated" />
          </div>
        </div>
  
  
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</label>
            <input v-model="addForm.scholarship_academic_honors" type="text" class="form-control form-control-sm" />
            <InputError :message="addForm.errors.scholarship_academic_honors" />
          </div>
        </div>
  
  
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">ATTACHMENT (DIPLOMA, TOR)</label>
            <input id="" type="file" class="form-control form-control-sm" name="" placeholder="" aria-describedby="fileHelpId" multiple @input="addDocument" />
            <small class="form-text text-muted">Accepted file formats: pdf</small>
            <InputError :message="addForm.errors['documents']" />
            <InputError :message="addForm.errors['documents.0']" />
          </div>
        </div>
            
        <div class="col-12">
          <button type="button" class="btn btn-success  mb-3" @click="onAddCollegeGraduate">
            Add
          </button>
        </div>
      </div>
    </PDSLayout>
    <!-- END OF EDIT COLLEGE GRADUATE -->
  </AuthenticatedLayout>
</template>
  
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import Spinner from '@/Components/Spinner.vue'
import { useForm, Link } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import Modal from '@/Components/Modal.vue'
import {ref, computed} from 'vue'
  
  
  
const addForm = useForm({
  type: 'GRADUATE',
  name_of_school: null,
  basic_ed_degree_course: null,
  period_from: null,
  period_to: null,
  highest_lvl_units_earned: null,
  year_graduated: null,
  scholarship_academic_honors: null,
  documents: [],
})
  

const onAddCollegeGraduate = () => {
  addForm.post(route('profile.pds.college_graduate_study.store', {educational_background: props.educational_background?.id}), {
    preserveScroll: true,
  })
}
  
  
const addDocument = (e) => {
  addForm.documents = []
  for(const file of e.target.files){
    addForm.documents.push(file)
  }
}

  
</script>