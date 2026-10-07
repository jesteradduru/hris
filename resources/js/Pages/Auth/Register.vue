<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import logo from '@/Assets/neda-logo.png'
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
  <Head title="Register" />
  <MainNavbar />
  <div class="auth-layout min-vh-100 d-flex align-items-center bg-light" style="padding-top: 60px;">
    <div class="container py-5">
      <div class="row justify-content-center shadow-lg rounded-5 overflow-hidden bg-white mx-auto" style="max-width: 1000px; min-height: 600px;">
        
        <!-- Left Side: Branding -->
        <div class="col-12 col-lg-5 d-none d-lg-flex flex-column justify-content-center align-items-center bg-primary text-white p-5 position-relative">
          <div class="bg-white p-4 rounded-circle shadow-lg mb-4" style="width: 160px; height: 160px; display: flex; align-items: center; justify-content: center;">
            <img :src="logo" class="img-fluid" alt="DEPDev2 Logo" style="max-height: 120px;" />
          </div>
          <h3 class="fw-bold text-center mb-2 text-white">Join Us Today!</h3>
          <p class="text-center text-white-50 px-3 small">
            Create your DEPDev2 HRIS account to apply for jobs and manage your profile seamlessly.
          </p>
          <div class="position-absolute opacity-10" style="bottom: -50px; left: -50px; width: 300px; height: 300px; background: radial-gradient(circle, white, transparent); border-radius: 50%;"></div>
          <div class="position-absolute opacity-10" style="top: -80px; right: -50px; width: 250px; height: 250px; background: radial-gradient(circle, white, transparent); border-radius: 50%;"></div>
        </div>
        
        <!-- Right Side: Registration Form -->
        <div class="col-12 col-lg-7 d-flex flex-column justify-content-center p-4 p-md-5">
          <div class="w-100 mx-auto">
            <div class="text-center d-lg-none mb-4">
              <img :src="logo" class="img-fluid rounded-circle shadow-sm" style="width: 100px;" alt="" />
            </div>
            
            <h4 class="fw-bold text-dark mb-1">Create an Account</h4>
            <p class="text-muted mb-4 small">Please fill in your details to register.</p>
            
            <div v-if="status" class="alert alert-success small py-2 mb-4 rounded-3 border-0">
              {{ status }}
            </div>
            
            <form @submit.prevent="submit">
              <div class="row g-3 mb-3">
                <div class="col-12 col-sm-6">
                  <InputLabel for="first_name" value="First Name" class="text-secondary small fw-bold mb-1" />
                  <TextInput
                    id="first_name"
                    v-model="form.first_name"
                    type="text"
                    class="form-control bg-light border-0 shadow-none px-3 rounded-3"
                    required
                    autofocus
                    placeholder="e.g. Juan"
                  />
                  <InputError class="mt-1" :message="form.errors.first_name" />
                </div>
                
                <div class="col-12 col-sm-6">
                  <InputLabel for="surname" value="Surname" class="text-secondary small fw-bold mb-1" />
                  <TextInput
                    id="surname"
                    v-model="form.surname"
                    type="text"
                    class="form-control bg-light border-0 shadow-none px-3 rounded-3"
                    required
                    placeholder="e.g. Dela Cruz"
                  />
                  <InputError class="mt-1" :message="form.errors.surname" />
                </div>
                
                <div class="col-12 col-sm-8">
                  <InputLabel for="middle_name" value="Middle Name" class="text-secondary small fw-bold mb-1" />
                  <TextInput
                    id="middle_name"
                    v-model="form.middle_name"
                    type="text"
                    class="form-control bg-light border-0 shadow-none px-3 rounded-3"
                    required
                    placeholder="e.g. Santos"
                  />
                  <InputError class="mt-1" :message="form.errors.middle_name" />
                </div>
                
                <div class="col-12 col-sm-4">
                  <InputLabel for="name_extension" value="Extension" class="text-secondary small fw-bold mb-1" />
                  <TextInput
                    id="name_extension"
                    v-model="form.name_extension"
                    type="text"
                    class="form-control bg-light border-0 shadow-none px-3 rounded-3"
                    placeholder="e.g. Jr, Sr"
                  />
                  <InputError class="mt-1" :message="form.errors.name_extension" />
                </div>
              </div>
              
              <div class="mb-3">
                <InputLabel for="username" value="Username" class="text-secondary small fw-bold mb-1" />
                <TextInput
                  id="username"
                  v-model="form.username"
                  type="text"
                  class="form-control bg-light border-0 shadow-none px-3 rounded-3"
                  required
                  placeholder="Choose a username"
                />
                <InputError class="mt-1" :message="form.errors.username" />
              </div>
              
              <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6">
                  <InputLabel for="password" value="Password" class="text-secondary small fw-bold mb-1" />
                  <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="form-control bg-light border-0 shadow-none px-3 rounded-3"
                    required
                    placeholder="Create a password"
                  />
                  <InputError class="mt-1" :message="form.errors.password" />
                </div>
                
                <div class="col-12 col-sm-6">
                  <InputLabel for="password_confirmation" value="Confirm Password" class="text-secondary small fw-bold mb-1" />
                  <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="form-control bg-light border-0 shadow-none px-3 rounded-3"
                    required
                    placeholder="Re-enter password"
                  />
                  <InputError class="mt-1" :message="form.errors.password_confirmation" />
                </div>
              </div>
              
              <button
                type="submit"
                class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm"
                :class="{ 'opacity-50': form.processing }"
                :disabled="form.processing"
              >
                Create Account <i class="fa-solid fa-user-plus ms-2"></i>
              </button>
              
              <div class="text-center mt-4 pt-3 border-top">
                <span class="text-muted small">Already have an account?</span>
                <Link :href="route('login')" class="text-primary fw-bold text-decoration-none ms-1 small">
                  Sign in instead
                </Link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
