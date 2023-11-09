<script setup>
import Layout from './Layout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, useForm } from '@inertiajs/vue3'

const form = useForm({
  surname: props.employee.surname,
  first_name: props.employee.first_name,
  name_extension: props.employee.name_extension,
  middle_name: props.employee.middle_name,
  username: props.employee.username,
  password: '',
  dtr_user_id: props.employee.dtr_user_id,
  password_confirmation: '',
  role: props.employee.role_name[0],
  plantilla_id: props.employee.plantilla_id,
})

const props = defineProps({
  roles: Array,
  employee: Object,
  positions: Array,
})

const submit = () => {
  form.put(route('admin.employees.employee.update', {
    employee: props.employee.id,
  }), {
    onFinish: () => form.reset('password', 'password_confirmation'),
    onSuccess: () => {
      form.reset()
    },
  })
}
</script>

<template>
  <Layout :employee="props.employee.id">
    <Head title="Register" />
    <div class="container">
      <div class="card shadow">
        <div class="card-body">
          <form @submit.prevent="submit">
            <div class="mb-3"> 
              <InputLabel for="surname" value="Surname" />

              <TextInput
                id="surname"
                v-model="form.surname"
                type="text"
                class="mt-1 block w-full"
                autocomplete="surname"
              />

              <InputError
                class="mt-2"
                :message="form.errors.surname"
              />
            </div>

            <div class="mb-3"> 
              <InputLabel for="first_name" value="First Name" />

              <TextInput
                id="first_name"
                v-model="form.first_name"
                type="text"
                class="mt-1 block w-full"
                autofocus
                autocomplete="first_name"
              />

              <InputError
                class="mt-2"
                :message="form.errors.first_name"
              />
            </div>

            <div class="mb-3"> 
              <InputLabel for="middle_name" value="Middle Name" />

              <TextInput
                id="middle_name"
                v-model="form.middle_name"
                type="text"
                class="mt-1 block w-full"
                autofocus
                autocomplete="middle_name"
              />

              <InputError
                class="mt-2"
                :message="form.errors.middle_name"
              />
            </div>
            
            <div class="mb-3"> 
              <InputLabel for="name_extension" value="Name Extension" />

              <TextInput
                id="name_extension"
                v-model="form.name_extension"
                type="text"
                class="mt-1 block w-full"
                autofocus
                autocomplete="name_extension"
              />

              <InputError
                class="mt-2"
                :message="form.errors.name_extension"
              />
            </div>

            <div class="mb-3">
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

            <div class="mb-3">
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


            <div class="mb-3">
              <InputLabel for="role" value="Role" />
              <select id="" v-model="form.role" class="form-select" name="">
                <option v-for="item in props.roles" :key="item" :value="item">{{ item }}</option>
              </select>
              <InputError
                class="mt-2"
                :message="form.errors.role"
              />
            </div>

            <div class="mb-3">
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

            <div class="mb-3">
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

            <div class="mb-3">
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
              class="d-flex align-items-center justify-content-end mt-4 gap-3"
            >
              <PrimaryButton
                class="ml-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Update
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </Layout>
</template>
