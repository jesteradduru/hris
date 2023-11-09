<template>
  <RecruitmentLayout>
    <Link class="btn btn-secondary btn-sm mb-3" :href="route('admin.recruitment.plantilla.index')"><i class="fa-solid fa-arrow-left" /></Link>
    <div class="mb-3">
      <label for="" class="form-label">Plantilla Name</label>
      <input
        id=""
        type="text" class="form-control" name="" aria-describedby="helpId" placeholder="" value="Information Systems Analyst 1"
      />
    </div>
    <div class="mb-3">
      <label for="" class="form-label">Division</label>
      <select id="" class="form-select form-select-lg" name="">
        <option selected>FAD</option>
        <option value="">New Delhi</option>
        <option value="">Istanbul</option>
        <option value="">Jakarta</option>
      </select>
    </div>
    <h5>Rank Rules for Recruitment and Selection</h5>
    <Link :href="route('admin.recruitment.plantilla.rule.create', {plantilla: 1})" class="btn btn-primary mb-3">Add rule</Link>
    <ul class="list-group">
      <li class="list-group-item d-flex justify-content-between">
        <span>Rewards and Recognition</span>
        <div class="d-flex">
          <button class="btn btn-success btn-sm"><i class="fa-solid fa-pen" /></button>
          <button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash" /></button>
        </div>
      </li>
    </ul>
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import { Link } from '@inertiajs/vue3'
</script>