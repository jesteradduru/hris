<template>
  <AuthenticatedLayout>
    <PDSLayout :is-form-dirty="addForm.isDirty">
      <div class="row">
        <div v-if="education.type==='COLLEGE' || education.type === 'GRADUATE'" class="col-12 row mb-3">
          <div class="col-12 col-md-6">
            <label for="" class="form-label">LEVEL (e.g. Doctorate, Masteral, Bachelor) <span class="text-danger">*</span></label>
            <select
              id=""
              v-model="addForm.level"
              class="form-select form-select-sm"
              name=""
            >
              <option value="">Select One</option>
              <option value="TWO_YEAR">Two-year Course</option>
              <option value="BACHELOR">Bachelor's Degree</option>
              <option value="DIPLOMA">Diploma Course</option>
              <option value="MASTERAL">Master's Degree</option>
              <option value="DOCTORATE">Doctorate Degree</option>
            </select>
            
            
            <InputError :message="addForm.errors.level" />
          </div>
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
  
  
        <div class="col-12">
          <button class="btn btn-secondary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#addDistinction">Add Award</button>
          <div class="table-responsive">
            <table class="table table-sm table-bordered">
              <thead>
                <tr>
                  <th scope="col">Awards</th>
                  <th scope="col">Category</th>
                  <th scope="col">File</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <!-- current list -->
                <tr v-for="(award, index) in addForm.scholarship_academic_honors" :key="award.id" class="">
                  <td scope="row">{{ award.title }}</td>
                  <td>{{ award.category }}</td>
                  <td>
                    <a v-if="award.files" target="_blank" :href="award.files[0].src">{{ award.files[0].filename }}</a>
                  </td>
                  <td>
                    <Link :onBefore="confirm" :href="route('profile.pds.academic_distinctions.destroy', {academic_distinction: award.id})" class="btn btn-danger btn-sm" as="button" method="delete">Remove</Link>
                  </td>
                </tr>
                <!-- new list -->
                <tr v-for="(award, index) in addForm.scholarship_academic_honors_new" :key="award.id" class="">
                  <td scope="row">{{ award.title }}</td>
                  <td>{{ award.category }}</td>
                  <td>
                    <span>{{ award.attachment[0].name }}</span>
                  </td>
                  <td>
                    <a href="#" class="btn btn-danger btn-sm" @click="() => removeFromList(index)">Remove</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
  
  
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">ATTACHMENT (DIPLOMA, TOR)</label>
            <ul>
              <li v-for="file in education.files" :key="file.id">
                <a target="_blank" :href="file.src">{{ file.filename }}</a>
              </li>
            </ul>
            <input id="" type="file" class="form-control form-control-sm" name="" placeholder="" aria-describedby="fileHelpId" multiple @input="addDocument" />
            <small class="form-text text-muted">Accepted file formats: pdf</small>
            <InputError :message="addForm.errors['documents']" />
            <InputError :message="addForm.errors['documents.0']" />
          </div>
        </div>
            
        <div class="col-12">
          <Link :href="route('profile.pds.educational_background.edit')" class="btn btn-secondary me-2">
            Back
          </Link>
          <button type="button" class="btn btn-success" @click="onAddCollegeGraduate">
            Save
          </button>
        </div>
      </div>
    </PDSLayout>
    <Modal id="addDistinction">
      <template #header>
        <h5>ADD SCHOLARSHIP/ACADEMIC HONORS RECEIVED</h5>
      </template>
      <template #body>
        <form class="row" @submit.prevent="onAddDistinction">
          <div class="col-12">
            <div class="mb-3">
              <label for="" class="form-label">Award <span class="text-danger">*</span></label>
              <input
                id=""
                v-model="distinctionForm.title"
                required
                type="text" class="form-control form-control-sm" name="" aria-describedby="helpId" placeholder=""
              />
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Category <span class="text-danger">*</span></label>
              <select id="" v-model="distinctionForm.category" required class="form-select form-select-sm" name="">
                <option value="LATIN">LATIN AWARD</option>
                <option value="SPECIAL">SPECIAL AWARD</option>
                <option value="SCHOLARSHIP">SCHOLARSHIP AWARD</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Date Awarded</label>
              <input
                id=""
                v-model="distinctionForm.date_awarded"
                type="date" class="form-control form-control-sm" name="" aria-describedby="helpId" placeholder=""
              />
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Attachment (e.g. Certificate of Award) <span class="text-danger">*</span></label>
              <input
                id=""
                required
                type="file" class="form-control form-control-sm" name="" aria-describedby="helpId" placeholder=""
                @input="addDistinctionDocument"
              />
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-secondary  mb-3">
              Add
            </button>
          </div>
        </form>
      </template>
    </Modal>
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
  
  
const props = defineProps({
  education:Object,
})

const addForm = useForm({
  _method: 'put',
  type: props.education.type,
  name_of_school: props.education.name_of_school,
  basic_ed_degree_course: props.education.basic_ed_degree_course,
  period_from: props.education.period_from,
  period_to: props.education.period_to,
  highest_lvl_units_earned: props.education.highest_lvl_units_earned,
  year_graduated: props.education.year_graduated,
  scholarship_academic_honors: props.education.academic_award,
  scholarship_academic_honors_new: null,
  documents: props.education.documents,
  level: props.education.level,
})

const distinctionForm = useForm({
  title: '',
  date_awarded: null,
  attachment: [],
  category: 'LATIN',
})
  

const onAddCollegeGraduate = () => {
  addForm.post(route('profile.pds.educational_background.college_graduate_study.update', {college_graduate_study: props.education.id}), {
    preserveScroll: true,
  })
}
  
  
const addDocument = (e) => {
  addForm.documents = e.target.files
}

const addDistinctionDocument = (e) => {
  distinctionForm.attachment = e.target.files
}


const onAddDistinction = () => {
  if(addForm.scholarship_academic_honors_new === null){
    addForm.scholarship_academic_honors_new = []
  }
  addForm.scholarship_academic_honors_new.push(distinctionForm.data())
}

const removeFromList = (award_id) => {
  addForm.scholarship_academic_honors_new = addForm.scholarship_academic_honors_new.filter((award, index) => index !== award_id)
}

const confirm = () => window.confirm('Are you sure to remove this award?')
</script>