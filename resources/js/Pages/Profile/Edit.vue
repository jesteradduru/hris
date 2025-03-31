<script setup>
import ProfileLayout from '@/Pages/Profile/Layout/ProfileLayout.vue'
import DeleteUserForm from './Partials/DeleteUserForm.vue'
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
})
</script>

<template>
  <Head title="Profile" />

  <ProfileLayout>
    <template #header>
      <h3 class="font-semibold text-xl text-gray-800 leading-tight">
        Profile Settings
      </h3>
    </template>

    <div class="mt-4">
      <div class="container d-flex flex-column gap-4">
        <div class="card shadow">
          <div class="card-body">
            <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="max-w-xl"/>
          </div>
        </div>

        <div class="card shadow">
          <div class="card-body">
            <UpdatePasswordForm class="max-w-xl" />
          </div>
        </div>

        <div class="card shadow">
          <div class="card-body">
            <DeleteUserForm class="max-w-xl" />
          </div>
        </div>
      </div>
    </div>
  </ProfileLayout>
</template>
