<template>
  <ul class="nav text-light flex-column gap-2 shadow p-4 side-nav bg-primary" style="z-index: 1; text-transform:">
    <li class="nav-item  d-flex align-center gap-2">
      <img :src="nedalogo" alt="" class="img-fluid side-nav-logo" />
      <b>NRO2 Human Resource Information System</b>
    </li>
    <li v-if="user" class="nav-item mt-4">
      <Link
        class="nav-link text-info" :class="{
          active: route().current(
            'notification.*'
          )
        }" :href="route('notification.index')"
      >
        Notifications <span v-if="$page.props.auth.notificationCount" class="badge bg-danger">{{ $page.props.auth.notificationCount }}</span>
      </Link>
    </li>
    <li :class="{'mt-3': !user}" class="nav-item">
      <Link
        
        class="nav-link text-info" :class="{
          active: route().current(
            'recruitment.job_posting.*'
          ) || route().current('job_application.create')
        }" :href="route('recruitment.job_posting.index')"
      >
        Job Vacancies
      </Link>
    </li>
    <li v-if="user && permissions.includes('View L&D Form')" class="nav-item">
      <Link
        class="nav-link" :class="{
          active: route().current('lnd_forms.*')
        }" :href="route('lnd_forms.index')"
      >
        Learning and Development
      </Link>
    </li>
    
    <li v-if="user && permissions.includes('View SPMS')" class="nav-item">
      <Link
        class="nav-link" :class="{
          active: route().current('profile.spms.*')
        }" :href="route('profile.spms.index')"
      >
        Performance Management
      </Link>
    </li>

    <li v-if="user && permissions.includes('View Reward')" class="nav-item">
      <Link
        class="nav-link" :class="{
          active: route().current('profile.rewards.*')
        }" :href="route('profile.rewards.index')"
      >
        Rewards and Recognition
      </Link>
    </li>
    <li v-if="user" class="nav-item">
      <Link
        class="nav-link" :class="{
          active: route().current('profile.pds.*')
        }" :href="route('profile.pds.personal_information.edit')"
      >
        Personal
        Data Sheet
      </Link>
    </li>
    <li v-if="user && permissions.includes('View Application')" class="nav-item">
      <Link
        class="nav-link" :class="{
          active: route().current('job_application.*') && !route().current('job_application.create') 
        }" :href="route('job_application.index')"
      >
        Job Applications
      </Link>
    </li>
    <li v-if="user && permissions.includes('View DTR')" class="nav-item">
      <Link
        class="nav-link text-info" :class="{
          active: route().current(
            'daily_time_record.*'
          )
        }" :href="route('daily_time_record.index')"
      >
        My Daily Time Record
      </Link>
    </li>
  </ul>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import nedalogo from '@/Assets/neda-logo.png'
import { computed } from 'vue'

const user = computed(() => usePage().props.auth.user)
const permissions = usePage()
  .props.auth.permissions?.map((perm) => perm.name)
</script>
