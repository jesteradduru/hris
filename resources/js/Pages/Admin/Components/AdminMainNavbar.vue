<template>
  <nav class="navbar navbar-expand-sm bg-primary text-light navbar-dark shadow mb-4 mt-2 rounded" style="text-transform: uppercase;">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">HRIS</a>
      <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon">
          <i class="fa-solid fa-bars" />
        </span>
      </button>
      <div id="collapsibleNavbar" class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">HRIS MODULES</a>
            <ul class="dropdown-menu shadow">
              <li v-if="permissions.includes('View Recruitment, Selection and Placement Page')">
                <Link
                  class="dropdown-item" :href="route('admin.recruitment.plantilla.index')" :class="{
                    active: route().current(
                      'admin.recruitment.job_posting.*'
                    )
                  }"
                >
                  Recruitment, Selection and Placement
                </Link>
              </li>
              <li v-if="permissions.includes('View Recruitment, Selection and Placement Page')">
                <Link
                  class="dropdown-item" :href="route('admin.lnd.index')" :class="{
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
              <li>
                <Link
                  class="dropdown-item" :href="route('admin.spms.index')" :class="{
                    active: route().current(
                      'admin.spms.*'
                    )
                  }"
                >
                  Performance Management
                </Link>
              </li>

              <li v-if="permissions.includes('View Reward Page')">
                <Link
                  class="dropdown-item" :href="route('admin.rewards.index')" :class="{
                    active: route().current(
                      'admin.rewards.*'
                    )
                  }"
                >
                  Rewards and Recognition
                </Link>
              </li>
            </ul>
          </li>

          <!-- <li v-if="permissions.includes('View Recruitment, Selection and Placement Page')" class="nav-item">
            <Link
              class="nav-link" :href="route('admin.recruitment.job_posting.index')" :class="{
                active: route().current(
                  'admin.recruitment.job_posting.*'
                )
              }"
            >
              Recruitment, Selection and Placement
            </Link>
          </li> -->

          <!-- <li v-if="permissions.includes('View Recruitment, Selection and Placement Page')" class="nav-item">
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
          </li> -->
          
          <!-- <li class="nav-item">
            <Link
              class="nav-link" :href="route('admin.spms.index')" :class="{
                active: route().current(
                  'admin.spms.*'
                )
              }"
            >
              Performance Management
            </Link>
          </li> -->


          <!-- <li v-if="permissions.includes('View Reward Page')" class="nav-item">
            <Link
              class="nav-link" :href="route('admin.rewards.index')" :class="{
                active: route().current(
                  'admin.rewards.*'
                )
              }"
            >
              Rewards and Recognition
            </Link>
          </li> -->




          <li class="nav-item">
            <Link
              class="nav-link" :href="route('admin.employees.index')" :class="{
                active: route().current(
                  'admin.employees.*'
                )
              }"
            >
              Accounts
            </Link>
          </li>
          
          
          <li v-if="permissions.includes('View Roles and Permissions Page')" class="nav-item">
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

          <li class="nav-item">
            <Link
              class="nav-link" :href="route('admin.reports.index')" :class="{
                active: route().current(
                  'admin.reports.*'
                )
              }"
            >
              Reports
            </Link>
          </li>
          
          <li class="nav-item">
            <Link
              class="nav-link" :href="route('admin.dtr.dtr.index')" :class="{
                active: route().current(
                  'admin.dtr.*'
                )
              }"
            >
              Daily Time Record
            </Link>
          </li>
        </ul>
        <div v-if="$page.props.auth.user ">
          <img v-if="$page.props.auth.user.profile_pic" class="profile-pic-nav rounded-circle shadow me-2" :src="$page.props.auth.user.profile_pic" alt="" />
          <img v-else class="profile-pic-nav rounded-circle  me-2" src="../../../Assets/profile.png" alt="" />
        </div>
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{
            $page.props.auth.user.name }}</a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <Link class="dropdown-item" :href="route('profile.edit')">Profile</Link>
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
