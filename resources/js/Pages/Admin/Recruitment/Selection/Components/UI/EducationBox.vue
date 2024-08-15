<template>
  <div v-for="course in courses" :id="`course${course.id}`" :key="course.id" class="col-4 mb-3">
    <div class="text-center education-box card h-100">
      <div class="card-body">
        <b class="mb-2">{{ course.basic_ed_degree_course }} <span v-if="course.highest_lvl_units_earned" class="mb-2">, {{ course.highest_lvl_units_earned }} Units Earned</span></b>
        <div class="mb-2">{{ course.name_of_school }}</div>
        <div class="mb-2"><i>from</i> <b>{{ course.period_from }}</b> <i>to</i> <b v-if="course.period_to">{{ course.period_to }}</b></div>
        <div v-if="course.academic_award.length > 0" class="mb-2">
          <ul>
            <li v-for="award in course.academic_award" :key="award.id">
              <span>{{ award.title }}</span>
            </li>
          </ul>
        </div>
        <div class="mb-2">
          <div>
            <small>Attachments: </small>
          </div>
          <div v-if="course.files.length > 0">
            <span v-for="file in course.files" :key="file.id">
              <a target="_blank" :href="file.src"><i class="fa-solid fa-paperclip" /> &nbsp;{{ file.filename }}</a> <span v-if="course.files.length > 1">,&nbsp;</span>
            </span>
          </div>
          <div v-else>
            <a href="#">NONE</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Box from '../UI/Box.vue'

const props = defineProps({
  courses: Array,
})

</script>