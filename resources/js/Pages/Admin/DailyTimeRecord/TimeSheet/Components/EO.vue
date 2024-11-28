<template>
  <div class="mb-3">
    <label for="" class="form-label">Title</label>
    <input
      id=""
      v-model="entryForm.off_title"
      type="text"
      class="form-control"
      name=""
      aria-describedby="helpId"
      placeholder=""
      maxlength="100"
    />
    <InputError :message="entryForm.errors.off_title" />
  </div>
  <div class="mb-3">
    <div class="form-check form-check-inline">
      <input
        id="eo_8"
        v-model="entryForm.eo_sched_type"
        class="form-check-input"
        type="radio"
        name="eo_hours"
        value="ALLDAY"
      />
      <label class="form-check-label" for="eo_8">8 hours</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        id="eo_partial"
        v-model="entryForm.eo_sched_type"
        class="form-check-input"
        type="radio"
        name="eo_hours"
        value="PARTIAL"
      />
      <label class="form-check-label" for="eo_partial">Partial</label>
    </div>
    <InputError :message="entryForm.errors.eo_sched_type" />
  </div>
  <div v-if="entryForm.eo_sched_type === 'PARTIAL'">
    <div class="mb-3">
      <label for="" class="form-label">Start</label>
      <input
        id=""
        v-model="entryForm.eo_start"
        type="time"
        class="form-control"
        name=""
        aria-describedby="helpId"
        placeholder=""
        maxlength="100"
      />
      <InputError :message="entryForm.errors.eo_start" />
    </div>
    <div class="mb-3">
      <label for="" class="form-label">End</label>
      <input
        id=""
        v-model="entryForm.eo_end"
        type="time"
        class="form-control"
        name=""
        aria-describedby="helpId"
        placeholder=""
        maxlength="100"
      />
      <InputError :message="entryForm.errors.eo_end" />
    </div>
  </div>
</template>

<script setup>
import InputError from '@/Components/InputError.vue'

defineProps({
  entryForm: Object,
})
</script>