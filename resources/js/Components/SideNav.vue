<template>
  <ul class="nav text-light flex-column gap-2 shadow p-4 side-nav bg-primary" style="z-index: 1;">
    <li class="nav-item  d-flex align-center gap-2">
      <img :src="nedalogo" alt="" class="img-fluid side-nav-logo" />
      <b>NRO2 Human Resource Information System</b>
    </li>
    <li class="nav-item mt-4">
      <Link
        class="nav-link text-info" :class="{
          active: route().current(
            'recruitment.job_posting.*'
          )
        }" :href="route('recruitment.job_posting.index')"
      >
        Job Vacancies
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
