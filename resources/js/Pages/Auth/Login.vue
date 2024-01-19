<script setup>
import Checkbox from '@/Components/Checkbox.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import logo from '@/Assets/Logo.jpg'
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
                <h3 class="card-title text-primary">Login</h3>
                <br />
                <div
                  v-if="status"
                  class="mb-4 font-medium text-sm text-green-600"
                >
                  {{ status }}
                </div>
                <form @submit.prevent="submit">
                  <div>
                    <InputLabel for="username" value="Username" />
  
                    <TextInput
                      id="username"
                      v-model="form.username"
                      type="text"
                      class="mt-1 block w-full"
                      required
                      autofocus
                      autocomplete="username"
                    />
  
                    <InputError
                      class="mt-2"
                      :message="form.errors.username"
                    />
                  </div>
  
                  <div class="mt-4">
                    <InputLabel for="password" value="Password" />
  
                    <TextInput
                      id="password"
                      v-model="form.password"
                      type="password"
                      class="mt-1 block w-full"
                      required
                      autocomplete="current-password"
                    />
  
                    <InputError
                      class="mt-2"
                      :message="form.errors.password"
                    />
                  </div>
  
                  <div class="block mt-4">
                    <label class="d-flex align-items-center gap-1">
                      <Checkbox
                        v-model:checked="form.remember"
                        name="remember"
                      />
                      <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                  </div>
  
                  <div class="form-text mt-3 text-center">
                    Doesn't have an account? 
                    <Link :href="route('register')">
                      <b>Register here</b>
                    </Link>
                  </div>
                  <div
                    class="d-flex align-items-center justify-content-end mt-4 gap-3"
                  >
                    <PrimaryButton
                      class="ml-4"
                      :class="{ 'opacity-25': form.processing }"
                      :disabled="form.processing"
                    >
                      Log in
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
</template>
