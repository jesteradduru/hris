<template>
  <div v-if="entryForm.purpose === 'supp'">
    <fieldset class="mb-3 row">
      <legend class="col-12">AM</legend>
      <div class="mb-3 col-6">
        <label for="" class="form-label">Time In</label>
        <input
          id=""
          v-model="entryForm.supp_am_in"
          type="time"
          class="form-control"
          name=""
          aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="entryForm.errors.supp_am_in" />
      </div>
      <div class="mb-3 col-6">
        <label for="" class="form-label">Time Out</label>
        <input
          id=""
          v-model="entryForm.supp_am_out"
          type="time"
          class="form-control"
          name=""
          aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="entryForm.errors.supp_am_out" />
      </div>
    </fieldset>
    <fieldset class="row">
      <legend class="col-12">PM</legend>
      <div class="mb-3 col-6">
        <label for="" class="form-label">Time In</label>
        <input
          id=""
          v-model="entryForm.supp_pm_in"
          type="time"
          class="form-control"
          name=""
          aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="entryForm.errors.supp_pm_in" />
      </div>
      <div class="mb-3 col-6">
        <label for="" class="form-label">Time Out</label>
        <input
          id=""
          v-model="entryForm.supp_pm_out"
          type="time"
          class="form-control"
          name=""
          aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="entryForm.errors.supp_pm_out" />
      </div>
    </fieldset>
  </div>
</template>

<script setup>
import InputError from '@/Components/InputError.vue'

defineProps({
  entryForm: Object,
})
</script>