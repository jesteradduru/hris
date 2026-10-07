<template>
  <ul class="nav flex-column shadow-sm pt-4 side-nav border-end border-light border-opacity-10 bg-primary" style="z-index: 1040; position: sticky; top: 0; height: 100vh; overflow-y: auto; overflow-x: hidden;">
    <li class="nav-item d-flex align-items-center gap-3 px-4 mb-5 mt-2">
      <img :src="nedalogo" alt="DEPDev2 Logo" class="img-fluid bg-white rounded-circle p-1 shadow-sm" style="width: 48px; height: 48px;" />
      <div class="d-flex flex-column">
        <span class="text-white fw-bold lh-sm">DEPDev2</span>
        <span class="text-white-50 small" style="font-size: 0.7rem;">HRIS Portal</span>
      </div>
    </li>

    <div class="px-3 mb-2 small text-white-50 fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Menu</div>

    <li :class="{'mt-1': !user}" class="nav-item px-3 mb-1">
      <Link
        class="nav-link rounded-3 d-flex align-items-center" :class="{
          'bg-white bg-opacity-25 fw-bold shadow-sm': route().current(
            'recruitment.job_posting.*'
          ) || route().current('job_application.create')
        }" :href="route('recruitment.job_posting.index')"
      >
        <div style="width: 24px;" class="d-flex justify-content-center me-2">
          <i class="fa-solid fa-suitcase" />
        </div>
        <span>Job Vacancies</span>
      </Link>
    </li>
    
    <li v-if="user && permissions.includes('View L&D Form')" class="nav-item px-3 mb-1">
      <Link
        class="nav-link rounded-3 d-flex align-items-center" :class="{
          'bg-white bg-opacity-25 fw-bold shadow-sm': route().current('lnd_forms.*')
        }" :href="route('lnd_forms.index')"
      >
        <div style="width: 24px;" class="d-flex justify-content-center me-2">
          <i class="fa-solid fa-book-open-reader" />
        </div>
        <span>Learning & Development</span>
      </Link>
    </li>
    
    <li v-if="user && permissions.includes('View SPMS')" class="nav-item px-3 mb-1">
      <Link
        class="nav-link rounded-3 d-flex align-items-center" :class="{
          'bg-white bg-opacity-25 fw-bold shadow-sm': route().current('profile.spms.*')
        }" :href="route('profile.spms.index')"
      >
        <div style="width: 24px;" class="d-flex justify-content-center me-2">
          <i class="fa-solid fa-square-poll-vertical" />
        </div>
        <span>Performance Mgt</span>
      </Link>
    </li>

    <li v-if="user" class="nav-item px-3 mb-1">
      <Link
        class="nav-link rounded-3 d-flex align-items-center" :class="{
          'bg-white bg-opacity-25 fw-bold shadow-sm': route().current('profile.pds.*')
        }" :href="route('profile.pds.personal_information.edit')"
      >
        <div style="width: 24px;" class="d-flex justify-content-center me-2">
          <i class="fa-solid fa-file-lines" />
        </div>
        <span>Personal Data Sheet</span>
      </Link>
    </li>
    
    <li v-if="user && permissions.includes('View Application')" class="nav-item px-3 mb-1">
      <Link
        class="nav-link rounded-3 d-flex align-items-center" :class="{
          'bg-white bg-opacity-25 fw-bold shadow-sm': route().current('job_application.*') && !route().current('job_application.create') 
        }" :href="route('job_application.index')"
      >
        <div style="width: 24px;" class="d-flex justify-content-center me-2">
          <i class="fa-solid fa-briefcase" />
        </div>
        <span>Job Applications</span>
      </Link>
    </li>
    
    <li v-if="user && permissions.includes('View DTR')" class="nav-item px-3 mb-1">
      <Link
        class="nav-link rounded-3 d-flex align-items-center" :class="{
          'bg-white bg-opacity-25 fw-bold shadow-sm': route().current('daily_time_record.*')
        }" :href="route('daily_time_record.index')"
      >
        <div style="width: 24px;" class="d-flex justify-content-center me-2">
          <i class="fa-solid fa-clock" />
        </div>
        <span>Daily Time Record</span>
      </Link>
    </li>
    
    <li class="mt-auto text-center text-white-50 pb-4 small">
      <div class="border-top border-light border-opacity-25 pt-3 mx-4">
        &copy; 2023 - {{ moment().format('Y') }}<br>
        <a class="text-white fw-bold text-decoration-none" target="_blank" href="https://dro2.depdev.gov.ph">DEPDev2</a>
      </div>
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
