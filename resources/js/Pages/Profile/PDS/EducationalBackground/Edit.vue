<template>
  <AuthenticatedLayout>
    <PDSLayout :is-form-dirty="form.isDirty">
      <form @submit.prevent="createUpdateEducationalBackground">
        <div class="row">
          <!-- Elementary -->
          <div class="col-12">
            <h5>Elementary</h5>
          </div>

          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">NAME OF SCHOOL</label>
              <input v-model="form.elem_name_of_school" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.elem_name_of_school" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">BASIC EDUCATION/DEGREE/COURSE</label>
              <input v-model="form.elem_basic_ed_degree_course" type="text" class="form-control form-control-sm" />
              <p class="form-text text-muted">
                Write in full
              </p>
              <InputError :message="form.errors.elem_basic_ed_degree_course" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">From</label>
              <input v-model="form.elem_period_from" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.elem_period_from" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">To</label>
              <input v-model="form.elem_period_to" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.elem_period_to" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">HIGHEST LEVEL/UNITS EARNED (if not graduated)</label>
              <input v-model="form.elem_highest_lvl_units_earned" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.elem_highest_lvl_units_earned" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">YEAR GRADUATED</label>
              <input v-model="form.elem_year_graduated" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.elem_year_graduated" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</label>
              <input v-model="form.elem_scholarship_academic_honors" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.elem_scholarship_academic_honors" />
            </div>
          </div>


          <!-- SECONDARY -->
          <div class="col-12">
            <h5>Secondary</h5>
          </div>

          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">NAME OF SCHOOL</label>
              <input v-model="form.second_name_of_school" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.second_name_of_school" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">BASIC EDUCATION/DEGREE/COURSE</label>
              <input v-model="form.second_basic_ed_degree_course" type="text" class="form-control form-control-sm" />
              <p class="form-text text-muted">
                Write in full
              </p>
              <InputError :message="form.errors.second_basic_ed_degree_course" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">From</label>
              <input v-model="form.second_period_from" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.second_period_from" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">To</label>
              <input v-model="form.second_period_to" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.second_period_to" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">HIGHEST LEVEL/UNITS EARNED (if not graduated)</label>
              <input v-model="form.second_highest_lvl_units_earned" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.second_highest_lvl_units_earned" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">YEAR GRADUATED</label>
              <input v-model="form.second_year_graduated" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.second_year_graduated" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</label>
              <input v-model="form.second_scholarship_academic_honors" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.second_scholarship_academic_honors" />
            </div>
          </div>

          <!-- Vocational -->
          <div class="col-12">
            <h5>Vocational/Trade Course</h5>
          </div>

          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">NAME OF SCHOOL</label>
              <input v-model="form.vocational_name_of_school" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.vocational_name_of_school" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">BASIC EDUCATION/DEGREE/COURSE</label>
              <input v-model="form.vocational_basic_ed_degree_course" type="text" class="form-control form-control-sm" />
              <p class="form-text text-muted">
                Write in full
              </p>
              <InputError :message="form.errors.vocational_basic_ed_degree_course" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">From</label>
              <input v-model="form.vocational_period_from" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.vocational_period_from" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">To</label>
              <input v-model="form.vocational_period_to" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.vocational_period_to" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">HIGHEST LEVEL/UNITS EARNED (if not graduated)</label>
              <input v-model="form.vocational_highest_lvl_units_earned" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.vocational_highest_lvl_units_earned" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">YEAR GRADUATED</label>
              <input v-model="form.vocational_year_graduated" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.vocational_year_graduated" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</label>
              <input v-model="form.vocational_scholarship_academic_honors" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.vocational_scholarship_academic_honors" />
            </div>
          </div>


          <!-- College -->
          <div class="col-12">
            <h5>College</h5>
            <div>
              <button data-type="COLLEGE" type="button" class="btn btn-secondary  mb-3" data-bs-toggle="modal" data-bs-target="#addCollege" @click="onToggleAddForm">
                Add
              </button>
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th scope="col">NAME OF SCHOOL</th>
                      <th scope="col">DEGREE/COURSE</th>
                      <th scope="col">PERIOD OF ATTENDANCE</th>
                      <th scope="col">UNITS EARNED</th>
                      <th scope="col">YEAR GRADUATED </th>
                      <th scope="col">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</th>
                      <th scope="col">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="college in colleges" :key="college.id" class="">
                      <td scope="row">{{ college.name_of_school }}</td>
                      <td>{{ college.basic_ed_degree_course }}</td>
                      <td>{{ `${college.period_from} - ${college.period_to}` }}</td>
                      <td>{{ college.highest_lvl_units_earned }}</td>
                      <td>{{ college.year_graduated }}</td>
                      <td>{{ college.scholarship_academic_honors }}</td>
                      <td>
                        <div class="d-flex gap-2">
                          <button
                            class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editCollege"
                            :data-id="college.id"
                            @click="onToggleEditForm"
                          >
                            Edit
                          </button>
                          <Link
                            as="button" class="btn btn-danger btn-sm" method="delete"
                            preserve-scroll
                            :onBefore="confirm"
                            :href="route('profile.pds.college_graduate_study.destroy', {
                              college_graduate_study: college.id
                            })"
                          >
                            Delete
                          </Link>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- end of COLLEGE -->


          <!-- Graduate Studies -->
          
          <div class="col-12">
            <h5>Graduate Studies</h5>
            <div>
              <button data-type="GRADUATE" type="button" class="btn btn-secondary  mb-3" data-bs-toggle="modal" data-bs-target="#addCollege" @click="onToggleAddForm">
                Add
              </button>
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th scope="col">NAME OF SCHOOL</th>
                      <th scope="col">DEGREE/COURSE</th>
                      <th scope="col">PERIOD OF ATTENDANCE</th>
                      <th scope="col">UNITS EARNED</th>
                      <th scope="col">YEAR GRADUATED </th>
                      <th scope="col">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</th>
                      <th scope="col">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="college in graduate_studies" :key="college.id" class="">
                      <td scope="row">{{ college.name_of_school }}</td>
                      <td>{{ college.basic_ed_degree_course }}</td>
                      <td>{{ `${college.period_from} - ${college.period_to}` }}</td>
                      <td>{{ college.highest_lvl_units_earned }}</td>
                      <td>{{ college.year_graduated }}</td>
                      <td>{{ college.scholarship_academic_honors }}</td>
                      <td>
                        <div class="d-flex gap-2">
                          <button
                            class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editCollege"
                            :data-id="college.id"
                            @click="onToggleEditForm"
                          >
                            Edit
                          </button>
                          <Link
                            as="button" class="btn btn-danger btn-sm" method="delete"
                            preserve-scroll
                            :onBefore="confirm"
                            :href="route('profile.pds.college_graduate_study.destroy', {
                              college_graduate_study: college.id
                            })"
                          >
                            Delete
                          </Link>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- end of GRADUATE STUDIES -->

          <div class="col-12 mt-3">
            <div class="d-flex justify-content-between">
              <div class="d-flex gap-2">
                <div class="d-flex align-items-center">
                  <b v-if="form.isDirty" class="text-danger form-status">Not Saved</b>
                </div>
                <button
                  type="submit" :disabled="!form.isDirty && form.wasSuccessful"
                  class="btn btn-success"
                >
                  <Spinner :processing="form.processing" /> 
                  <span
                    v-if="!form.isDirty &&
                      form.wasSuccessful"
                  ><i class="bi-file-earmark-check" /> Saved</span>
                  <span v-else><i v-if="!form.processing" class="bi-file-earmark-arrow-up" /> Save</span>
                </button>
              </div>
              <div class="d-flex gap-2">
                <Link
                  :href="route('profile.pds.family_background.edit')" type="button" :disabled="form.isDirty"
                  class="btn btn-dark"
                >
                  <i class="fa-solid fa-arrow-left" />
                </Link>
                <Link
                  :href="route('profile.pds.civil_service_eligibility.index')" type="button" :disabled="form.isDirty"
                  class="btn btn-dark"
                >
                  <i class="fa-solid fa-arrow-right" />
                </Link>
              </div>
            </div>
          </div>
        </div>
      </form>
    </PDSLayout>

    <!-- add education -->
    <Modal id="addCollege" :modal-xl="true">
      <template #header>
        <h5>ADD {{ addForm.type }}</h5>
      </template>
      <template #body>
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
              <InputError :message="form.errors['documents']" />
              <InputError :message="form.errors['documents.0']" />
            </div>
          </div>
          
          <div class="col-12">
            <button type="button" class="btn btn-success  mb-3" @click="onAddCollegeGraduate">
              Add
            </button>
          </div>
        </div>
      </template>
    </Modal>
    <!-- EDIT COLLEGE -->
    <Modal id="editCollege" :modal-xl="true">
      <template #header>
        <h5>EDIT {{ editForm.type }}</h5>
      </template>
      <template #body>
        <div class="row">
          <div class="col-12">
            <div v-if="editForm.recentlySuccessful" class="alert alert-success">Saved</div>
          </div>
          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">NAME OF SCHOOL</label>
              <input v-model="editForm.name_of_school" type="text" class="form-control form-control-sm" />
              <InputError :message="editForm.errors.name_of_school" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">BASIC EDUCATION/DEGREE/COURSE</label>
              <input v-model="editForm.basic_ed_degree_course" type="text" class="form-control form-control-sm" />
              <p class="form-text text-muted">
                Write in full
              </p>
              <InputError :message="editForm.errors.basic_ed_degree_course" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">From</label>
              <input v-model="editForm.period_from" type="number" class="form-control form-control-sm" />
              <InputError :message="editForm.errors.period_from" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">To</label>
              <input v-model="editForm.period_to" type="number" class="form-control form-control-sm" />
              <InputError :message="editForm.errors.period_to" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">HIGHEST LEVEL/UNITS EARNED (if not graduated)</label>
              <input v-model="editForm.highest_lvl_units_earned" type="number" class="form-control form-control-sm" />
              <InputError :message="editForm.errors.highest_lvl_units_earned" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">YEAR GRADUATED</label>
              <input v-model="editForm.year_graduated" type="number" class="form-control form-control-sm" />
              <InputError :message="editForm.errors.year_graduated" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</label>
              <input v-model="editForm.scholarship_academic_honors" type="text" class="form-control form-control-sm" />
              <InputError :message="editForm.errors.scholarship_academic_honors" />
            </div>
          </div>

          <div class="col-12">
            <button type="button" class="btn btn-success  mb-3" @click="onUpdateCollegeGraduate">
              Update
            </button>
          </div>
        </div>
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
  educational_background: Object,
  college_graduate_studies: Object,
})

