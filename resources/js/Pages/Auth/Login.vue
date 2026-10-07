<script setup>
import Checkbox from '@/Components/Checkbox.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import logo from '@/Assets/neda-logo.png'
import MainNavbar from '@/Components/MainNavbar.vue'

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
})

const form = useForm({
  username: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <Head title="Log in" />
  <MainNavbar />
  <div class="auth-layout min-vh-100 d-flex align-items-center bg-light" style="padding-top: 60px;">
    <div class="container py-5">
      <div class="row justify-content-center shadow-lg rounded-5 overflow-hidden bg-white mx-auto" style="max-width: 900px; min-height: 550px;">
        <!-- Left Side: Branding -->
        <div class="col-12 col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center bg-primary text-white p-5 position-relative">
          <div class="bg-white p-4 rounded-circle shadow-lg mb-4" style="width: 160px; height: 160px; display: flex; align-items: center; justify-content: center;">
            <img :src="logo" class="img-fluid" alt="DEPDev2 Logo" style="max-height: 120px;" />
          </div>
          <h3 class="fw-bold text-center mb-2 text-white">Welcome Back!</h3>
          <p class="text-center text-white-50 px-4 small">
            Sign in to access your DEPDev2 HRIS portal and manage your account.
          </p>
          <div class="position-absolute opacity-10" style="top: -50px; right: -50px; width: 300px; height: 300px; background: radial-gradient(circle, white, transparent); border-radius: 50%;"></div>
          <div class="position-absolute opacity-10" style="bottom: -100px; left: -50px; width: 250px; height: 250px; background: radial-gradient(circle, white, transparent); border-radius: 50%;"></div>
        </div>
        
        <!-- Right Side: Login Form -->
        <div class="col-12 col-md-6 d-flex flex-column justify-content-center p-4 p-lg-5">
          <div class="w-100 mx-auto" style="max-width: 350px;">
            <div class="text-center d-md-none mb-4">
              <img :src="logo" class="img-fluid rounded-circle shadow-sm" style="width: 100px;" alt="" />
            </div>
            
            <h4 class="fw-bold text-dark mb-1">Sign In</h4>
            <p class="text-muted mb-4 small">Please enter your credentials to continue.</p>
            
            <div v-if="status" class="alert alert-success small py-2 mb-4 rounded-3 border-0">
              {{ status }}
            </div>
            
            <form @submit.prevent="submit">
              <div class="mb-3">
                <InputLabel for="username" value="Username" class="text-secondary small fw-bold mb-1" />
                <TextInput
                  id="username"
                  v-model="form.username"
                  type="text"
                  class="form-control form-control-lg bg-light border-0 shadow-none px-3 rounded-3"
                  required
                  autofocus
                  autocomplete="username"
                  placeholder="Enter your username"
                />
                <InputError class="mt-1" :message="form.errors.username" />
              </div>
              
              <div class="mb-4">
                <InputLabel for="password" value="Password" class="text-secondary small fw-bold mb-1" />
                <TextInput
                  id="password"
                  v-model="form.password"
                  type="password"
                  class="form-control form-control-lg bg-light border-0 shadow-none px-3 rounded-3"
                  required
                  autocomplete="current-password"
                  placeholder="Enter your password"
                />
                <InputError class="mt-1" :message="form.errors.password" />
              </div>
              
              <div class="d-flex justify-content-between align-items-center mb-4">
                <label class="d-flex align-items-center gap-2 cursor-pointer mb-0">
                  <Checkbox v-model:checked="form.remember" name="remember" />
                  <span class="small text-secondary fw-medium">Remember me</span>
                </label>
              </div>
              
              <button 
                type="submit"
                class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm"
                :class="{ 'opacity-50': form.processing }"
                :disabled="form.processing"
              >
                Log In <i class="fa-solid fa-arrow-right ms-2"></i>
              </button>
              
              <div class="text-center mt-4 pt-3 border-top">
                <span class="text-muted small">Don't have an account?</span>
                <Link :href="route('register')" class="text-primary fw-bold text-decoration-none ms-1 small">
                  Create one now
                </Link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
