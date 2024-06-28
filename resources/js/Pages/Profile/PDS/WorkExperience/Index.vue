<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <Link :href="route('profile.pds.work_experience.create')" class="btn btn-success">Add Work Experience</Link>
      <div class="table-responsive">
        <table class="table table-sm table-bordered mt-3">
          <thead>
            <tr>
              <th scope="col">FROM</th>
              <th scope="col">TO</th>
              <th scope="col">POSITION</th>
              <th scope="col">DEPARTMENT / AGENCY / OFFICE / COMPANY</th>
              <th scope="col">MONTHLY SALARY</th>
              <th scope="col">SALARY GRADE</th>
              <th scope="col">STATUS OF APPOINTMENT</th>
            </tr>
          </thead>
          <tbody v-if="props.work_experiences.data.length" style="text-transform: uppercase;">
            <tr v-for="work_experience in props.work_experiences.data" :key="work_experience.id">
              <td scope="row">{{ work_experience.inclusive_date_from }}</td>
              <td>
                {{ work_experience.inclusive_date_to }}
                <span v-if="work_experience.to_present">PRESENT</span>
              </td>
              <td>{{ work_experience.position_title }}</td>
              <td>{{ work_experience.dept_agency_office_company }}</td>
              <td>{{ work_experience.monthly_salary }}</td>
              <td>{{ work_experience.paygrade }}</td>
              <td>{{ work_experience.status_of_appointment }}</td>
              <td>
                <div class="d-flex gap-2">
                  <Link
                    class="btn btn-primary "
                    :href="route('profile.pds.work_experience.edit', { work_experience: work_experience.id })"
                    preserve-scroll
                  >
                    Edit
                  </Link>
                  <Link
                    as="button" class="btn btn-danger " method="delete"
                    :href="route('profile.pds.work_experience.destroy', { work_experience: work_experience.id })"
                    preserve-scroll
                  >
                    Delete
                  </Link>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="!props.work_experiences.data.length" class="text-center">No records to display</div>
      </div>
      <Pagination
        :links="props.work_experiences.links"
      />
      <div class="mb-3 d-flex gap-2 justify-content-end">
        <Link
          :href="route('profile.pds.civil_service_eligibility.index')" type="button"
          class="btn btn-dark"
        >
          <i class="fa-solid fa-arrow-left" />
        </Link>
        <Link
          :href="route('profile.pds.voluntary_work.index')" type="button"
          class="btn btn-dark"
        >
          <i class="fa-solid fa-arrow-right" />
        </Link>
      </div>
    </PDSLayout>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  work_experiences: Object,
})

</script>