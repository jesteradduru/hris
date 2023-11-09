<template>
  <RecruitmentLayout>
    <Link :href="route('admin.recruitment.plantilla.create')" class="btn btn-primary mb-3">Add Plantilla Position</Link>
    <div class="table-responsive">
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th scope="col">Position</th>
            <th scope="col">Item</th>
            <th scope="col">Division</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr class="">
            <td scope="row">Information Systems Analyst 1</td>
            <td>R1C2</td>
            <td>Finance Administrative Division</td>
            <td><Link :href="route('admin.recruitment.plantilla.edit', {plantilla: 1})"><i class="fa-solid fa-pen" />Edit</Link></td>
          </tr>
          <tr class="">
            <td scope="row">Information Systems Analyst 1</td>
            <td>R1C2</td>
            <td>Finance Administrative Division</td>
            <td><Link :href="route('admin.recruitment.plantilla.edit', {plantilla: 1})"><i class="fa-solid fa-pen" />Edit</Link></td>
          </tr>
        </tbody>
      </table>
    </div>
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import { Link } from '@inertiajs/vue3'
</script>