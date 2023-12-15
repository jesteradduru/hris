<template>
  <form v-if="applicant_details?.role_name.includes('employee')" class="card mb-3">
    <div class="card-header">
      <div class="card-title">HRMPSB Deliberation and Validation</div>
    </div>
    <div class="card-body">
      <div class="form-group mb-3">
        <label for="" class="form-label">Performance (15 points)</label>
        <input v-model="form.performance" type="text" class="form-control form-control-sm" />
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Experience (15 points)</label>
        <input type="text" class="form-control form-control-sm" />
      </div>
      <div class="border p-2 mb-3">
        <b class="mb-3">Personality (15 points)</b>
        <div class="form-group mb-3">
          <label for="" class="form-label">HRMPSB (80 points)</label>
          <input type="text" class="form-control form-control-sm" />
        </div>
        <div class="form-group mb-3">
          <label for="" class="form-label">Peer Review (20 points)</label>
          <input type="text" class="form-control form-control-sm" />
        </div>
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Potential (15 points)</label>
        <input type="text" class="form-control form-control-sm" />
      </div>

      <button
        type="submit" :disabled="!form.isDirty && form.wasSuccessful"
        class="btn btn-success"
      >
        <Spinner :processing="form.processing" /> 
        <span
          v-if="!form.isDirty &&
            form.wasSuccessful"
        ><i class="bi-file-earmark-check" /> Saved</span>
        <span v-else><i v-if="!form.processing" class="bi-file-earmark-arrow-up" /> Save</span>
      </button>
      <small v-if="form.isDirty" class="text-danger form-status ms-2">Not Saved</small>
    </div>
  </form>
  <form v-else class="card mb-3">
    <div class="card-header">
      <div class="card-title">HRMPSB Deliberation and Validation</div>
    </div>
    <div class="card-body">
      <div class="form-group mb-3">
        <label for="" class="form-label">Performance (15 points)</label>
        <input type="text" class="form-control form-control-sm" />
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Experience (15 points)</label>
        <input type="text" class="form-control form-control-sm" />
      </div>
      <div class="border p-2 mb-3">
        <b class="mb-3">Personality (15 points)</b>
        <div class="form-group mb-3">
          <label for="" class="form-label">HRMPSB (100 points)</label>
          <input type="text" class="form-control form-control-sm" />
        </div>
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Potential (15 points)</label>
        <input type="text" class="form-control form-control-sm" />
      </div>
      <button
        type="submit" :disabled="!form.isDirty && form.wasSuccessful"
        class="btn btn-success"
      >
        <Spinner :processing="form.processing" /> 
        <span
          v-if="!form.isDirty &&
            form.wasSuccessful"
        ><i class="bi-file-earmark-check" /> Saved</span>
        <span v-else><i v-if="!form.processing" class="bi-file-earmark-arrow-up" /> Save</span>
      </button>
      <b v-if="form.isDirty" class="text-danger form-status ms-2">Not Saved</b>
    </div>
  </form>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3'

const props = defineProps({
  applicant_details: Object,
})

const form = useForm({
  performance: null,
})
</script>