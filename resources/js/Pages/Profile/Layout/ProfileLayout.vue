<template>
  <Head title="Profile" />
  <AuthenticatedLayout>
    <ul class="nav flex-row nav-pills">
      <li class="nav-item">
        <Link
          class="nav-link" :class="{
            active: route().current('profile.index')
          }" :href="route('profile.index')"
        >
          Profile
        </Link>
      </li>
      <li class="nav-item">
        <Link
          class="nav-link" :class="{
            active: route().current('profile.pds.*')
          }" :href="route('profile.pds.personal_information.edit')"
        >
          Personal
          Data Sheet
        </Link>
      </li>
      <li class="nav-item">
        <Link
          class="nav-link" :class="{
            active: route().current('job_application.index')
          }" :href="route('job_application.index')"
        >
          Job Applications
        </Link>
      </li>
      <li class="nav-item">
        <Link
          class="nav-link" :class="{
            active: route().current('profile.rewards.index')
          }" :href="route('profile.rewards.index')"
        >
          Rewards and Recognition
        </Link>
      </li>
      <li class="nav-item">
        <Link
          class="nav-link" :class="{
            active: route().current(
              'profile.edit'
            )
          }" :href="route('profile.edit')"
        >
          Settings
        </Link>
      </li>
    </ul>
    <div class="mt-4">
      <slot name="header" />
      <slot />
    </div>
  </AuthenticatedLayout>
</template>


<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
</script>
