<template>
  <RecruitmentLayout>
    <Link :href="route('admin.recruitment.plantilla.create')" class="btn btn-primary mb-3">Add Plantilla Position</Link>
    <div class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th scope="col">Plantilla</th>
            <th scope="col">Item No</th>
            <th scope="col">Division</th>
            <th scope="col">Employee</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="position in positions.data" :key="position.id" class="">
            <td scope="row">{{ position.position }}</td>
            <td>{{ position.plantilla_item_no }}</td>
            <td>{{ position.division?.name }}</td>
            <td>{{ position.user?.name }}</td>
            <td class="d-flex ">
              <Link class="btn btn-success btn-sm" :href="route('admin.recruitment.plantilla.edit', {plantilla: position.id })"><i class="fa-solid fa-pen" /></Link>
              <Link :onBefore="confirm" as="button" method="delete" class="btn btn-danger btn-sm" :href="route('admin.recruitment.plantilla.destroy', {plantilla: position.id })"><i class="fa-solid fa-trash" /></Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <Pagination :links="positions.links" />
  </RecruitmentLayout>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue'
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  positions: Object,
})

const confirm = () => window.confirm('Are you sure to delete this plantilla?')
</script>