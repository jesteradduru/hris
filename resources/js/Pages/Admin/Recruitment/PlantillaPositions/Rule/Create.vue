<template>
  <RecruitmentLayout>
    <Link class="btn btn-secondary btn-sm mb-3" :href="route('admin.recruitment.plantilla.edit', {plantilla: 1})"><i class="fa-solid fa-arrow-left" /></Link>
    <h3>New Rule</h3>
    <div class="mb-3">
      <label for="" class="form-label">Title</label>
      <input
        id=""
        type="text" class="form-control" name="" aria-describedby="helpId" placeholder=""
      />
    </div>
    <button>Insert</button>
    <div class="mb-3">
      <label for="" class="form-label" />
      <textarea id="" class="form-control" name="" rows="3" />
    </div>
  </RecruitmentLayout>
</template>
  
<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import { Link } from '@inertiajs/vue3'
</script>