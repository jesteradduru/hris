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
          </div>

          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">NAME OF SCHOOL</label>
              <input v-model="form.college_name_of_school" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.college_name_of_school" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">BASIC EDUCATION/DEGREE/COURSE</label>
              <input v-model="form.college_basic_ed_degree_course" type="text" class="form-control form-control-sm" />
              <p class="form-text text-muted">
                Write in full
              </p>
              <InputError :message="form.errors.college_basic_ed_degree_course" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">From</label>
              <input v-model="form.college_period_from" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.college_period_from" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">To</label>
              <input v-model="form.college_period_to" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.college_period_to" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">HIGHEST LEVEL/UNITS EARNED (if not graduated)</label>
              <input v-model="form.college_highest_lvl_units_earned" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.college_highest_lvl_units_earned" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">YEAR GRADUATED</label>
              <input v-model="form.college_year_graduated" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.college_year_graduated" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</label>
              <input v-model="form.college_scholarship_academic_honors" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.college_scholarship_academic_honors" />
            </div>
          </div>
          <!-- Graduate Studies -->
          <div class="col-12">
            <h5>Graduate Studies</h5>
          </div>

          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">NAME OF SCHOOL</label>
              <input v-model="form.graduate_name_of_school" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.graduate_name_of_school" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">BASIC EDUCATION/DEGREE/COURSE</label>
              <input v-model="form.graduate_basic_ed_degree_course" type="text" class="form-control form-control-sm" />
              <p class="form-text text-muted">
                Write in full
              </p>
              <InputError :message="form.errors.graduate_basic_ed_degree_course" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">From</label>
              <input v-model="form.graduate_period_from" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.graduate_period_from" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">To</label>
              <input v-model="form.graduate_period_to" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.graduate_period_to" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">HIGHEST LEVEL/UNITS EARNED (if not graduated)</label>
              <input v-model="form.graduate_highest_lvl_units_earned" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.graduate_highest_lvl_units_earned" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">YEAR GRADUATED</label>
              <input v-model="form.graduate_year_graduated" type="number" class="form-control form-control-sm" />
              <InputError :message="form.errors.graduate_year_graduated" />
            </div>
          </div>


          <div class="col-12 col-md-6">
            <div class="mb-3">
              <label class="form-label">SCHOLARSHIP/ACADEMIC HONORS RECEIVED</label>
              <input v-model="form.graduate_scholarship_academic_honors" type="text" class="form-control form-control-sm" />
              <InputError :message="form.errors.graduate_scholarship_academic_honors" />
            </div>
          </div>
        </div>


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

const props = defineProps({
  educational_background: Object,
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
    college_name_of_school: null,
    college_basic_ed_degree_course: null,
    college_period_from: null,
    college_period_to: null,
    college_highest_lvl_units_earned: null,
    college_year_graduated: null,
    college_scholarship_academic_honors: null,
    graduate_name_of_school: null,
    graduate_basic_ed_degree_course: null,
    graduate_period_from: null,
    graduate_period_to: null,
    graduate_highest_lvl_units_earned: null,
    graduate_year_graduated: null,
    graduate_scholarship_academic_honors: null,
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
    college_name_of_school: props.educational_background.college_name_of_school,
    college_basic_ed_degree_course: props.educational_background.college_basic_ed_degree_course,
    college_period_from: props.educational_background.college_period_from,
    college_period_to: props.educational_background.college_period_to,
    college_highest_lvl_units_earned: props.educational_background.college_highest_lvl_units_earned,
    college_year_graduated: props.educational_background.college_year_graduated,
    college_scholarship_academic_honors: props.educational_background.college_scholarship_academic_honors,
    graduate_name_of_school: props.educational_background.graduate_name_of_school,
    graduate_basic_ed_degree_course: props.educational_background.graduate_basic_ed_degree_course,
    graduate_period_from: props.educational_background.graduate_period_from,
    graduate_period_to: props.educational_background.graduate_period_to,
    graduate_highest_lvl_units_earned: props.educational_background.graduate_highest_lvl_units_earned,
    graduate_year_graduated: props.educational_background.graduate_year_graduated,
    graduate_scholarship_academic_honors: props.educational_background.graduate_scholarship_academic_honors,
  })
}

const createUpdateEducationalBackground =  () => {
  form.post(route('profile.pds.educational_background.store_or_update'), {
    preserveScroll: true,
  })
}
</script>