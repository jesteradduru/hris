<template>
  <div class="mb-3">
    <label for="" class="form-label">Remarks</label>
    <select
      id=""
      v-model="entryForm.remarks"
      class="form-select form-select-lg"
      name=""
    >
      <option value="">Select one</option>
      <option v-for="remark in remarks" :key="remark" :value="remark">{{ remark }}</option>
    </select>
    <InputError :message="entryForm.errors.remarks" />
  </div>
  <!-- REG_OB -->
  <div
    v-if="entryForm.remarks === 'REG_OB'||
      entryForm.remarks === 'REG_SPL' ||
      entryForm.remarks === 'REG_VL' || entryForm.remarks === 'REG_SL' ||
      entryForm.remarks === 'REG_FL' ||
      entryForm.remarks === 'STUDY_LEAVE' ||
      entryForm.remarks === 'MATERNITY_LEAVE' ||
      entryForm.remarks === 'PATERNITY_LEAVE' ||
      entryForm.remarks === 'ON_SCHOLARSHIP' "
  >
    <div class="form-check form-check-inline">
      <input
        id="reg_multiday"
        v-model="entryForm.reg_multiday"
        class="form-check-input"
        type="checkbox"
        name="reg_multiday"
      />
      <label class="form-check-label" for="reg_multiday">Multi Day</label>
    </div>
    <!-- ob multiday -->
    <div v-if="entryForm.reg_multiday">
      <div class="mb-3">
        <label for="" class="form-label">Start</label>
        <input
          id=""
          v-model="entryForm.reg_start"
          type="date"
          class="form-control"
          name=""
          aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="entryForm.errors.reg_start" />
      </div>
      <div class="mb-3">
        <label for="" class="form-label">End</label>
        <input
          id=""
          v-model="entryForm.reg_end"
          type="date"
          class="form-control"
          name=""
          aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="entryForm.errors.reg_end" />
      </div>
    </div>
  </div>
  <!-- EO -->
  <div v-if="entryForm.remarks === 'EO'">
    <EO :entryForm="entryForm" />
  </div>
  <!-- OFFSETTING -->
  <div v-if="entryForm.remarks === 'OFFSETTING'">
    <div class="mb-3">
      <label for="" class="form-label">Hours</label>
      <input
        id=""
        v-model="entryForm.off_hours"
        type="number"
        class="form-control"
        name=""
        aria-describedby="helpId"
        placeholder=""
      />
      <InputError :message="entryForm.errors.off_hours" />
    </div>
  </div>
</template>
  
<script setup>
import InputError from '@/Components/InputError.vue'
import EO from './EO.vue'

const remarks = [
  'REG_OB',
  'REG_SPL',
  'REG_SL',
  'REG_VL',
  'REG_FL',
  'REG_HOLIDAY',
  'OFFSETTING',
  'EO',
  'RA_9710',
  'STUDY_LEAVE',
  'ON_SCHOLARSHIP',
  'MATERNITY_LEAVE',
  'PATERNITY_LEAVE',
]
  
defineProps({
  entryForm: Object,
})
</script>