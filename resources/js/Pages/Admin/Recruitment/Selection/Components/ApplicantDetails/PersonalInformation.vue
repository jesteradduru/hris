<template>
  <Box id="personal" class="mb-4 shadow-sm border-0 rounded-3">
    <template #header>
      <div class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-address-card text-primary" />
        <span>Personal Information</span>
      </div>
    </template>
    <div class="row align-items-start g-4 p-2">
      <!-- Profile Picture Column -->
      <div class="col-md-4 col-lg-3 text-center">
        <div class="d-inline-block position-relative p-1 bg-white rounded-circle shadow-sm border">
          <img v-if="applicant.profile_pic" class="profile-pic pic-md rounded-circle shadow-sm" :src="applicant.profile_pic" alt="Applicant Photo" />
          <img v-else class="profile-pic pic-md rounded-circle shadow-sm" src="@/Assets/profile.png" alt="Applicant Photo" />
        </div>
        <h5 class="fw-bold text-dark mt-3 mb-1 text-uppercase">{{ applicant.name }}</h5>
        <span class="badge bg-light text-primary border rounded-pill px-3 py-1 small">
          <i class="fa-solid fa-user-check me-1" />Applicant
        </span>
      </div>

      <!-- Information Details Column -->
      <div class="col-md-8 col-lg-9">
        <div class="bg-light p-3 rounded-3 border">
          <div class="row g-3">
            <div class="col-sm-6">
              <div class="d-flex align-items-start gap-2">
                <i class="fa-solid fa-calendar-days text-primary mt-1" />
                <div>
                  <small class="text-uppercase text-muted fw-bold extra-small d-block">Date of Birth</small>
                  <span class="fw-semibold text-dark">
                    {{ applicant.personal_information?.date_of_birth ? moment(applicant.personal_information.date_of_birth).format('MMM D, YYYY') : 'N/A' }}
                  </span>
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="d-flex align-items-start gap-2">
                <i class="fa-solid fa-venus-mars text-primary mt-1" />
                <div>
                  <small class="text-uppercase text-muted fw-bold extra-small d-block">Sex</small>
                  <span class="fw-semibold text-dark text-capitalize">
                    {{ applicant.personal_information?.sex || 'N/A' }}
                  </span>
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="d-flex align-items-start gap-2">
                <i class="fa-solid fa-ring text-primary mt-1" />
                <div>
                  <small class="text-uppercase text-muted fw-bold extra-small d-block">Civil Status</small>
                  <span class="fw-semibold text-dark text-capitalize">
                    {{ applicant.personal_information?.civil_status || 'N/A' }}
                  </span>
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="d-flex align-items-start gap-2">
                <i class="fa-solid fa-location-dot text-primary mt-1" />
                <div>
                  <small class="text-uppercase text-muted fw-bold extra-small d-block">Address</small>
                  <span class="fw-semibold text-dark">
                    {{ applicant.personal_information?.address || 'N/A' }}
                  </span>
                </div>
              </div>
            </div>

            <div class="col-12 border-top pt-3 mt-3">
              <small class="text-uppercase text-muted fw-bold extra-small d-block mb-2">Contact Details</small>
              <div class="d-flex flex-wrap gap-4">
                <div v-if="applicant.personal_information?.mobile_number" class="d-flex align-items-center gap-2 small text-dark">
                  <i class="fa-solid fa-mobile-screen text-primary" />
                  <span>{{ applicant.personal_information.mobile_number }}</span>
                </div>
                <div v-if="applicant.personal_information?.telephone_number" class="d-flex align-items-center gap-2 small text-dark">
                  <i class="fa-solid fa-phone text-primary" />
                  <span>{{ applicant.personal_information.telephone_number }}</span>
                </div>
                <div v-if="applicant.personal_information?.email_address" class="d-flex align-items-center gap-2 small text-dark">
                  <i class="fa-solid fa-envelope text-primary" />
                  <span style="text-transform: lowercase;">{{ applicant.personal_information.email_address }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Box>
</template>

<script setup>
import moment from 'moment'
import Box from '../UI/Box.vue'
const prop = defineProps({
  applicant: Object,
})
</script>