let form = null

if(!props.educational_background){
  form = useForm({
    elem_name_of_school: null,
    elem_basic_ed_degree_course: null,
    elem_period_from: null,
    elem_period_to: null,
    elem_highest_lvl_units_earned: null,
    elem_year_graduated: null,
    elem_scholarship_academic_honors: null,
    second_name_of_school: null,
    second_basic_ed_degree_course: null,
    second_period_from: null,
    second_period_to: null,
    second_highest_lvl_units_earned: null,
    second_year_graduated: null,
    second_scholarship_academic_honors: null,
    vocational_name_of_school: null,
    vocational_basic_ed_degree_course: null,
    vocational_period_from: null,
    vocational_period_to: null,
    vocational_highest_lvl_units_earned: null,
    vocational_year_graduated: null,
    vocational_scholarship_academic_honors: null,
  })
}else{
  form = useForm({
    elem_name_of_school: props.educational_background.elem_name_of_school,
    elem_basic_ed_degree_course: props.educational_background.elem_basic_ed_degree_course,
    elem_period_from: props.educational_background.elem_period_from,
    elem_period_to: props.educational_background.elem_period_to,
    elem_highest_lvl_units_earned: props.educational_background.elem_highest_lvl_units_earned,
    elem_year_graduated: props.educational_background.elem_year_graduated,
    elem_scholarship_academic_honors: props.educational_background.elem_scholarship_academic_honors,
    second_name_of_school: props.educational_background.second_name_of_school,
    second_basic_ed_degree_course: props.educational_background.second_basic_ed_degree_course,
    second_period_from: props.educational_background.second_period_from,
    second_period_to: props.educational_background.second_period_to,
    second_highest_lvl_units_earned: props.educational_background.second_highest_lvl_units_earned,
    second_year_graduated: props.educational_background.second_year_graduated,
    second_scholarship_academic_honors: props.educational_background.second_scholarship_academic_honors,
    vocational_name_of_school: props.educational_background.vocational_name_of_school,
    vocational_basic_ed_degree_course: props.educational_background.vocational_basic_ed_degree_course,
    vocational_period_from: props.educational_background.vocational_period_from,
    vocational_period_to: props.educational_background.vocational_period_to,
    vocational_highest_lvl_units_earned: props.educational_background.vocational_highest_lvl_units_earned,
    vocational_year_graduated: props.educational_background.vocational_year_graduated,
    vocational_scholarship_academic_honors: props.educational_background.vocational_scholarship_academic_honors,
  })
}

