<template>
  <nav class="navbar navbar-expand-lg bg-white border-0 shadow-sm rounded-4 px-3 py-2 mb-3 align-items-center">
    <div class="container-fluid">
      <!-- Brand -->
      <Link class="navbar-brand d-flex align-items-center gap-2 fw-bold text-primary fs-5" :href="route('admin.dashboard')">
        <img :src="logo" alt="HRIS Logo" class="rounded-circle shadow-sm bg-white" style="width: 40px; height: 40px; object-fit: contain;" />
        HRIS Admin
      </Link>

      <!-- Mobile Toggle -->
      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Nav Links -->
      <div id="adminNavbar" class="collapse navbar-collapse mt-3 mt-lg-0">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1 fw-medium" style="font-size: 0.9rem;">
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle px-3 rounded-pill hover-bg-light text-dark" href="#" role="button" data-bs-toggle="dropdown">
              Modules
            </a>
            <ul class="dropdown-menu shadow-sm border-0 rounded-4 mt-2">
              <li v-if="permissions.includes('View Recruitment, Selection and Placement Page')">
                <Link class="dropdown-item py-2 px-3 hover-text-primary rounded-3 mx-2" style="width: auto;" :href="route('admin.recruitment.plantilla.index')" :class="{'active bg-primary bg-opacity-10 text-primary fw-bold': route().current('admin.recruitment.*')}">
                  Recruitment & Selection
                </Link>
              </li>
              <li v-if="permissions.includes('View Recruitment, Selection and Placement Page')">
                <Link class="dropdown-item py-2 px-3 hover-text-primary rounded-3 mx-2 mt-1" style="width: auto;" :href="route('admin.lnd.index')" :class="{'active bg-primary bg-opacity-10 text-primary fw-bold': route().current('admin.lnd.*') || route().current('admin.idp.*')}">
                  Learning & Development
                </Link>
              </li>
              <li>
                <Link class="dropdown-item py-2 px-3 hover-text-primary rounded-3 mx-2 mt-1" style="width: auto;" :href="route('admin.spms.index')" :class="{'active bg-primary bg-opacity-10 text-primary fw-bold': route().current('admin.spms.*')}">
                  Performance Management
                </Link>
              </li>
              <li v-if="permissions.includes('View Reward Page')">
                <Link class="dropdown-item py-2 px-3 hover-text-primary rounded-3 mx-2 mt-1" style="width: auto;" :href="route('admin.rewards.index')" :class="{'active bg-primary bg-opacity-10 text-primary fw-bold': route().current('admin.rewards.*')}">
                  Rewards & Recognition
                </Link>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <Link class="nav-link px-3 rounded-pill transition-all" :href="route('admin.employees.index')" :class="route().current('admin.employees.*') ? 'bg-primary text-white fw-bold shadow-sm' : 'hover-bg-light text-dark'">
              Accounts
            </Link>
          </li>

          <li class="nav-item">
            <Link class="nav-link px-3 rounded-pill transition-all" :href="route('admin.divisions.index')" :class="route().current('admin.divisions.*') ? 'bg-primary text-white fw-bold shadow-sm' : 'hover-bg-light text-dark'">
              Divisions
            </Link>
          </li>

          <li v-if="permissions.includes('View Roles and Permissions Page')" class="nav-item">
            <Link class="nav-link px-3 rounded-pill transition-all" :href="route('admin.role_permission.role.index')" :class="route().current('admin.role_permission.*') ? 'bg-primary text-white fw-bold shadow-sm' : 'hover-bg-light text-dark'">
              Roles & Permissions
            </Link>
          </li>

          <li class="nav-item">
            <Link class="nav-link px-3 rounded-pill transition-all" :href="route('admin.reports.index')" :class="route().current('admin.reports.*') ? 'bg-primary text-white fw-bold shadow-sm' : 'hover-bg-light text-dark'">
              Reports
            </Link>
          </li>

          <li class="nav-item">
            <Link class="nav-link px-3 rounded-pill transition-all" :href="route('admin.dtr.dtr.index')" :class="route().current('admin.dtr.*') ? 'bg-primary text-white fw-bold shadow-sm' : 'hover-bg-light text-dark'">
              DTR
            </Link>
          </li>

        </ul>

        <!-- Right Side: User Profile & Menu -->
        <div class="d-flex align-items-center gap-3 border-start ps-3 ms-2 mt-3 mt-lg-0">
          <div v-if="$page.props.auth.user" class="d-flex align-items-center gap-2">
            <img v-if="$page.props.auth.user.profile_pic" class="rounded-circle border object-fit-cover shadow-sm" style="width: 38px; height: 38px;" :src="$page.props.auth.user.profile_pic" alt="" />
            <img v-else class="rounded-circle border object-fit-cover shadow-sm" style="width: 38px; height: 38px;" src="../../../Assets/profile.png" alt="" />
            <div class="d-none d-xl-flex flex-column lh-1">
              <span class="fw-bold text-dark small">{{ $page.props.auth.user?.name }}</span>
              <span class="text-muted" style="font-size: 0.75rem;">Administrator</span>
            </div>
          </div>
          
          <div class="dropdown">
            <a class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center text-secondary border-0 hover-bg-primary hover-text-white transition-all shadow-sm" href="#" role="button" data-bs-toggle="dropdown" style="width: 38px; height: 38px;">
              <i class="fas fa-ellipsis-v"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 mt-2">
              <li>
                <Link class="dropdown-item py-2 px-3 mx-2 rounded-3 hover-bg-light" style="width: auto;" :href="route('profile.edit')">
                  <i class="fa-solid fa-user me-2 text-muted"></i> My Profile
                </Link>
              </li>
              <li>
                <Link class="dropdown-item py-2 px-3 mx-2 rounded-3 hover-bg-light" style="width: auto;" :href="route('dashboard')">
                  <i class="fa-solid fa-home me-2 text-muted"></i> Main App
                </Link>
              </li>
              <li><hr class="dropdown-divider my-1 mx-3"></li>
              <li>
                <Link class="dropdown-item py-2 px-3 mx-2 rounded-3 text-danger hover-bg-danger hover-text-white" style="width: auto;" :href="route('logout')" method="post" as="button">
                  <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </Link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import logo from '@/Assets/neda-logo.png'

const permissions = usePage().props.auth.permissions.map(p => p.name)
</script>

<style scoped>
.hover-bg-light:hover {
  background-color: #f8f9fa !important;
}
.hover-bg-primary:hover {
  background-color: var(--bs-primary) !important;
}
.hover-text-white:hover {
  color: white !important;
}
.hover-text-primary:hover {
  color: var(--bs-primary) !important;
  background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
}
.transition-all {
  transition: all 0.2s ease-in-out;
}
</style>
