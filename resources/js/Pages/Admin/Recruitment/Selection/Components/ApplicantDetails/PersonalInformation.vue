<template>
  <Box class="mb-3">
    <template #header>Personal Information</template>
    <dl>
      <dt>
        Name
      </dt>
      <dd>{{ applicant.name }}</dd>
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
</template>

<script setup>
import moment from 'moment'
import Box from '../UI/Box.vue'
const prop = defineProps({
  applicant: Object,
})
</script>