const createUpdateEducationalBackground =  () => {
  form.post(route('profile.pds.educational_background.store_or_update'), {
    preserveScroll: true,
  })
}


const addForm = useForm({
  type: 'COLLEGE',
  name_of_school: null,
  basic_ed_degree_course: null,
  period_from: null,
  period_to: null,
  highest_lvl_units_earned: null,
  year_graduated: null,
  scholarship_academic_honors: null,
  documents: [],
})

const editId = ref(null)


const editForm = useForm({
  type: 'COLLEGE',
  name_of_school: null,
  basic_ed_degree_course: null,
  period_from: null,
  period_to: null,
  highest_lvl_units_earned: null,
  year_graduated: null,
  scholarship_academic_honors: null,
})



const onToggleAddForm = (e) => {
  const type = e.target.getAttribute('data-type')
  addForm.type = type
}

const onToggleEditForm = (e) => {
  const id  = e.target.getAttribute('data-id')
  const data = props.college_graduate_studies.filter(ed => ed.id == id)[0]
  editForm.type = data.type
  editForm.name_of_school = data.name_of_school
  editForm.basic_ed_degree_course = data.basic_ed_degree_course
  editForm.period_from = data.period_from
  editForm.period_to = data.period_to
  editForm.highest_lvl_units_earned = data.highest_lvl_units_earned
  editForm.year_graduated = data.year_graduated
  editForm.scholarship_academic_honors = data.scholarship_academic_honors
  editId.value = id
}

const onAddCollegeGraduate = () => {
  addForm.post(route('profile.pds.college_graduate_study.store', {educational_background: props.educational_background?.id}), {
    preserveScroll: true,
  })
}

const onUpdateCollegeGraduate = () => {
  editForm.put(route('profile.pds.college_graduate_study.update', {educational_background: props.educational_background?.id, college_graduate_study: editId.value}), {
    preserveScroll: true,
  })
}

const colleges = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'COLLEGE')
})
const graduate_studies = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'GRADUATE')
})

const confirm = () => window.confirm('Are you sure to delete this?')

const addDocument = (e) => {
  addForm.reset()
  for(const file of e.target.files){
    addForm.documents.push(file)
  }
}


</script>