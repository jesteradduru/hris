<script setup>
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import { computed } from 'vue'

const form = useForm({
  surname: '',
  first_name: '',
  name_extension: '',
  middle_name: '',
  username: '',
  password: '',
  dtr_user_id: '',
  password_confirmation: '',
  role: 'employee',
  plantilla_id: '',
})

const props = defineProps({
  roles: Array,
  positions: Array,
})

const submit = () => {
  form.post(route('admin.employees.employee.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
    onSuccess: () => {
      form.reset()
    },
  })
}

const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Employees',
    link: route('admin.employees.index'),
  },
  {
    label: 'Create Account',
  },
])
    
</script>

<template>
  <AdminLayout>
    <Head title="Register" />
    <BreadCrumbs :crumbs="crumbs" />
    <div class="container">
      <div class="card shadow">
        <div class="card-body">
          <form class="row" @submit.prevent="submit">
            <div class="col-6 mb-2">
              <InputLabel for="surname" value="Surname" />

              <TextInput
                id="surname"
                v-model="form.surname"
                type="text"
                class="mt-1 block w-full"
                autofocus
                autocomplete="surname"
              />

              <InputError
                class="mt-2"
                :message="form.errors.surname"
              />
            </div>
            
            <div class="col-6 mb-2">
              <InputLabel for="first_name" value="First Name" />

              <TextInput
                id="first_name"
                v-model="form.first_name"
                type="text"
                class="mt-1 block w-full"
                
               
                autocomplete="first_name"
              />

              <InputError
                class="mt-2"
                :message="form.errors.first_name"
              />
            </div>

            <div class="col-6 mb-2">
              <InputLabel for="middle_name" value="Middle Name" />

              <TextInput
                id="middle_name"
                v-model="form.middle_name"
                type="text"
                class="mt-1 block w-full"
                
                
                autocomplete="middle_name"
              />

              <InputError
                class="mt-2"
                :message="form.errors.middle_name"
              />
            </div>

            <div class="col-6 mb-2">
              <InputLabel for="name_extension" value="Name Extension" />

              <TextInput
                id="name_extension"
                v-model="form.name_extension"
                type="text"
                class="mt-1 block w-full"
                
                autocomplete="name_extension"
              />

              <InputError
                class="mt-2"
                :message="form.errors.name_extension"
              />
            </div>

            <div class="col-12 mb-2">
              <InputLabel for="dtr_user_id" value="DTR User ID" />

              <TextInput
                id="dtr_user_id"
                v-model="form.dtr_user_id"
                type="number"
                class="mt-1 block w-full"
                
                autocomplete="dtr_user_id"
              />

              <InputError
                class="mt-2"
                :message="form.errors.dtr_user_id"
              />
            </div>

            <div class="col-12 mb-2">
              <InputLabel for="position" value="Position" />
              <select id="position" v-model="form.plantilla_id" class="form-select" name="">
                <option value="">Select position</option>
                <option v-for="item in props.positions" :key="item.id" :value="item.id">{{ `${item.title} | ${item.division.abbreviation}` }}</option>
              </select>
              <InputError
                class="mt-2"
                :message="form.errors.plantilla_id"
              />
            </div>

            <div class="col-12 mb-2">
              <InputLabel for="role" value="Role" />
              <select id="role" v-model="form.role" class="form-select" name="">
                <option v-for="item in props.roles" :key="item" :value="item">{{ item }}</option>
              </select>
              <InputError
                class="mt-2"
                :message="form.errors.role"
              />
            </div>

            <div class="col-12 mb-2">
              <InputLabel for="username" value="Username" />

              <TextInput
                id="username"
                v-model="form.username"
                type="string"
                class="mt-1 block w-full"
                
                autocomplete="username"
              />

              <InputError
                class="mt-2"
                :message="form.errors.username"
              />
            </div>

            <div class="col mb-2">
              <InputLabel for="password" value="Password" />

              <TextInput
                id="password"
                v-model="form.password"
                type="password"
                class="mt-1 block w-full"
                
                autocomplete="new-password"
              />

              <InputError
                class="mt-2"
                :message="form.errors.password"
              />
            </div>

            <div class="col mb-4">
              <InputLabel
                for="password_confirmation"
                value="Confirm Password"
              />

              <TextInput
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                class="mt-1 block w-full"
                
                autocomplete="new-password"
              />

              <InputError
                class="mt-2"
                :message="form.errors.password_confirmation"
              />
            </div>

            <div
              class="d-flex align-items-center justify-content-end col-12 gap-3"
            >
              <PrimaryButton
                class="ml-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Register
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
