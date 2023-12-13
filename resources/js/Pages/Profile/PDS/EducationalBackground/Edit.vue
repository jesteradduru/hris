<template>
  <AuthenticatedLayout>
    <PDSLayout :is-form-dirty="form.isDirty">
      <form @submit.prevent="createUpdateEducationalBackground">
        <div class="row">
          <!-- elem -->
          <div class="col-12">
            <h5>Elementary</h5>
            <div>
              <Link class="btn btn-secondary  mb-3" :href="route('profile.pds.educational_background.college_graduate_study.create')" :data="{type: 'ELEMENTARY'}">Add</Link>
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th scope="col">NAME OF SCHOOL</th>
                      <th scope="col">DEGREE/COURSE</th>
                      <th scope="col">FROM</th>
                      <th scope="col">TO</th>
                      <th scope="col">UNITS EARNED</th>
                      <th scope="col">YEAR GRADUATED </th>
                      <th scope="col">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</th>
                      <th scope="col">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="college in elementary" :key="college.id" class="">
                      <td scope="row">{{ college.name_of_school }}</td>
                      <td>{{ college.basic_ed_degree_course }}</td>
                      <td>{{ college.period_from }}</td>
                      <td>{{ college.period_to }}</td>
                      <td>{{ college.highest_lvl_units_earned }}</td>
                      <td>{{ college.year_graduated }}</td>
                      <td>
                        <ul>
                          <li v-for="award in college.academic_award" :key="award.id">
                            <span>{{ award.title }}</span>
                          </li>
                        </ul>
                      </td>
                      <td>
                        <div class="d-flex gap-2">
                          <Link
                            class="btn btn-secondary btn-sm"
                            preserve-scroll
                            :href="route('profile.pds.educational_background.college_graduate_study.edit', {
                              college_graduate_study: college.id
                            })"
                          >
                            Edit
                          </Link>
                          <Link
                            as="button" class="btn btn-danger btn-sm" method="delete"
                            preserve-scroll
                            :onBefore="confirm"
                            :href="route('profile.pds.educational_background.college_graduate_study.destroy', {
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
          <!-- end of elem -->


          <!-- secondary -->
          <div class="col-12">
            <h5>Secondary</h5>
            <div>
              <Link class="btn btn-secondary  mb-3" :href="route('profile.pds.educational_background.college_graduate_study.create')" :data="{type: 'SECONDARY'}">Add</Link>
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th scope="col">NAME OF SCHOOL</th>
                      <th scope="col">DEGREE/COURSE</th>
                      <th scope="col">FROM</th>
                      <th scope="col">TO</th>
                      <th scope="col">UNITS EARNED</th>
                      <th scope="col">YEAR GRADUATED </th>
                      <th scope="col">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</th>
                      <th scope="col">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="college in secondary" :key="college.id" class="">
                      <td scope="row">{{ college.name_of_school }}</td>
                      <td>{{ college.basic_ed_degree_course }}</td>
                      <td>{{ college.period_from }}</td>
                      <td>{{ college.period_to }}</td>
                      <td>{{ college.highest_lvl_units_earned }}</td>
                      <td>{{ college.year_graduated }}</td>
                      <td>
                        <ul>
                          <li v-for="award in college.academic_award" :key="award.id">
                            <span>{{ award.title }}</span>
                          </li>
                        </ul>
                      </td>
                      <td>
                        <div class="d-flex gap-2">
                          <Link
                            class="btn btn-secondary btn-sm"
                            preserve-scroll
                            :href="route('profile.pds.educational_background.college_graduate_study.edit', {
                              college_graduate_study: college.id
                            })"
                          >
                            Edit
                          </Link>
                          <Link
                            as="button" class="btn btn-danger btn-sm" method="delete"
                            preserve-scroll
                            :onBefore="confirm"
                            :href="route('profile.pds.educational_background.college_graduate_study.destroy', {
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
          <!-- end of secondary -->


          <!-- vocational -->

          <div class="col-12">
            <h5>Vocational</h5>
            <div>
              <Link class="btn btn-secondary  mb-3" :href="route('profile.pds.educational_background.college_graduate_study.create')" :data="{type: 'VOCATIONAL'}">Add</Link>
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th scope="col">NAME OF SCHOOL</th>
                      <th scope="col">DEGREE/COURSE</th>
                      <th scope="col">FROM</th>
                      <th scope="col">TO</th>
                      <th scope="col">UNITS EARNED</th>
                      <th scope="col">YEAR GRADUATED </th>
                      <th scope="col">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</th>
                      <th scope="col">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="college in vocational" :key="college.id" class="">
                      <td scope="row">{{ college.name_of_school }}</td>
                      <td>{{ college.basic_ed_degree_course }}</td>
                      <td>{{ college.period_from }}</td>
                      <td>{{ college.period_to }}</td>
                      <td>{{ college.highest_lvl_units_earned }}</td>
                      <td>{{ college.year_graduated }}</td>
                      <td>
                        <ul>
                          <li v-for="award in college.academic_award" :key="award.id">
                            <span>{{ award.title }}</span>
                          </li>
                        </ul>
                      </td>
                      <td>
                        <div class="d-flex gap-2">
                          <Link
                            class="btn btn-secondary btn-sm"
                            preserve-scroll
                            :href="route('profile.pds.educational_background.college_graduate_study.edit', {
                              college_graduate_study: college.id
                            })"
                          >
                            Edit
                          </Link>
                          <Link
                            as="button" class="btn btn-danger btn-sm" method="delete"
                            preserve-scroll
                            :onBefore="confirm"
                            :href="route('profile.pds.educational_background.college_graduate_study.destroy', {
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


          <!-- College -->
          <div class="col-12">
            <h5>College</h5>
            <div>
              <Link class="btn btn-secondary  mb-3" :href="route('profile.pds.educational_background.college_graduate_study.create')" :data="{type: 'COLLEGE'}">Add</Link>
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th scope="col">NAME OF SCHOOL</th>
                      <th scope="col">DEGREE/COURSE</th>
                      <th scope="col">FROM</th>
                      <th scope="col">TO</th>
                      <th scope="col">UNITS EARNED</th>
                      <th scope="col">YEAR GRADUATED </th>
                      <th scope="col">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</th>
                      <th scope="col">FILES</th>
                      <th scope="col">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="college in colleges" :key="college.id" class="">
                      <td scope="row">{{ college.name_of_school }}</td>
                      <td>{{ college.basic_ed_degree_course }}</td>
                      <td>{{ college.period_from }}</td>
                      <td>{{ college.period_to }}</td>
                      <td>{{ college.highest_lvl_units_earned }}</td>
                      <td>{{ college.year_graduated }}</td>
                      <td>
                        <ul>
                          <li v-for="award in college.academic_award" :key="award.id">
                            <span>{{ award.title }}</span>
                          </li>
                        </ul>
                      </td>
                      <td>
                        <ul>
                          <li v-for="file in college.files" :key="file.id">
                            <a target="_blank" :href="file.src">{{ file.filename }}</a>
                          </li>
                        </ul>
                      </td>
                      <td>
                        <div class="d-flex gap-2">
                          <Link
                            class="btn btn-secondary btn-sm"
                            preserve-scroll
                            :href="route('profile.pds.educational_background.college_graduate_study.edit', {
                              college_graduate_study: college.id
                            })"
                          >
                            Edit
                          </Link>
                          <Link
                            as="button" class="btn btn-danger btn-sm" method="delete"
                            preserve-scroll
                            :onBefore="confirm"
                            :href="route('profile.pds.educational_background.college_graduate_study.destroy', {
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
              <Link class="btn btn-secondary  mb-3" :href="route('profile.pds.educational_background.college_graduate_study.create')" :data="{type: 'GRADUATE'}">Add</Link>
              
              <div class="table-responsive">
                <table class="table table-bordered table-sm">
                  <thead>
                    <tr>
                      <th scope="col">NAME OF SCHOOL</th>
                      <th scope="col">DEGREE/COURSE</th>
                      <th scope="col">FROM</th>
                      <th scope="col">TO</th>
                      <th scope="col">UNITS EARNED</th>
                      <th scope="col">YEAR GRADUATED </th>
                      <th scope="col">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</th>
                      <th scope="col">FILES</th>
                      <th scope="col">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="college in graduate_studies" :key="college.id" class="">
                      <td scope="row">{{ college.name_of_school }}</td>
                      <td>{{ college.basic_ed_degree_course }}</td>
                      <td>{{ college.period_from }}</td>
                      <td>{{ college.period_to }}</td>
                      <td>{{ college.highest_lvl_units_earned }}</td>
                      <td>{{ college.year_graduated }}</td>
                      <td>
                        <ul>
                          <li v-for="award in college.academic_award" :key="award.id">
                            <span>{{ award.title }}</span>
                          </li>
                        </ul>
                      </td>
                      <td>
                        <ul>
                          <li v-for="file in college.files" :key="file.id">
                            <a target="_blank" :href="file.src">{{ file.filename }}</a>
                          </li>
                        </ul>
                      </td>
                      <td>
                        <div class="d-flex gap-2">
                          <Link
                            class="btn btn-secondary btn-sm"
                            preserve-scroll
                            :href="route('profile.pds.educational_background.college_graduate_study.edit', {
                              college_graduate_study: college.id
                            })"
                          >
                            Edit
                          </Link>
                          <Link
                            as="button" class="btn btn-danger btn-sm" method="delete"
                            preserve-scroll
                            :onBefore="confirm"
                            :href="route('profile.pds.educational_background.college_graduate_study.destroy', {
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
            <!-- END OF TABLE -->
            </div>
          </div>
          <!-- end of GRADUATE STUDIES -->
          <div class="d-flex justify-content-end">
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