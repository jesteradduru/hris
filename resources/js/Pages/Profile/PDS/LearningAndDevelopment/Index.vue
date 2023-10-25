<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <Link :href="route('profile.pds.learning_and_development.create')" class="btn btn-success">Add</Link>
      <div class="table-responsive">
        <table class="table table-sm table-bordered mt-3">
          <thead>
            <tr>
              <th scope="col">LEARNING AND DEVELOPMENT</th>
              <th scope="col">FROM</th>
              <th scope="col">TO</th>
              <th scope="col">NUMBER OF HOURS</th>
              <th scope="col">TYPE OF LD</th>
              <th>CONDUCTED/ SPONSORED BY</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody v-if="props.learning_and_development.data.length" style="text-transform: uppercase;">
            <tr v-for="learning in props.learning_and_development.data" :key="learning.id">
              <td scope="row">{{ learning.title_of_learning }}</td>
              <td>{{ learning.inclusive_date_from }}</td>
              <td>{{ learning.inclusive_date_to }}</td>
              <td>{{ learning.number_of_hours }}</td>
              <td>{{ learning.type_of_ld }}</td>
              <td>{{ learning.conducted_sponsored_by }}</td>
              <td>
                <div class="d-flex gap-2">
                  <Link
                    class="btn btn-primary "
                    :href="route('profile.pds.learning_and_development.edit', { learning_and_development: learning.id })"
                    preserve-scroll
                  >
                    Edit
                  </Link>
                  <Link
                    as="button" class="btn btn-danger " method="delete"
                    :href="route('profile.pds.learning_and_development.destroy', { learning_and_development: learning.id })"
                    preserve-scroll
                    :onBefore="confirm"
                  >
                    Delete
                  </Link>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="!props.learning_and_development.data.length" class="text-center">No records to display</div>
      </div>
      <div class="mb-3 d-flex gap-2 justify-content-end">
        <Link
          :href="route('profile.pds.voluntary_work.index')" type="button"
          class="btn btn-dark"
        >
          <i class="fa-solid fa-arrow-left" />
        </Link>
        <Link
          :href="route('profile.pds.other_information.index')" type="button"
          class="btn btn-dark"
        >
          <i class="fa-solid fa-arrow-right" />
        </Link>
      </div>
      <Pagination
        v-if="props.learning_and_development.data.length > 10"
        :links="props.learning_and_development.links"
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
  learning_and_development: Object,
})

const confirm = () => window.confirm('Are you sure to delete this training?')
    
</script>