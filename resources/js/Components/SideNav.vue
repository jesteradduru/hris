<template>
  <ul class="nav flex-column shadow pt-4 side-nav bg-primary" style="z-index: 1; text-transform:">
    <li class="nav-item  d-flex align-center gap-2 mx-2 mb-4">
      <img :src="nedalogo" alt="" class="img-fluid side-nav-logo" />
      <span class="text-light">NRO2 Human Resource Information System</span>
    </li>
    <li :class="{'mt-3': !user}" class="nav-item">
      <Link
        class="nav-link " :class="{
          active: route().current(
            'recruitment.job_posting.*'
          ) || route().current('job_application.create')
        }" :href="route('recruitment.job_posting.index')"
      >
        <i class="fa-solid fa-suitcase me-3" />
        <span>Job Vacancies</span>
      </Link>
    </li>
    <li v-if="user && permissions.includes('View L&D Form')" class="nav-item">
      <Link
        class="nav-link d-flex align-items-center" :class="{
          active: route().current('lnd_forms.*')
        }" :href="route('lnd_forms.index')"
      >
        <i class="fa-solid fa-book-open-reader me-3" />
        <span>Learning and Development</span>
      </Link>
    </li>
    
    <li v-if="user && permissions.includes('View SPMS')" class="nav-item">
      <Link
        class="nav-link d-flex align-items-center" :class="{
          active: route().current('profile.spms.*')
        }" :href="route('profile.spms.index')"
      >
        <i class="fa-solid fa-square-poll-vertical me-3" />
        <span>Performance Management</span>
      </Link>
    </li>

    <li v-if="user" class="nav-item">
      <Link
        class="nav-link d-flex align-items-center" :class="{
          active: route().current('profile.pds.*')
        }" :href="route('profile.pds.personal_information.edit')"
      >
        <i class="fa-solid fa-file-lines me-3" />
        <span>Personal
          Data Sheet</span>
      </Link>
    </li>
    <li v-if="user && permissions.includes('View Application')" class="nav-item">
      <Link
        class="nav-link d-flex align-items-center" :class="{
          active: route().current('job_application.*') && !route().current('job_application.create') 
        }" :href="route('job_application.index')"
      >
        <i class="fa-solid fa-suitcase me-3" />
        <span>Job Applications</span>
      </Link>
    </li>
    <li v-if="user && permissions.includes('View DTR')" class="nav-item">
      <Link
        class="nav-link  d-flex align-items-center" :class="{
          active: route().current(
            'daily_time_record.*'
          )
        }" :href="route('daily_time_record.index')"
      >
        <i class="fa-solid fa-clock me-3" />
        <span>My Daily Time Record</span>
      </Link>
    </li>
    <li class="mt-auto text-center text-secondary mb-4">
      <small>&copy; 2023 - {{ moment().format('Y') }} | <a class="text-secondary" target="_blank" href="https://neda.rdc2.gov.ph">NRO2</a></small>
    </li>
  </ul>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import nedalogo from '@/Assets/neda-logo.png'
import { computed } from 'vue'
import moment from 'moment'

const user = computed(() => usePage().props.auth.user)
const permissions = usePage()
  .props.auth.permissions?.map((perm) => perm.name)
</script>
