<template>
  <form v-if="applicant_details?.role_name.includes('employee')" class="card mb-3" @submit.prevent="onSubmit">
    <div class="card-header">
      <div class="card-title">HRMPSB Deliberation and Validation</div>
    </div>
    <div class="card-body">
      <div class="form-group mb-3">
        <label for="" class="form-label">Organizational Competencies</label>
        <input v-model="form.org_competency" type="text" class="form-control form-control-sm" />
        <InputError :message="form.errors.org_competency" />
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Leadership and Managerial Competencies</label>
        <input v-model="form.leadership_competency" type="text" class="form-control form-control-sm" />
        <InputError :message="form.errors.leadership_competency" />
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Technical/Functional Competencies</label>
        <input v-model="form.technical_competency" type="text" class="form-control form-control-sm" />
        <InputError :message="form.errors.technical_competency" />
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Peer Review (20 points)</label>
        <input v-model="form.personality_peer" type="text" class="form-control form-control-sm" />
        <InputError :message="form.errors.personality_peer" />
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Experience (15 points)</label>
        <input v-model="form.experience" type="text" class="form-control form-control-sm" />
        <InputError :message="form.errors.experience" />
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Potential (15 points)</label>
        <input v-model="form.potential" type="text" class="form-control form-control-sm" />
        <InputError :message="form.errors.potential" />
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

  <!-- outsider -->
  <form v-else class="card mb-3" @submit.prevent="onSubmit">
    <div class="card-header">
      <div class="card-title">HRMPSB Deliberation and Validation</div>
    </div>
    <div class="card-body">
      <div class="form-group mb-3">
        <label for="" class="form-label">Organizational Competencies</label>
        <input v-model="form.org_competency" type="text" class="form-control form-control-sm" />
        <InputError :message="form.errors.org_competency" />
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Leadership and Managerial Competencies</label>
        <input v-model="form.leadership_competency" type="text" class="form-control form-control-sm" />
        <InputError :message="form.errors.leadership_competency" />
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Technical/Functional Competencies</label>
        <input v-model="form.technical_competency" type="text" class="form-control form-control-sm" />
        <InputError :message="form.errors.technical_competency" />
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Experience (15 points)</label>
        <input v-model="form.experience" type="text" class="form-control form-control-sm" />
        <InputError :message="form.errors.experience" />
      </div>
      <div class="form-group mb-3">
        <label for="" class="form-label">Potential (15 points)</label>
        <input v-model="form.potential" type="text" class="form-control form-control-sm" />
        <InputError :message="form.errors.potential" />
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
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  applicant_details: Object,
})

const form = useForm({
  performance: props.applicant_details.job_application[0].psb_points ? props.applicant_details.job_application[0].psb_points.performance : null,
  experience: props.applicant_details.job_application[0].psb_points ? props.applicant_details.job_application[0].psb_points.experience : null,
  personality_hrmpsb: props.applicant_details.job_application[0].psb_points ? props.applicant_details.job_application[0].psb_points.personality_hrmpsb :null,
  org_competency: props.applicant_details.job_application[0].psb_points ? props.applicant_details.job_application[0].psb_points.org_competency:null,
  leadership_competency: props.applicant_details.job_application[0].psb_points ? props.applicant_details.job_application[0].psb_points.leadership_competency:null,
  technical_competency: props.applicant_details.job_application[0].psb_points ? props.applicant_details.job_application[0].psb_points.technical_competency:null,
  personality_peer: props.applicant_details.job_application[0].psb_points ? props.applicant_details.job_application[0].psb_points.personality_peer :null,
  potential: props.applicant_details.job_application[0].psb_points ? props.applicant_details.job_application[0].psb_points.potential :null,
})

const onSubmit = () => {
  form.post(route('admin.recruitment.psb_point.save', {job_application: props.applicant_details.job_application[0].id}))
}
</script>