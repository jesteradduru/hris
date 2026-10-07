<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import logo from '@/Assets/neda-logo.png'
import { computed } from 'vue'

const user = computed(() => usePage().props.auth.user)
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div class="container-fluid py-5 mt-4">
      <!-- Welcome Banner -->
      <div class="row mb-5">
        <div class="col-12">
          <div class="card shadow-sm border-0 rounded-4 bg-primary text-white p-4 p-md-5 position-relative overflow-hidden">
            <div class="position-absolute opacity-10" style="top: -50px; right: 5%; width: 300px; height: 300px; background: radial-gradient(circle, white, transparent); border-radius: 50%;"></div>
            <div class="row align-items-center position-relative z-1">
              <div class="col-md-9 col-lg-10">
                <h2 class="fw-bold mb-2">Welcome to HRIS{{ user ? ', ' + user.first_name : '' }}!</h2>
                <p class="fs-6 text-white-50 mb-0">Quickly access job vacancies, manage your applications, and update your profile from this portal.</p>
              </div>
              <div class="col-md-3 col-lg-2 d-none d-md-flex justify-content-end">
                <div class="bg-white p-3 rounded-circle shadow-sm" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                  <img :src="logo" class="img-fluid" style="max-height: 50px;" alt="HRIS Logo" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Links / Action Cards -->
      <div class="row g-4">
        <!-- Job Vacancies Link -->
        <div class="col-12 col-md-6 col-lg-4">
          <Link :href="route('recruitment.job_posting.index')" class="text-decoration-none">
            <div class="card h-100 shadow-sm border-0 rounded-4 hover-shadow transition-all">
              <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-suitcase fs-4"></i>
                  </div>
                  <i class="fa-solid fa-arrow-right text-muted opacity-25"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Job Vacancies</h5>
                <p class="text-muted small mb-0 mt-auto">Browse and search for available positions, view qualifications, and apply online.</p>
              </div>
            </div>
          </Link>
        </div>

        <!-- My Applications Link -->
        <div class="col-12 col-md-6 col-lg-4">
          <Link v-if="user" :href="route('job_application.index')" class="text-decoration-none">
            <div class="card h-100 shadow-sm border-0 rounded-4 hover-shadow transition-all">
              <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-file-signature fs-4"></i>
                  </div>
                  <i class="fa-solid fa-arrow-right text-muted opacity-25"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">My Applications</h5>
                <p class="text-muted small mb-0 mt-auto">View the current status of your submitted job applications and track progress.</p>
              </div>
            </div>
          </Link>
          <div v-else class="card h-100 shadow-sm border-0 rounded-4 opacity-75">
            <div class="card-body p-4 d-flex flex-column">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                  <i class="fa-solid fa-lock fs-4"></i>
                </div>
              </div>
              <h5 class="fw-bold text-dark mb-2">My Applications</h5>
              <p class="text-muted small mb-0 mt-auto">Please <Link :href="route('login')" class="text-primary fw-bold">Login</Link> to view and manage your job applications.</p>
            </div>
          </div>
        </div>

        <!-- Personal Data Sheet Link -->
        <div v-if="user" class="col-12 col-md-12 col-lg-4">
          <Link :href="route('profile.pds.personal_information.edit')" class="text-decoration-none">
            <div class="card h-100 shadow-sm border-0 rounded-4 hover-shadow transition-all">
              <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-address-card fs-4"></i>
                  </div>
                  <i class="fa-solid fa-arrow-right text-muted opacity-25"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Personal Data Sheet</h5>
                <p class="text-muted small mb-0 mt-auto">Update your PDS, including personal info, education, and work experience.</p>
              </div>
            </div>
          </Link>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.hover-shadow:hover {
  transform: translateY(-5px);
  box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.transition-all {
  transition: all 0.3s ease;
}
</style>
