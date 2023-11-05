<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  surname: '',
  first_name: '',
  name_extension: '',
  middle_name: '',
  username: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Register" />

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
                required
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
                required
                autofocus
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
                required
                autofocus
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
                autofocus
                autocomplete="name_extension"
              />

              <InputError
                class="mt-2"
                :message="form.errors.name_extension"
              />
            </div>

            <div class="col-12 mb-2">
              <InputLabel for="username" value="Username" />

              <TextInput
                id="username"
                v-model="form.username"
                type="string"
                class="mt-1 block w-full"
                required
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
                required
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
                required
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
              <Link
                :href="route('login')"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                Already registered?
              </Link>

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
  </AuthenticatedLayout>
</template>
