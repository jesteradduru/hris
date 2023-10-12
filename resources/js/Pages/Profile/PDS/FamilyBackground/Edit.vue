<template>
  <ProfileLayout>
    <PDSLayout :is-form-dirty="form.isDirty">
      <form class="row" @submit.prevent="create_update_family_background">
        <!-- SPOUSE -->

        <div class="col-12">
          <h5>Spouse</h5>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Surname</label>
            <input v-model="form.spouse_surname" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.spouse_surname" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">First Name</label>
            <input v-model="form.spouse_first_name" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.spouse_first_name" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Middle Name</label>
            <input v-model="form.spouse_middle_name" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.spouse_middle_name" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Name Extension (JR.,SR.)</label>
            <input v-model="form.spouse_name_extension" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.spouse_name_extension" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Occupation</label>
            <input v-model="form.spouse_occupation" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.spouse_occupation" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Employer/Business Name</label>
            <input
              v-model="form.spouse_employer_business_name" type="text"
              class="form-control form-control-sm"
            />
            <InputError :message="form.errors.spouse_employer_business_name" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Business Address</label>
            <input v-model="form.spouse_business_address" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.spouse_business_address" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Telephone No.</label>
            <input v-model="form.spouse_telephone_number" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.spouse_telephone_number" />
          </div>
        </div>

        <!-- FATHER -->

        <div class="col-12">
          <h5>Father</h5>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Surname</label>
            <input v-model="form.fathers_surname" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.fathers_surname" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">First Name</label>
            <input v-model="form.fathers_first_name" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.fathers_first_name" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Middle Name</label>
            <input v-model="form.fathers_middle_name" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.fathers_middle_name" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Name Extension (JR.,SR.)</label>
            <input v-model="form.fathers_name_extension" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.fathers_name_extension" />
          </div>
        </div>

        <!-- MMOTHER -->

        <div class="col-12">
          <h5>Mother</h5>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Surname</label>
            <input v-model="form.mothers_surname" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.mothers_surname" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">First Name</label>
            <input v-model="form.mothers_first_name" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.mothers_first_name" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Middle Name</label>
            <input v-model="form.mothers_middle_name" type="text" class="form-control form-control-sm" />
            <InputError :message="form.errors.mothers_middle_name" />
          </div>
        </div>

        <div class="col-12">
          <h5>Name of Children</h5>
          <div class="container border py-2 rounded">
            <button type="button" class="btn btn-success  mb-3" data-bs-toggle="modal" data-bs-target="#addChildren">
              Add Child
            </button>
            <table class="table table-bordered table-sm" style="text-transform: uppercase;">
              <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Date of Birth</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="child in children" :key="child.id">
                  <td>{{ child.fullname }}</td>
                  <td>{{ child.date_of_birth }}</td>
                  <td>
                    <Link
                      :only="['children']" as="button" class="btn btn-danger " method="delete"
                      :href="route('profile.pds.children.delete', { children: child.id })"
                      preserve-scroll
                    >
                      Delete
                    </Link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="col-12 mt-3">
          <div class="d-flex justify-content-between">
            <div class="d-flex gap-2 align-items-center">
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
              <b v-if="form.isDirty" class="text-danger form-status">Not Saved</b>
            </div>
            <div class="d-flex gap-2">
              <Link
                :href="route('profile.pds.personal_information.edit')" type="button" :disabled="form.isDirty"
                class="btn btn-dark"
              >
                <i class="fa-solid fa-arrow-left" />
              </Link>
              <Link
                :href="route('profile.pds.educational_background.edit')" type="button" :disabled="form.isDirty"
                class="btn btn-dark"
              >
                <i class="fa-solid fa-arrow-right" />
              </Link>
            </div>
          </div>
        </div>
      </form>
    </PDSLayout>
  </ProfileLayout>
  <Modal id="addChildren">
    <template #header>
      <h5>Add child</h5>
    </template>
    <template #body>
      <div class="row">
        <div class="col-12">
          <div v-if="childrenForm.recentlySuccessful" class="alert alert-success">Saved</div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input v-model="childrenForm.fullname" type="text" class="form-control form-control-sm" />
            <InputError :message="childrenForm.errors.fullname" />
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label">Date of birth</label>
            <input v-model="childrenForm.date_of_birth" type="date" class="form-control form-control-sm" />
            <InputError :message="childrenForm.errors.date_of_birth" />
          </div>
        </div>
        <div class="col-12">
          <button class="btn btn-success d-block ms-auto" @click="addChild">Add</button>
        </div>
      </div>
    </template>
  </Modal>
</template>

<script setup>
import Spinner from '@/Components/Spinner.vue'
import { useForm, Link } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import ProfileLayout from '@/Pages/Profile/Layout/ProfileLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import Modal from '@/Components/Modal.vue'

const props = defineProps({
  children: Array,
  family_background: Object,
})

let form = null

if (props.family_background) {
  form = useForm({
    spouse_surname: props.family_background.spouse_surname,
    spouse_first_name: props.family_background.spouse_first_name,
    spouse_name_extension: props.family_background.spouse_name_extension,
    spouse_middle_name: props.family_background.spouse_middle_name,
    spouse_occupation: props.family_background.spouse_occupation,
    spouse_employer_business_name: props.family_background.spouse_employer_business_name,
    spouse_business_address: props.family_background.spouse_business_address,
    spouse_telephone_number: props.family_background.spouse_telephone_number,
    fathers_surname: props.family_background.fathers_surname,
    fathers_first_name: props.family_background.fathers_first_name,
    fathers_name_extension: props.family_background.fathers_name_extension,
    fathers_middle_name: props.family_background.fathers_middle_name,
    mothers_surname: props.family_background.mothers_surname,
    mothers_first_name: props.family_background.mothers_first_name,
    mothers_middle_name: props.family_background.mothers_middle_name,
  })
} else {
  form = useForm({
    spouse_surname: null,
    spouse_first_name: null,
    spouse_name_extension: null,
    spouse_middle_name: null,
    spouse_occupation: null,
    spouse_employer_business_name: null,
    spouse_business_address: null,
    spouse_telephone_number: null,
    fathers_surname: null,
    fathers_first_name: null,
    fathers_name_extension: null,
    fathers_middle_name: null,
    mothers_surname: null,
    mothers_first_name: null,
    mothers_middle_name: null,
  })
}

const create_update_family_background = () => {
  form.post(route('profile.pds.family_background.store_or_update'), {
    preserveScroll: true,
  })
}


const childrenForm = useForm({
  fullname: null,
  date_of_birth: null,
})

const addChild = () => childrenForm.post(route('profile.pds.family_background.store_child'), {
  preserveScroll: true,
  onSuccess: () => childrenForm.reset(),
})


</script>