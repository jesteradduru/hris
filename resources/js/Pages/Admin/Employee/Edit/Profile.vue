<script setup>
import Layout from './Layout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, useForm } from '@inertiajs/vue3'

const form = useForm({
  name: props.employee.name,
  username: props.employee.username,
  password: '',
  dtr_user_id: props.employee.dtr_user_id,
  password_confirmation: '',
  role: props.employee.role,
})

const props = defineProps({
  roles: Array,
  employee: Object,
})

const submit = () => {
  form.post(route('admin.employees.store'), {
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
            <div>
              <InputLabel for="name" value="Name" />

              <TextInput
                id="name"
                v-model="form.name"
                type="text"
                class="mt-1 block w-full"
                autofocus
                autocomplete="name"
              />

              <InputError
                class="mt-2"
                :message="form.errors.name"
              />
            </div>

            <div class="mt-4">
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

            <div class="mt-4">
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


            <div class="mt-4">
              <InputLabel for="role" value="Role" />
              <select id="" v-model="form.role" class="form-select" name="">
                <option v-for="item in props.roles" :key="item" :value="item">{{ item }}</option>
              </select>
              <InputError
                class="mt-2"
                :message="form.errors.role"
              />
            </div>

            <div class="mt-4">
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

            <div class="mt-4">
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
                Register
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </Layout>
</template>
