<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import logo from '@/Assets/Logo.jpg'
import MainNavbar from '@/Components/MainNavbar.vue'


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
  <!-- <AuthenticatedLayout> -->
  <Head title="Register" />

  <MainNavbar />
  <div class="auth-layout">
    <div class="container">
      <div class="row">
        <div class="col d-md-flex flex-column justify-content-center d-none">
          <img :src="logo" class="img-fluid" alt="" />
        </div>
        <div class="col left d-flex flex-column justify-content-center">
          <div class="container">
            <div class="card shadow">
              <div class="card-body">
                <h3 class="card-title text-primary">Register</h3>
                <br />
                <div
                  v-if="status"
                  class="mb-4 font-medium text-sm text-green-600"
                >
                  {{ status }}
                </div>
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

                  <div class="form-text mt-3 text-center">
                    Already have an account? 
                    <Link :href="route('login')">
                      <b>Login here</b>
                    </Link>
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
        </div>
      </div> <!-- row-->
    </div> <!-- container-->
  </div> <!-- auth layout-->

  <!-- </AuthenticatedLayout> -->
</template>
