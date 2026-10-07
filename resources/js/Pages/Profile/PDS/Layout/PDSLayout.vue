<template>
  <div class="mb-4">
    <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-3">
      <div>
        <h3 class="fw-bold text-dark mb-1">Personal Data Sheet</h3>
        <p class="text-muted mb-0 small">Update and manage your personal and professional information</p>
      </div>
      <!-- <div>
        <a class="btn btn-primary rounded-pill shadow-sm px-4 fw-medium" :href="route('pds.export')" target="_blank">
          <i class="fa-solid fa-download me-2"></i> Export PDS
        </a>
      </div> -->
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
      <div class="card-header bg-white border-bottom-0 p-0">
        <ul class="nav nav-tabs nav-fill pds-nav-tabs border-0" role="tablist">
          <li class="nav-item flex-fill" role="presentation">
            <Link
              preserve-state :href="route('profile.pds.personal_information.edit')" 
              class="nav-link py-3 fw-medium border-0 rounded-0"
              :class="{ 'active text-primary border-bottom border-primary border-3': route().current('profile.pds.personal_information.edit'), 'text-muted': !route().current('profile.pds.personal_information.edit') }"
            >
              <i class="fa-solid fa-user me-2"></i><span class="d-none d-md-inline">Personal Info</span>
              <i v-if="props.isFormDirty && route().current('profile.pds.personal_information.edit')" class="fa-solid fa-circle text-warning ms-1" style="font-size: 0.5rem;" />
            </Link>
          </li>

          <li class="nav-item flex-fill" role="presentation">
            <Link
              preserve-state :href="route('profile.pds.family_background.edit')" 
              class="nav-link py-3 fw-medium border-0 rounded-0"
              :class="{ 'active text-primary border-bottom border-primary border-3': route().current('profile.pds.family_background.edit'), 'text-muted': !route().current('profile.pds.family_background.edit') }"
            >
              <i class="fa-solid fa-users me-2"></i><span class="d-none d-md-inline">Family</span>
              <i v-if="props.isFormDirty && route().current('profile.pds.family_background.edit')" class="fa-solid fa-circle text-warning ms-1" style="font-size: 0.5rem;" />
            </Link>
          </li>

          <li class="nav-item flex-fill" role="presentation">
            <Link
              preserve-state :href="route('profile.pds.educational_background.edit')" 
              class="nav-link py-3 fw-medium border-0 rounded-0"
              :class="{ 'active text-primary border-bottom border-primary border-3': route().current('profile.pds.educational_background.*'), 'text-muted': !route().current('profile.pds.educational_background.*') }"
            >
              <i class="fa-solid fa-graduation-cap me-2"></i><span class="d-none d-md-inline">Education</span>
              <i v-if="props.isFormDirty && route().current('profile.pds.educational_background.edit')" class="fa-solid fa-circle text-warning ms-1" style="font-size: 0.5rem;" />
            </Link>
          </li>

          <li class="nav-item flex-fill" role="presentation">
            <Link
              preserve-state :href="route('profile.pds.civil_service_eligibility.index')" 
              class="nav-link py-3 fw-medium border-0 rounded-0"
              :class="{ 'active text-primary border-bottom border-primary border-3': route().current('profile.pds.civil_service_eligibility.*'), 'text-muted': !route().current('profile.pds.civil_service_eligibility.*') }"
            >
              <i class="fa-solid fa-certificate me-2"></i><span class="d-none d-md-inline">Eligibility</span>
            </Link>
          </li>

          <li class="nav-item flex-fill" role="presentation">
            <Link
              preserve-state :href="route('profile.pds.work_experience.index')" 
              class="nav-link py-3 fw-medium border-0 rounded-0"
              :class="{ 'active text-primary border-bottom border-primary border-3': route().current('profile.pds.work_experience.*'), 'text-muted': !route().current('profile.pds.work_experience.*') }"
            >
              <i class="fa-solid fa-briefcase me-2"></i><span class="d-none d-md-inline">Experience</span>
            </Link>
          </li>

          <li class="nav-item flex-fill" role="presentation">
            <Link
              preserve-state :href="route('profile.pds.voluntary_work.index')" 
              class="nav-link py-3 fw-medium border-0 rounded-0"
              :class="{ 'active text-primary border-bottom border-primary border-3': route().current('profile.pds.voluntary_work.*'), 'text-muted': !route().current('profile.pds.voluntary_work.*') }"
            >
              <i class="fa-solid fa-hand-holding-heart me-2"></i><span class="d-none d-md-inline">Voluntary</span>
            </Link>
          </li>

          <li class="nav-item flex-fill" role="presentation">
            <Link
              preserve-state :href="route('profile.pds.learning_and_development.index')" 
              class="nav-link py-3 fw-medium border-0 rounded-0"
              :class="{ 'active text-primary border-bottom border-primary border-3': route().current('profile.pds.learning_and_development.*'), 'text-muted': !route().current('profile.pds.learning_and_development.*') }"
            >
              <i class="fa-solid fa-book-open-reader me-2"></i><span class="d-none d-lg-inline">L&D</span>
            </Link>
          </li>

          <li class="nav-item flex-fill" role="presentation">
            <Link
              preserve-state :href="route('profile.pds.other_information.index')" 
              class="nav-link py-3 fw-medium border-0 rounded-0"
              :class="{ 'active text-primary border-bottom border-primary border-3': route().current('profile.pds.other_information.*') || route().current('profile.pds.non_academic_distinctions.*') || route().current('profile.pds.reference_id.*'), 'text-muted': !(route().current('profile.pds.other_information.*') || route().current('profile.pds.non_academic_distinctions.*') || route().current('profile.pds.reference_id.*')) }"
            >
              <i class="fa-solid fa-circle-info me-2"></i><span class="d-none d-lg-inline">Others</span>
            </Link>
          </li>
        </ul>
      </div>
      <div class="card-body p-4 bg-light bg-opacity-50">
        <div id="pds" class="container-fluid px-0">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  isFormDirty: Boolean,
})

</script>

<style scoped>
.pds-nav-tabs .nav-link {
  transition: all 0.2s ease-in-out;
  background-color: transparent;
}
.pds-nav-tabs .nav-link:hover:not(.active) {
  background-color: rgba(0,0,0,0.02);
  color: var(--bs-primary) !important;
}
</style>
