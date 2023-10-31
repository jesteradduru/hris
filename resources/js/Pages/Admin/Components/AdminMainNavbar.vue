<template>
  <nav class="navbar navbar-expand-sm bg-light shadow-sm navbar-light" style="text-transform: uppercase;">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">HRIS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon" />
      </button>
      <div id="collapsibleNavbar" class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li v-if="permissions.includes('View Reward Page')" class="nav-item">
            <Link
              class="nav-link" :href="route('admin.rewards.index')" :class="{
                active: route().current(
                  'admin.rewards.*'
                )
              }"
            >
              Rewards and Recognition
            </Link>
          </li>
          <li class="nav-item">
            <Link
              class="nav-link" :href="route('admin.employees.index')" :class="{
                active: route().current(
                  'admin.employees.*'
                )
              }"
            >
              Employees
            </Link>
          </li>
          <li v-if="permissions.includes('View Recruitment, Selection and Placement Page')" class="nav-item">
            <Link
              class="nav-link" :href="route('admin.recruitment.job_posting.index')" :class="{
                active: route().current(
                  'admin.recruitment.job_posting.*'
                )
              }"
            >
              Recruitment, Selection and Placement
            </Link>
          </li>
          <li v-if="permissions.includes('View Recruitment, Selection and Placement Page')" class="nav-item">
            <Link
              class="nav-link" :href="route('admin.lnd.index')" :class="{
                active: route().current(
                  'admin.lnd.*'
                ) || route().current(
                  'admin.idp.*'
                ) || route().current(
                  'admin.lnd.*'
                )
              }"
            >
              Learning and Development
            </Link>
          </li>
          <li v-if="permissions.includes('View Roles and Permissions Page')" class="nav-item dropdown">
            <Link
              class="nav-link" :href="route('admin.role_permission.role.index')" :class="{
                active: route().current(
                  'admin.role_permission.*'
                )
              }"
            >
              Roles and Permissions
            </Link>
          </li>
          <li class="nav-item dropdown">
            <Link
              class="nav-link" :href="route('admin.spms.index')" :class="{
                active: route().current(
                  'admin.spms.*'
                )
              }"
            >
              SPMS
            </Link>
          </li>
          <li class="nav-item dropdown">
            <Link
              class="nav-link" :href="route('admin.daily_time_record.index')" :class="{
                active: route().current(
                  'admin.daily_time_record.*'
                )
              }"
            >
              Daily Time Record
            </Link>
          </li>
        </ul>
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{
            $page.props.auth.user.name }}</a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <Link class="dropdown-item" :href="route('profile.index')">Profile</Link>
            </li>
            <li>
              <Link class="dropdown-item" :href="route('dashboard')">Main</Link>
            </li>
            <li>
              <Link class="dropdown-item" :href="route('logout')" method="post" as="button">Logout</Link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'

const permissions = usePage().props.auth.permissions.map(p => p.name)
</script>
