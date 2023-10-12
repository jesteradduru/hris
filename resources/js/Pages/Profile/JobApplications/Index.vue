<template>
  <ProfileLayout>
    <template #header>
      <h3>My Job Applications</h3>
    </template>
    <div class="table-responsive">
      <table class="table table-compact table-hover table-striped">
        <thead>
          <tr>
            <th scope="col">Position</th>
            <th scope="col">Status</th>
            <th scope="col">Files</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="application in job_applications" :key="application.id" class="">
            <td scope="row">{{ application.job_posting.position }}</td>
            <td>Pending</td>
            <td>
              <span v-for="file in application.document" :key="file.id"><a :href="file.src" target="_blank">{{ file.filename }}</a></span>
            </td>
            <td>
              <div class="d-flex gap-2">
                <button class="btn btn-success btn-sm"><i class="fa-solid fa-pencil" /></button>
                <Link method="delete" as="button" :href="route('job_application.destroy', {job_application: application.id})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash" /></Link>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </ProfileLayout>
</template>

<script setup>
import ProfileLayout from '@/Pages/Profile/Layout/ProfileLayout.vue'
import { Link } from '@inertiajs/vue3'
const props = defineProps({
  job_applications: Array,
})
</script>