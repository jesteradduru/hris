<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <form @submit.prevent="save">
        <div class="row">
          <div class="form-group col-12">
            <div class="mb-3">
              <label for="" class="form-label">SPECIAL SKILLS and HOBBIES</label>
              <ListBadge v-if="skills" :lists="skills" class="mb-3" />
              <textarea
                id=""
                v-model="form.special_skills_hobbies" type="text" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <InputError :message="form.errors.special_skills_hobbies" /> 
              <p class="form-text text-muted">
                Separate each item with comma(,)
              </p>
            </div>
          </div>


          <!-- <div class="form-group col-12">
            <div class="mb-3">
              <label for="" class="form-label">NON-ACADEMIC DISTINCTIONS / RECOGNITION</label>
              <ListBadge v-if="none_academic_distinctions" :lists="none_academic_distinctions" class="mb-3" />
              <textarea
                id=""
                v-model="form.none_academic_distinctions" type="date" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <p class="form-text text-muted">
                Separate each item with comma(,)
              </p>
              <InputError :message="form.errors.none_academic_distinctions" />
            </div>
          </div> -->


          <div class="form-group col-12">
            <div class="mb-3">
              <label for="" class="form-label">MEMBERSHIP IN ASSOCIATION/ORGANIZATION </label>
              <ListBadge v-if="membership_in_assoc_org" :lists="membership_in_assoc_org" class="mb-3" />
              <textarea
                id=""
                v-model="form.membership_in_assoc_org" type="date" class="form-control form-control-sm" name=""
                placeholder=""
              />
              <p class="form-text text-muted">
                Separate each item with comma(,)
              </p>
              <InputError :message="form.errors.membership_in_assoc_org" />
            </div>
          </div>



          <div class="col-12">
            <div class="d-flex gap-2">
              <div class="d-flex align-items-center">
                <b v-if="form.isDirty" class="text-danger form-status">Not Saved</b>
              </div>
              <Link :href="route('profile.pds.other_information.index')" class="btn btn-secondary" :disabled="form.processing" type="submit">  Back</Link>
              <button
                type="submit" :disabled="!form.isDirty && form.wasSuccessful"
                class="btn btn-success"
              >
                <Spinner :processing="form.processing" /> {{ !form.isDirty &&
                  form.wasSuccessful ? 'Updated' : 'Update' }}
              </button>
            </div>
          </div>
        </div>
      </form>
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