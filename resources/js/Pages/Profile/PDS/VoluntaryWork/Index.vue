<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <Link :href="route('profile.pds.voluntary_work.create')" class="btn btn-success">Add Voluntary Work</Link>
      <div class="table-responsive">
        <table class="table table-sm table-bordered mt-3">
          <thead>
            <tr>
              <th scope="col">NAME & ADDRESS OF ORGANIZATION</th>
              <th scope="col">FROM</th>
              <th scope="col">TO</th>
              <th scope="col">NUMBER OF HOURS</th>
              <th scope="col">POSITION/NATURE OF WORK</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody v-if="props.voluntary_works.data.length" style="text-transform: uppercase;">
            <tr v-for="voluntary_work in props.voluntary_works.data" :key="voluntary_work.id">
              <td scope="row">{{ voluntary_work.name_address_of_org }}</td>
              <td>{{ voluntary_work.inclusive_date_from }}</td>
              <td>{{ voluntary_work.inclusive_date_to }}</td>
              <td>{{ voluntary_work.number_of_hours }}</td>
              <td>{{ voluntary_work.position_work }}</td>
              <td>
                <div class="d-flex gap-2">
                  <Link
                    class="btn btn-primary "
                    :href="route('profile.pds.voluntary_work.edit', { voluntary_work: voluntary_work.id })"
                    preserve-scroll
                  >
                    Edit
                  </Link>
                  <Link
                    as="button" class="btn btn-danger " method="delete"
                    :href="route('profile.pds.voluntary_work.destroy', { voluntary_work: voluntary_work.id })"
                    preserve-scroll
                  >
                    Delete
                  </Link>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="!props.voluntary_works.data.length" class="text-center">No records to display</div>
      </div>
      <div class="mb-3 d-flex gap-2 justify-content-end">
        <Link
          :href="route('profile.pds.work_experience.index')" type="button"
          class="btn btn-dark"
        >
          <i class="fa-solid fa-arrow-left" />
        </Link>
        <Link
          :href="route('profile.pds.learning_and_development.index')" type="button"
          class="btn btn-dark"
        >
          <i class="fa-solid fa-arrow-right" />
        </Link>
      </div>
      <Pagination
        v-if="props.voluntary_works.data.length > 10"
        :links="props.voluntary_works.links"
      />
    </PDSLayout>
  </AuthenticatedLayout>
</template>
  
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
  
const props = defineProps({
  voluntary_works: Object,
})
  
</script>