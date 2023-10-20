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
      <!-- <li class="nav-item">
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
      <li v-if="permission.includes('View Reward')" class="nav-item">
        <Link
          class="nav-link" :class="{
            active: route().current('profile.rewards.index')
          }" :href="route('profile.rewards.index')"
        >
          Rewards and Recognition
        </Link>
      </li>
      <li v-if="permission.includes('View SPMS')" class="nav-item">
        <Link
          class="nav-link" :class="{
            active: route().current('profile.spms.*')
          }" :href="route('profile.spms.index')"
        >
          SPMS
        </Link>
      </li> -->
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
import { Head, Link, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const permission = usePage().props.auth.permissions.map(p => p.name)
</script>
