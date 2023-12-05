<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <Link :href="route('profile.pds.non_academic_distinctions.create')" class="btn btn-success">Add Award</Link>
      <div class="table-responsive">
        <table class="table table-sm mt-3">
          <thead>
            <tr>
              <th scope="col">NON-ACADEMIC DISTINCTIONS / RECOGNITION / AWARD</th>
              <th scope="col">DEPARTMENT / AGENCY / OFFICE / COMPANY</th>
              <th scope="col">DATE AWARDED</th>
              <th scope="col">DOCUMENT</th>
              <th scope="col">ACTION</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="distinction in distinctions.data" :key="distinction.id">
              <td>{{ distinction.title }}</td>
              <td>{{ distinction.office }}</td>
              <td>{{ distinction.date_awarded ? moment(distinction.date_awarded).format('MMM D, Y') : '' }}</td>
              <td>
                <ul>
                  <li v-for="file in distinction.files" :key="file.id">
                    <a target="_blank" :href="file.src">{{ file.filename }}</a>
                  </li>
                </ul>
              </td>
              <td>
                <div class="d-flex gap-2">
                  <Link
                    class="btn btn-primary btn-sm"
                    :href="route('profile.pds.non_academic_distinctions.edit', { non_academic_distinction: distinction.id })"
                    preserve-scroll
                  >
                    <i class="fa-solid fa-pen" />
                  </Link>
                  <Link
                    as="button" class="btn btn-danger btn-sm" method="delete"
                    :href="route('profile.pds.non_academic_distinctions.destroy', { non_academic_distinction: distinction.id })"
                    preserve-scroll
                    :onBefore="confirm"
                  >
                    <i class="fa-solid fa-trash" />
                  </Link>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <Pagination :links="distinctions.links" />
    </PDSLayout>
  </AuthenticatedLayout>
</template>
      
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'
import BulletedList from '@/Components/BulletedList.vue'
import { computed } from 'vue'
import Pagination from '@/Components/Pagination.vue'
import moment from 'moment'
      
const props = defineProps({
  distinctions: Object,
})

const confirm = () => window.confirm('Do you really want to delete this?')
      
</script>