<template>
  <nav
    class="navbar top-bar shadow-sm fixed-top bg-white border-bottom" style="z-index: 1030;" 
  >
    <div class="container-fluid px-3">
      <div class="d-flex gap-3 align-items-center">
        <div data-bs-toggle="offcanvas" data-bs-target="#sideNav" class="side-nav-toggler text-dark d-block d-md-none" style="cursor: pointer;">
          <i class="fa-solid fa-bars fs-5" />
        </div>
        <Link class="navbar-brand fw-bold text-primary d-flex align-items-center gap-2 d-md-none" :href="route('dashboard')">
          <img :src="nedalogo" alt="Logo" width="30" height="30" class="d-inline-block align-text-top rounded-circle shadow-sm">
          <span class="d-inline">DEPDev2 HRIS</span>
        </Link>
      </div>
      
      <div class="d-flex align-items-center gap-3">
        <div v-if="$page.props.auth.user" class="d-none d-sm-flex align-items-center bg-light rounded-pill px-3 py-1 border shadow-sm">
          <img v-if="$page.props.auth.user.profile_pic" class="profile-pic-nav rounded-circle me-2 object-fit-cover border" style="width: 32px; height: 32px;" :src="$page.props.auth.user.profile_pic" alt="" />
          <img v-else class="profile-pic-nav rounded-circle me-2 object-fit-cover border" style="width: 32px; height: 32px;" src="../Assets/profile.png" alt="" />
          <span class="fw-medium text-dark small">{{ $page.props.auth.user?.name }}</span>
        </div>
        
        <div v-if="user" class="dropdown">
          <a class="d-flex justify-content-center align-items-center bg-light text-dark rounded-circle border shadow-sm transition-all hover-shadow-sm" style="width: 40px; height: 40px; cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-ellipsis-vertical" />
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2 py-2">
            <li>
              <Link class="dropdown-item d-flex align-items-center gap-2 py-2 px-3" :href="route('profile.edit')">
                <i class="fa-regular fa-id-badge text-primary w-15px"></i> Profile
              </Link>
            </li>
            <li v-if="admin">
              <Link class="dropdown-item d-flex align-items-center gap-2 py-2 px-3" :href="route('admin.dashboard')">
                <i class="fa-solid fa-gauge-high text-primary w-15px"></i> Admin Panel
              </Link>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <Link class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 text-danger" :href="route('logout')" method="post" as="button">
                <i class="fa-solid fa-arrow-right-from-bracket w-15px"></i> Logout
              </Link>
            </li>
          </ul>
        </div>

        <div v-else class="d-flex gap-2">
          <Link :href="route('login')" class="btn btn-outline-primary rounded-pill px-4 fw-medium">Sign In</Link>
          <Link :href="route('register')" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm">Register</Link>
        </div>
      </div>
    </div>
  </nav>

  <!-- Mobile Offcanvas Sidebar -->
  <div id="sideNav" class="offcanvas offcanvas-start side-nav bg-primary border-0" data-bs-scroll="true" tabindex="-1">
    <div class="offcanvas-header border-bottom border-light border-opacity-10 py-4 px-4">
      <div class="offcanvas-title d-flex align-items-center gap-3">
        <img :src="nedalogo" alt="DEPDev2 Logo" class="img-fluid bg-white rounded-circle p-1 shadow-sm" style="width: 40px; height: 40px;" />
        <div class="d-flex flex-column">
          <span class="text-white fw-bold lh-sm fs-6">DEPDev2</span>
          <span class="text-white-50 small" style="font-size: 0.7rem;">HRIS Portal</span>
        </div>
      </div>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close" />
    </div>
    
    <div class="offcanvas-body p-0 d-flex flex-column">
      <div class="px-4 mt-4 mb-2 small text-white-50 fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Menu</div>
      
      <ul class="nav flex-column w-100 pb-4">
        <li :class="{'mt-1': !user}" class="nav-item px-3 mb-1">
          <Link
            class="nav-link rounded-3 d-flex align-items-center" :class="{
              'bg-white bg-opacity-25 fw-bold shadow-sm text-white': route().current('recruitment.job_posting.*') || route().current('job_application.create'),
              'text-white': !route().current('recruitment.job_posting.*') && !route().current('job_application.create')
            }" :href="route('recruitment.job_posting.index')"
          >
            <div style="width: 24px;" class="d-flex justify-content-center me-2"><i class="fa-solid fa-suitcase" /></div>
            <span>Job Vacancies</span>
          </Link>
        </li>
        
        <li v-if="user && permissions.includes('View L&D Form')" class="nav-item px-3 mb-1">
          <Link
            class="nav-link rounded-3 d-flex align-items-center" :class="{
              'bg-white bg-opacity-25 fw-bold shadow-sm text-white': route().current('lnd_forms.*'),
              'text-white': !route().current('lnd_forms.*')
            }" :href="route('lnd_forms.index')"
          >
            <div style="width: 24px;" class="d-flex justify-content-center me-2"><i class="fa-solid fa-book-open-reader" /></div>
            <span>Learning & Development</span>
          </Link>
        </li>
      
        <li v-if="user && permissions.includes('View SPMS')" class="nav-item px-3 mb-1">
          <Link
            class="nav-link rounded-3 d-flex align-items-center" :class="{
              'bg-white bg-opacity-25 fw-bold shadow-sm text-white': route().current('profile.spms.*'),
              'text-white': !route().current('profile.spms.*')
            }" :href="route('profile.spms.index')"
          >
            <div style="width: 24px;" class="d-flex justify-content-center me-2"><i class="fa-solid fa-square-poll-vertical" /></div>
            <span>Performance Mgt</span>
          </Link>
        </li>

        <li v-if="user" class="nav-item px-3 mb-1">
          <Link
            class="nav-link rounded-3 d-flex align-items-center" :class="{
              'bg-white bg-opacity-25 fw-bold shadow-sm text-white': route().current('profile.pds.*'),
              'text-white': !route().current('profile.pds.*')
            }" :href="route('profile.pds.personal_information.edit')"
          >
            <div style="width: 24px;" class="d-flex justify-content-center me-2"><i class="fa-solid fa-file-lines" /></div>
            <span>Personal Data Sheet</span>
          </Link>
        </li>
        
        <li v-if="user && permissions.includes('View Application')" class="nav-item px-3 mb-1">
          <Link
            class="nav-link rounded-3 d-flex align-items-center" :class="{
              'bg-white bg-opacity-25 fw-bold shadow-sm text-white': route().current('job_application.*') && !route().current('job_application.create'),
              'text-white': !(route().current('job_application.*') && !route().current('job_application.create'))
            }" :href="route('job_application.index')"
          >
            <div style="width: 24px;" class="d-flex justify-content-center me-2"><i class="fa-solid fa-briefcase" /></div>
            <span>Job Applications</span>
          </Link>
        </li>
        
        <li v-if="user && permissions.includes('View DTR')" class="nav-item px-3 mb-1">
          <Link
            class="nav-link rounded-3 d-flex align-items-center" :class="{
              'bg-white bg-opacity-25 fw-bold shadow-sm text-white': route().current('daily_time_record.*'),
              'text-white': !route().current('daily_time_record.*')
            }" :href="route('daily_time_record.index')"
          >
            <div style="width: 24px;" class="d-flex justify-content-center me-2"><i class="fa-solid fa-clock" /></div>
            <span>Daily Time Record</span>
          </Link>
        </li>
      </ul>
      
      <div class="mt-auto text-center text-white-50 pb-4 small">
        <div class="border-top border-light border-opacity-25 pt-3 mx-4">
          &copy; 2023 - {{ moment ? moment().format('Y') : '2025' }}<br>
          <a class="text-white fw-bold text-decoration-none" target="_blank" href="https://dro2.depdev.gov.ph">DEPDev2</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import nedalogo from '@/Assets/neda-logo.png'
import { computed } from 'vue'
import moment from 'moment'

const user = computed(() => usePage().props.auth.user)

const permissions = usePage()
  .props.auth.permissions?.map((perm) => perm.name)

const admin = computed(() => {
  const isAdmin = permissions.includes('Access Admin')

  return isAdmin
})

</script>
