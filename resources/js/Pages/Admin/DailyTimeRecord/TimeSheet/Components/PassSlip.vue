<template>
  <div class="form-check form-check-inline">
    <input
      id="passper"
      v-model="entryForm.pass_type"
      class="form-check-input"
      type="radio"
      name="pass"
      value="personal"
    />
    <label class="form-check-label" for="passper">Personal</label>
  </div>
  <div class="form-check form-check-inline">
    <input
      id="passoff"
      v-model="entryForm.pass_type"
      class="form-check-input"
      type="radio"
      name="pass"
      value="official"
    />
    <label class="form-check-label" for="passoff">Official</label>
  </div>
  <div class="mb-3">
    <label for="" class="form-label">Time of Departure</label>
    <input
      id=""
      v-model="entryForm.pass_out"
      type="time"
      class="form-control"
      name=""
      aria-describedby="helpId"
      placeholder=""
    />
    <InputError :message="entryForm.errors.pass_out" />
  </div>
  <div class="mb-3">
    <label for="" class="form-label">Expected time of Return</label>
    <input
      id=""
      v-model="entryForm.pass_in"
      type="time"
      class="form-control"
      name=""
      aria-describedby="helpId"
      placeholder=""
    />
    <InputError :message="entryForm.errors.pass_in" />
  </div>
</template>

<script setup>
import InputError from '@/Components/InputError.vue'

defineProps({
  entryForm: Object,
})
</script>