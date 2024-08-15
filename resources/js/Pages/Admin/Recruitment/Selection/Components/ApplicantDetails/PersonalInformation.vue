<template>
  <Box id="personal" class="mb-3">
    <template #header>Personal Information</template>
    <div class="d-flex gap-5">
      <!-- first col -->
      <div>
        <img v-if="applicant.profile_pic" class="profile-pic pic-md rounded-circle shadow mb-3" :src="applicant.profile_pic" alt="" />
        <img v-else class="profile-pic pic-md rounded-circle shadow mb-3" src="@/Assets/profile.png" alt="" />
      </div>
      <!-- 2nd col -->

      <Box class="container-fluid shadow-none border-0">
        <template #header><dd>{{ applicant.name }}</dd></template>
        <dl class="applicant_details">
          <dt>Date of Birth:</dt>
          <dd>{{ moment(applicant.personal_information.date_of_birth).format('MMM D, YYYY') }}</dd>
          <dt>Sex:</dt>
          <dd>{{ applicant.personal_information.sex }}</dd>
          <dt>Civil Status:</dt>
          <dd>{{ applicant.personal_information.civil_status }}</dd>
          <dt>Address:</dt>
          <dd>{{ applicant.personal_information.address }}</dd>
          <dt>Contact:</dt>
          <dd><i class="fa-solid fa-mobile" />&nbsp;{{ applicant.personal_information.mobile_number }}</dd>
          <dd><i class="fa-solid fa-phone" />&nbsp;{{ applicant.personal_information.telephone_number }}</dd>
          <dd style="text-transform: lowercase;"><i class="fa-solid fa-envelope" />&nbsp;{{ applicant.personal_information.email_address }}</dd>
        </dl>
      </Box>
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