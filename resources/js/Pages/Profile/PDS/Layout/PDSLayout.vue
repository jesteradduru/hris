<template>
  <div class="tabbable">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <Link
          preserve-state :href="route('profile.pds.personal_information.edit')" class="nav-link"
          :class="{ active: route().current('profile.pds.personal_information.edit') }"
        >
          Personal Information
          <i v-if="props.isFormDirty && route().current('profile.pds.personal_information.edit')" class="bi-record-fill text-secondary" />
        </Link>
      </li>


      <li class="nav-item">
        <Link
          preserve-state :href="route('profile.pds.family_background.edit')" class="nav-link"
          :class="{ active: route().current('profile.pds.family_background.edit') }"
        >
          Family Background
          <i v-if="props.isFormDirty && route().current('profile.pds.family_background.edit')" class="bi-record-fill text-secondary" />
        </Link>
      </li>


      <li class="nav-item">
        <Link
          preserve-state :href="route('profile.pds.educational_background.edit')" class="nav-link"
          :class="{ active: route().current('profile.pds.educational_background.*') }"
        >
          Educational Background
          <i v-if="props.isFormDirty && route().current('profile.pds.educational_background.edit')" class="bi-record-fill text-secondary" />
        </Link>
      </li>


      <li class="nav-item">
        <Link
          preserve-state :href="route('profile.pds.civil_service_eligibility.index')" class="nav-link"
          :class="{ active: route().current('profile.pds.civil_service_eligibility.*') }"
        >
          Eligibility
        </Link>
      </li>


      <li class="nav-item">
        <Link
          preserve-state :href="route('profile.pds.work_experience.index')" class="nav-link"
          :class="{ active: route().current('profile.pds.work_experience.*') }"
        >
          Work Experience
        </Link>
      </li>


      <li class="nav-item">
        <Link
          preserve-state :href="route('profile.pds.voluntary_work.index')" class="nav-link"
          :class="{ active: route().current('profile.pds.voluntary_work.*') }"
        >
          Voluntary Work
        </Link>
      </li>


      <li class="nav-item">
        <Link
          preserve-state :href="route('profile.pds.learning_and_development.index')" class="nav-link"
          :class="{ active: route().current('profile.pds.learning_and_development.*') }"
        >
          Learning and Development
        </Link>
      </li>


      <li class="nav-item">
        <Link
          preserve-state :href="route('profile.pds.non_academic_distinctions.index')" class="nav-link"
          :class="{ active: route().current('profile.pds.non_academic_distinctions.*') }"
        >
          NON-ACADEMIC DISTINCTIONS / RECOGNITION
        </Link>
      </li>

      <li class="nav-item">
        <Link
          preserve-state :href="route('profile.pds.other_information.index')" class="nav-link"
          :class="{ active: route().current('profile.pds.other_information.*') }"
        >
          Other Information
        </Link>
      </li>


      <li class="nav-item">
        <Link
          preserve-state :href="route('profile.pds.page_four_questions.edit')" class="nav-link"
          :class="{ active: route().current('profile.pds.page_four_questions.*') }"
        >
          Questions
          <i v-if="props.isFormDirty && route().current('profile.pds.page_four_questions.*')" class="bi-record-fill text-secondary" />
        </Link>
      </li>


      <li class="nav-item">
        <Link
          preserve-state :href="route('profile.pds.reference_id.index')" class="nav-link"
          :class="{ active: route().current('profile.pds.reference_id.*') }"
        >
          References and ID
          <i v-if="props.isFormDirty && route().current('profile.pds.reference_id.*')" class="bi-record-fill text-secondary" />
        </Link>
      </li>
    </ul>
    <hr />
    <div id="pds" class="container">
      <div class="d-flex justify-content-end">
        <a class="btn btn-secondary" :href="route('pds.export')" target="_blank">Export</a>
      </div>
      <slot />
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  isFormDirty: Boolean,
})

</script>
