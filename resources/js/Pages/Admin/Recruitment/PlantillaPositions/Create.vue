<template>
  <RecruitmentLayout>
    <Link class="btn btn-secondary btn-sm mb-3" :href="route('admin.recruitment.plantilla.index')"><i class="fa-solid fa-arrow-left" /></Link>
    <div class="mb-3">
      <label for="" class="form-label">Plantilla Name</label>
      <input
        id=""
        type="text" class="form-control" name="" aria-describedby="helpId" placeholder=""
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
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import { Link } from '@inertiajs/vue3'
</script>