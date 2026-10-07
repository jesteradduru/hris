<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
              <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                <i class="fa-solid fa-pen-to-square text-primary"></i>
              </div>
              <h5 class="mb-0 fw-bold text-dark">Edit Special Skills and Memberships</h5>
            </div>
            <div class="card-body p-4">
              <form @submit.prevent="save">
                <div class="row g-4">
                  <div class="col-12">
                    <label class="form-label fw-bold text-secondary small text-uppercase">Special Skills and Hobbies</label>
                    <ListBadge v-if="skills && skills.length" :lists="skills" class="mb-3 d-flex flex-wrap gap-1" />
                    <textarea
                      v-model="form.special_skills_hobbies" class="form-control" rows="3"
                      placeholder="e.g. Graphic Design, Swimming, Coding"
                    ></textarea>
                    <div class="form-text text-muted small mt-2">
                      <i class="fa-solid fa-circle-info me-1"></i>Separate each item with a comma (,)
                    </div>
                    <InputError :message="form.errors.special_skills_hobbies" class="mt-1" /> 
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-bold text-secondary small text-uppercase">Membership in Association/Organization</label>
                    <ListBadge v-if="membership_in_assoc_org && membership_in_assoc_org.length" :lists="membership_in_assoc_org" class="mb-3 d-flex flex-wrap gap-1" />
                    <textarea
                      v-model="form.membership_in_assoc_org" class="form-control" rows="3"
                      placeholder="e.g. Red Cross, Philippine Institute of Civil Engineers"
                    ></textarea>
                    <div class="form-text text-muted small mt-2">
                      <i class="fa-solid fa-circle-info me-1"></i>Separate each item with a comma (,)
                    </div>
                    <InputError :message="form.errors.membership_in_assoc_org" class="mt-1" />
                  </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                  <span v-if="form.isDirty" class="text-warning small fw-medium"><i class="fa-solid fa-triangle-exclamation me-1"></i>Unsaved changes</span>
                  <span v-else></span>
                  
                  <div class="d-flex gap-2">
                    <Link :href="route('profile.pds.other_information.index')" class="btn btn-light rounded-pill px-4 fw-medium text-secondary" :disabled="form.processing">Cancel</Link>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm" :disabled="form.processing">
                      <Spinner :processing="form.processing" class="me-2" v-if="form.processing" /> 
                      <i class="fa-solid fa-save me-2" v-else></i>Save Changes
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </PDSLayout>
  </AuthenticatedLayout>
</template>

<script setup>
import Spinner from '@/Components/Spinner.vue'
import { useForm, Link } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import ListBadge from '@/Components/ListBadge.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import { computed } from 'vue'

const props = defineProps({
  other_information: Object,
})

let form = null

if(props.other_information){
  form = useForm({
    special_skills_hobbies: props.other_information.special_skills_hobbies,
    none_academic_distinctions: props.other_information.none_academic_distinctions,
    membership_in_assoc_org: props.other_information.membership_in_assoc_org,
  })
}else{
  form = useForm({
    special_skills_hobbies: null,
    none_academic_distinctions: null,
    membership_in_assoc_org: null,
  })
}

const save = () => {
  form.post(route('profile.pds.other_information.store_or_update'), {
    preserveScroll: true,
  })
}

const skills = computed(() => {
  return form.special_skills_hobbies ? form.special_skills_hobbies.split(',') : []
})

// const none_academic_distinctions = computed(() => {
//   return form.none_academic_distinctions ? form.none_academic_distinctions.split(',') : []
// })

const membership_in_assoc_org = computed(() => {
  return form.membership_in_assoc_org ? form.membership_in_assoc_org.split(',') : []
})

</script>