<template>
  <AuthenticatedLayout>
    <PDSLayout :is-form-dirty="form.isDirty">
      <form @submit.prevent="createUpdateEducationalBackground">
        <div class="row">
          <div class="col-12 mb-3">
            <div class="d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                <i class="fa-solid fa-graduation-cap fs-4 text-primary"></i>
              </div>
              <div>
                <h4 class="fw-bold text-dark mb-1">Educational Background</h4>
                <p class="text-muted mb-0 small">Manage your educational history across all levels.</p>
              </div>
            </div>
          </div>

          <!-- Elementary -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
              <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                <h6 class="mb-0 text-dark fw-bold text-uppercase"><i class="fa-solid fa-school text-primary me-2"></i>Elementary</h6>
                <Link class="btn btn-primary btn-sm rounded-pill px-3 fw-medium" :href="route('profile.pds.educational_background.college_graduate_study.create')" :data="{type: 'ELEMENTARY'}">
                  <i class="fa-solid fa-plus me-1"></i> Add Record
                </Link>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0 text-sm">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem;">
                      <tr>
                        <th class="ps-4">Name of School</th>
                        <th>Degree/Course</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Units Earned</th>
                        <th>Year Graduated</th>
                        <th>Scholarship/Honors</th>
                        <th class="pe-4 text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-if="elementary.length === 0">
                        <td colspan="8" class="text-center py-4 text-muted fst-italic">No elementary education records added.</td>
                      </tr>
                      <tr v-for="college in elementary" :key="college.id">
                        <td class="ps-4 fw-medium text-dark">{{ college.name_of_school }}</td>
                        <td>{{ college.basic_ed_degree_course || '-' }}</td>
                        <td>{{ college.period_from }}</td>
                        <td>{{ college.period_to }}</td>
                        <td>{{ college.highest_lvl_units_earned || '-' }}</td>
                        <td>{{ college.year_graduated }}</td>
                        <td>
                          <ul class="mb-0 ps-3" v-if="college.academic_award && college.academic_award.length">
                            <li v-for="award in college.academic_award" :key="award.id">
                              <span class="badge bg-info bg-opacity-25 text-dark border border-info rounded-pill px-2">{{ award.title }}</span>
                            </li>
                          </ul>
                          <span v-else class="text-muted">-</span>
                        </td>
                        <td class="pe-4 text-center">
                          <div class="d-flex gap-2 justify-content-center">
                            <Link class="btn btn-light btn-sm text-primary rounded-circle" preserve-scroll :href="route('profile.pds.educational_background.college_graduate_study.edit', { college_graduate_study: college.id })" title="Edit">
                              <i class="fa-solid fa-pen-to-square"></i>
                            </Link>
                            <Link as="button" class="btn btn-light btn-sm text-danger rounded-circle" method="delete" preserve-scroll :onBefore="confirm" :href="route('profile.pds.educational_background.college_graduate_study.destroy', { college_graduate_study: college.id })" title="Delete">
                              <i class="fa-solid fa-trash"></i>
                            </Link>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Secondary -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
              <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                <h6 class="mb-0 text-dark fw-bold text-uppercase"><i class="fa-solid fa-school-flag text-primary me-2"></i>Secondary</h6>
                <Link class="btn btn-primary btn-sm rounded-pill px-3 fw-medium" :href="route('profile.pds.educational_background.college_graduate_study.create')" :data="{type: 'SECONDARY'}">
                  <i class="fa-solid fa-plus me-1"></i> Add Record
                </Link>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0 text-sm">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem;">
                      <tr>
                        <th class="ps-4">Name of School</th>
                        <th>Degree/Course</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Units Earned</th>
                        <th>Year Graduated</th>
                        <th>Scholarship/Honors</th>
                        <th class="pe-4 text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-if="secondary.length === 0">
                        <td colspan="8" class="text-center py-4 text-muted fst-italic">No secondary education records added.</td>
                      </tr>
                      <tr v-for="college in secondary" :key="college.id">
                        <td class="ps-4 fw-medium text-dark">{{ college.name_of_school }}</td>
                        <td>{{ college.basic_ed_degree_course || '-' }}</td>
                        <td>{{ college.period_from }}</td>
                        <td>{{ college.period_to }}</td>
                        <td>{{ college.highest_lvl_units_earned || '-' }}</td>
                        <td>{{ college.year_graduated }}</td>
                        <td>
                          <ul class="mb-0 ps-3" v-if="college.academic_award && college.academic_award.length">
                            <li v-for="award in college.academic_award" :key="award.id">
                              <span class="badge bg-info bg-opacity-25 text-dark border border-info rounded-pill px-2">{{ award.title }}</span>
                            </li>
                          </ul>
                          <span v-else class="text-muted">-</span>
                        </td>
                        <td class="pe-4 text-center">
                          <div class="d-flex gap-2 justify-content-center">
                            <Link class="btn btn-light btn-sm text-primary rounded-circle" preserve-scroll :href="route('profile.pds.educational_background.college_graduate_study.edit', { college_graduate_study: college.id })" title="Edit">
                              <i class="fa-solid fa-pen-to-square"></i>
                            </Link>
                            <Link as="button" class="btn btn-light btn-sm text-danger rounded-circle" method="delete" preserve-scroll :onBefore="confirm" :href="route('profile.pds.educational_background.college_graduate_study.destroy', { college_graduate_study: college.id })" title="Delete">
                              <i class="fa-solid fa-trash"></i>
                            </Link>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Vocational -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
              <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                <h6 class="mb-0 text-dark fw-bold text-uppercase"><i class="fa-solid fa-screwdriver-wrench text-primary me-2"></i>Vocational / Senior High School</h6>
                <Link class="btn btn-primary btn-sm rounded-pill px-3 fw-medium" :href="route('profile.pds.educational_background.college_graduate_study.create')" :data="{type: 'VOCATIONAL'}">
                  <i class="fa-solid fa-plus me-1"></i> Add Record
                </Link>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0 text-sm">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem;">
                      <tr>
                        <th class="ps-4">Name of School</th>
                        <th>Degree/Course</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Units Earned</th>
                        <th>Year Graduated</th>
                        <th>Scholarship/Honors</th>
                        <th class="pe-4 text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-if="vocational.length === 0">
                        <td colspan="8" class="text-center py-4 text-muted fst-italic">No vocational records added.</td>
                      </tr>
                      <tr v-for="college in vocational" :key="college.id">
                        <td class="ps-4 fw-medium text-dark">{{ college.name_of_school }}</td>
                        <td>{{ college.basic_ed_degree_course || '-' }}</td>
                        <td>{{ college.period_from }}</td>
                        <td>{{ college.period_to }}</td>
                        <td>{{ college.highest_lvl_units_earned || '-' }}</td>
                        <td>{{ college.year_graduated }}</td>
                        <td>
                          <ul class="mb-0 ps-3" v-if="college.academic_award && college.academic_award.length">
                            <li v-for="award in college.academic_award" :key="award.id">
                              <span class="badge bg-info bg-opacity-25 text-dark border border-info rounded-pill px-2">{{ award.title }}</span>
                            </li>
                          </ul>
                          <span v-else class="text-muted">-</span>
                        </td>
                        <td class="pe-4 text-center">
                          <div class="d-flex gap-2 justify-content-center">
                            <Link class="btn btn-light btn-sm text-primary rounded-circle" preserve-scroll :href="route('profile.pds.educational_background.college_graduate_study.edit', { college_graduate_study: college.id })" title="Edit">
                              <i class="fa-solid fa-pen-to-square"></i>
                            </Link>
                            <Link as="button" class="btn btn-light btn-sm text-danger rounded-circle" method="delete" preserve-scroll :onBefore="confirm" :href="route('profile.pds.educational_background.college_graduate_study.destroy', { college_graduate_study: college.id })" title="Delete">
                              <i class="fa-solid fa-trash"></i>
                            </Link>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- College -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
              <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                <h6 class="mb-0 text-dark fw-bold text-uppercase"><i class="fa-solid fa-building-columns text-primary me-2"></i>College</h6>
                <Link class="btn btn-primary btn-sm rounded-pill px-3 fw-medium" :href="route('profile.pds.educational_background.college_graduate_study.create')" :data="{type: 'COLLEGE'}">
                  <i class="fa-solid fa-plus me-1"></i> Add Record
                </Link>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0 text-sm">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem;">
                      <tr>
                        <th class="ps-4">Name of School</th>
                        <th>Degree/Course</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Units Earned</th>
                        <th>Year Graduated</th>
                        <th>Scholarship/Honors</th>
                        <th>Files</th>
                        <th class="pe-4 text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-if="colleges.length === 0">
                        <td colspan="9" class="text-center py-4 text-muted fst-italic">No college records added.</td>
                      </tr>
                      <tr v-for="college in colleges" :key="college.id">
                        <td class="ps-4 fw-medium text-dark">{{ college.name_of_school }}</td>
                        <td>{{ college.basic_ed_degree_course || '-' }}</td>
                        <td>{{ college.period_from }}</td>
                        <td>{{ college.period_to }}</td>
                        <td>{{ college.highest_lvl_units_earned || '-' }}</td>
                        <td>{{ college.year_graduated }}</td>
                        <td>
                          <ul class="mb-0 ps-3" v-if="college.academic_award && college.academic_award.length">
                            <li v-for="award in college.academic_award" :key="award.id">
                              <span class="badge bg-info bg-opacity-25 text-dark border border-info rounded-pill px-2">{{ award.title }}</span>
                            </li>
                          </ul>
                          <span v-else class="text-muted">-</span>
                        </td>
                        <td>
                          <div class="d-flex flex-column gap-1" v-if="college.files && college.files.length">
                            <a v-for="file in college.files" :key="file.id" target="_blank" :href="file.src" class="text-decoration-none text-truncate" style="max-width: 150px;">
                              <i class="fa-solid fa-file-pdf text-danger me-1"></i><small>{{ file.filename }}</small>
                            </a>
                          </div>
                          <span v-else class="text-muted">-</span>
                        </td>
                        <td class="pe-4 text-center">
                          <div class="d-flex gap-2 justify-content-center">
                            <Link class="btn btn-light btn-sm text-primary rounded-circle" preserve-scroll :href="route('profile.pds.educational_background.college_graduate_study.edit', { college_graduate_study: college.id })" title="Edit">
                              <i class="fa-solid fa-pen-to-square"></i>
                            </Link>
                            <Link as="button" class="btn btn-light btn-sm text-danger rounded-circle" method="delete" preserve-scroll :onBefore="confirm" :href="route('profile.pds.educational_background.college_graduate_study.destroy', { college_graduate_study: college.id })" title="Delete">
                              <i class="fa-solid fa-trash"></i>
                            </Link>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Graduate Studies -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
              <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                <h6 class="mb-0 text-dark fw-bold text-uppercase"><i class="fa-solid fa-user-graduate text-primary me-2"></i>Graduate Studies</h6>
                <Link class="btn btn-primary btn-sm rounded-pill px-3 fw-medium" :href="route('profile.pds.educational_background.college_graduate_study.create')" :data="{type: 'GRADUATE'}">
                  <i class="fa-solid fa-plus me-1"></i> Add Record
                </Link>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0 text-sm">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.75rem;">
                      <tr>
                        <th class="ps-4">Name of School</th>
                        <th>Degree/Course</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Units Earned</th>
                        <th>Year Graduated</th>
                        <th>Scholarship/Honors</th>
                        <th>Files</th>
                        <th class="pe-4 text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-if="graduate_studies.length === 0">
                        <td colspan="9" class="text-center py-4 text-muted fst-italic">No graduate studies records added.</td>
                      </tr>
                      <tr v-for="college in graduate_studies" :key="college.id">
                        <td class="ps-4 fw-medium text-dark">{{ college.name_of_school }}</td>
                        <td>{{ college.basic_ed_degree_course || '-' }}</td>
                        <td>{{ college.period_from }}</td>
                        <td>{{ college.period_to }}</td>
                        <td>{{ college.highest_lvl_units_earned || '-' }}</td>
                        <td>{{ college.year_graduated }}</td>
                        <td>
                          <ul class="mb-0 ps-3" v-if="college.academic_award && college.academic_award.length">
                            <li v-for="award in college.academic_award" :key="award.id">
                              <span class="badge bg-info bg-opacity-25 text-dark border border-info rounded-pill px-2">{{ award.title }}</span>
                            </li>
                          </ul>
                          <span v-else class="text-muted">-</span>
                        </td>
                        <td>
                          <div class="d-flex flex-column gap-1" v-if="college.files && college.files.length">
                            <a v-for="file in college.files" :key="file.id" target="_blank" :href="file.src" class="text-decoration-none text-truncate" style="max-width: 150px;">
                              <i class="fa-solid fa-file-pdf text-danger me-1"></i><small>{{ file.filename }}</small>
                            </a>
                          </div>
                          <span v-else class="text-muted">-</span>
                        </td>
                        <td class="pe-4 text-center">
                          <div class="d-flex gap-2 justify-content-center">
                            <Link class="btn btn-light btn-sm text-primary rounded-circle" preserve-scroll :href="route('profile.pds.educational_background.college_graduate_study.edit', { college_graduate_study: college.id })" title="Edit">
                              <i class="fa-solid fa-pen-to-square"></i>
                            </Link>
                            <Link as="button" class="btn btn-light btn-sm text-danger rounded-circle" method="delete" preserve-scroll :onBefore="confirm" :href="route('profile.pds.educational_background.college_graduate_study.destroy', { college_graduate_study: college.id })" title="Delete">
                              <i class="fa-solid fa-trash"></i>
                            </Link>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          
          <div class="d-flex justify-content-end mt-2 mb-4">
            <div class="d-flex gap-2">
              <Link :href="route('profile.pds.family_background.edit')" type="button" :disabled="form.isDirty" class="btn btn-outline-dark rounded-pill px-4">
                <i class="fa-solid fa-arrow-left me-2" /> Back
              </Link>
              <Link :href="route('profile.pds.civil_service_eligibility.index')" type="button" :disabled="form.isDirty" class="btn btn-dark rounded-pill px-4">
                Next <i class="fa-solid fa-arrow-right ms-2" />
              </Link>
            </div>
          </div>
        </div>
      </form>
    </PDSLayout>
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
  _method: 'put',
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



const elementary = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'ELEMENTARY')
})

const secondary = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'SECONDARY')
})

const vocational = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'VOCATIONAL')
})

const colleges = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'COLLEGE')
})
const graduate_studies = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'GRADUATE')
})

const confirm = () => window.confirm('Are you sure to delete this?')

</script>