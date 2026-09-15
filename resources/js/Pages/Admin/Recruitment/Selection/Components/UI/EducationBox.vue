<template>
  <div v-for="course in courses" :id="`course${course.id}`" :key="course.id" class="col-md-6 col-lg-4 mb-3">
    <div class="card h-100 border-0 shadow-sm rounded-3 bg-light position-relative">
      <div class="card-body p-3 text-start d-flex flex-column justify-content-between">
        <div>
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill">
              <i class="fa-solid fa-graduation-cap me-1" />Degree / Course
            </span>
            <Link
              as="button" 
              class="btn btn-outline-danger btn-xs rounded-circle p-1 d-inline-flex align-items-center justify-content-center" 
              style="width: 24px; height: 24px;"
              method="delete"
              preserve-scroll
              :onBefore="confirm"
              :href="route('profile.pds.educational_background.college_graduate_study.destroy', {
                college_graduate_study: course.id
              })"
              title="Delete Record"
            >
              <i class="fa-solid fa-xmark" style="font-size: 11px;" />
            </Link>
          </div>

          <h6 class="fw-bold text-dark mb-1 text-uppercase">{{ course.basic_ed_degree_course }}</h6>
          <span v-if="course.highest_lvl_units_earned" class="badge bg-warning-subtle text-dark border mb-2 extra-small">
            {{ course.highest_lvl_units_earned }} Units Earned
          </span>

          <div class="text-secondary small mb-2 d-flex align-items-center gap-1">
            <i class="fa-solid fa-school text-muted" />
            <span>{{ course.name_of_school }}</span>
          </div>

          <div class="extra-small text-muted mb-2">
            <i class="fa-regular fa-calendar me-1" />
            <span>{{ course.period_from }}</span>
            <span v-if="course.period_to"> - {{ course.period_to }}</span>
          </div>

          <div v-if="course.academic_award && course.academic_award.length > 0" class="mb-2">
            <small class="text-uppercase text-muted fw-bold extra-small d-block mb-1">Awards</small>
            <div class="d-flex flex-wrap gap-1">
              <span v-for="award in course.academic_award" :key="award.id" class="badge bg-success-subtle text-success border extra-small">
                <i class="fa-solid fa-trophy me-1" />{{ award.title }}
              </span>
            </div>
          </div>
        </div>

        <div class="border-top pt-2 mt-2">
          <small class="text-uppercase text-muted fw-bold extra-small d-block mb-1">Attachments</small>
          <div v-if="course.files && course.files.length > 0" class="d-flex flex-wrap gap-1">
            <a 
              v-for="file in course.files" 
              :key="file.id" 
              target="_blank" 
              :href="file.src"
              class="badge bg-white text-primary border text-decoration-none hover-shadow-sm extra-small d-inline-flex align-items-center gap-1 p-1"
            >
              <i class="fa-solid fa-paperclip" />
              <span class="text-truncate" style="max-width: 120px;">{{ file.filename }}</span>
            </a>
          </div>
          <span v-else class="text-muted extra-small italic">No attachments</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  courses: Array,
})

const confirm = () => window.confirm('Are you sure?')

</script>