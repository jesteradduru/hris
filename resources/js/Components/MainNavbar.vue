<template>
  <nav
    class="navbar shadow fixed-top navbar-light bg-light" style="z-index: 1;" 
    :class="{'bg-primary': route().current('login') || route().current('register') , 'navbar-dark': route().current('login') || route().current('register')}
    "
  >
    <div class="container-fluid">
      <div class="d-flex gap-3 align-items-center ">
        <div data-bs-toggle="offcanvas" data-bs-target="#sideNav" class="side-nav-toggler px-1 d-block d-md-none">
          <span class="fa-solid fa-bars" />
        </div>
        <Link class="navbar-brand" :href="route('dashboard')">
          NRO2 HRIS
        </Link>
      </div>
      
      <div class="d-flex align-items-center">
        <div v-if="$page.props.auth.user ">
          <img v-if="$page.props.auth.user.profile_pic" class="profile-pic-nav rounded-circle shadow me-2" :src="$page.props.auth.user.profile_pic" alt="" />
          <img v-else class="profile-pic-nav rounded-circle  me-2" src="../Assets/profile.png" alt="" />
        </div>
        <div v-if="user" class="dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><b>{{
            $page.props.auth.user?.username }}</b></a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <Link class="dropdown-item" :href="route('profile.index')">Profile</Link>
            </li>
            <li v-if="admin">
              <Link class="dropdown-item" :href="route('admin.dashboard')">Admin</Link>
            </li>
            <li>
              <Link class="dropdown-item" :href="route('logout')" method="post" as="button">Logout</Link>
            </li>
          </ul>
        </div>

        <div v-else class="d-flex gap-2">
          <Link :href="route('login')" class="btn btn-dark">Sign-In</Link>
          <Link :href="route('register')" class="btn btn-secondary">Register</Link>
        </div>
      </div>
    </div>
  </nav>


  <div id="sideNav" class="offcanvas offcanvas-start bg-primary" data-bs-scroll="true" tabindex="-1" aria-labelledby="Enable both scrolling & backdrop">
    <div class="offcanvas-header text-light">
      <div class="offcanvas-title d-flex align-center gap-2">
        <img :src="nedalogo" alt="" class="img-fluid side-nav-logo" />
        <b>NRO2 Human Resource Information System</b>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" />
    </div>
    <ul class="nav text-light flex-column gap-2 p-4 bg-primary side-nav" style="z-index: 1;">
      <li class="nav-item">
        <b>Menu</b>
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

      <!-- <li v-if="user && permissions.includes('View Reward')" class="nav-item">
        <Link
          class="nav-link" :class="{
            active: route().current('profile.rewards.*')
          }" :href="route('profile.rewards.index')"
        >
          Rewards and Recognition
        </Link>
      </li> -->
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
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import nedalogo from '@/Assets/neda-logo.png'
import { computed } from 'vue'

const user = computed(() => usePage().props.auth.user)

const permissions = usePage()
  .props.auth.permissions?.map((perm) => perm.name)

const admin = computed(() => {
  const isAdmin = permissions.includes('Access Admin')

  console.log(permissions)
  return isAdmin
})

</script>
