<template>
  <form v-if="applicant_details?.role_name?.includes('employee')" class="card border-0 shadow-sm rounded-3 bg-white mb-4" @submit.prevent="onSubmit">
    <div class="card-header bg-white border-bottom py-3 px-3">
      <div class="d-flex align-items-center justify-content-between">
        <h6 class="fw-bold mb-0 text-primary text-uppercase d-flex align-items-center gap-2">
          <i class="fa-solid fa-clipboard-check text-primary" />
          <span>HRMPSB Deliberation & Validation (Insider)</span>
        </h6>
        <span class="badge bg-light text-secondary border rounded-pill extra-small">Evaluation Form</span>
      </div>
    </div>
    
    <div class="card-body p-3">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold text-muted extra-small text-uppercase">Organizational Competencies</label>
          <input v-model="form.org_competency" type="text" class="form-control form-control-sm rounded-2" placeholder="Rating / Score" />
          <InputError :message="form.errors.org_competency" />
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold text-muted extra-small text-uppercase">Leadership & Managerial Competencies</label>
          <input v-model="form.leadership_competency" type="text" class="form-control form-control-sm rounded-2" placeholder="Rating / Score" />
          <InputError :message="form.errors.leadership_competency" />
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold text-muted extra-small text-uppercase">Technical / Functional Competencies</label>
          <input v-model="form.technical_competency" type="text" class="form-control form-control-sm rounded-2" placeholder="Rating / Score" />
          <InputError :message="form.errors.technical_competency" />
        </div>
        <div class="col-md-6">
          <div class="d-flex align-items-center justify-content-between">
            <label class="form-label fw-semibold text-muted extra-small text-uppercase mb-1">Peer Review</label>
            <span class="badge bg-primary-subtle text-primary border extra-small">Max 20 pts</span>
          </div>
          <input v-model="form.personality_peer" type="text" class="form-control form-control-sm rounded-2" placeholder="Points" />
          <InputError :message="form.errors.personality_peer" />
        </div>
        <div class="col-md-6">
          <div class="d-flex align-items-center justify-content-between">
            <label class="form-label fw-semibold text-muted extra-small text-uppercase mb-1">Experience</label>
            <span class="badge bg-primary-subtle text-primary border extra-small">Max 35 pts</span>
          </div>
          <input v-model="form.experience" type="text" class="form-control form-control-sm rounded-2" placeholder="Points" />
          <InputError :message="form.errors.experience" />
        </div>
        <div class="col-md-6">
          <div class="d-flex align-items-center justify-content-between">
            <label class="form-label fw-semibold text-muted extra-small text-uppercase mb-1">Potential</label>
            <span class="badge bg-primary-subtle text-primary border extra-small">Max 15 pts</span>
          </div>
          <input v-model="form.potential" type="text" class="form-control form-control-sm rounded-2" placeholder="Points" />
          <InputError :message="form.errors.potential" />
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
        <div>
          <span v-if="form.isDirty" class="badge bg-warning-subtle text-danger border extra-small">
            <i class="fa-solid fa-triangle-exclamation me-1" />Unsaved Changes
          </span>
          <span v-else-if="form.wasSuccessful" class="badge bg-success-subtle text-success border extra-small">
            <i class="fa-solid fa-circle-check me-1" />Saved Successfully
          </span>
        </div>
        <button
          type="submit" 
          :disabled="!form.isDirty && form.wasSuccessful"
          class="btn btn-success btn-sm rounded-pill px-4 shadow-sm d-flex align-items-center gap-2"
        >
          <Spinner :processing="form.processing" /> 
          <span v-if="!form.isDirty && form.wasSuccessful">
            <i class="fa-solid fa-circle-check me-1" />Saved
          </span>
          <span v-else>
            <i v-if="!form.processing" class="fa-solid fa-floppy-disk me-1" />Save Deliberations
          </span>
        </button>
      </div>
    </div>
  </form>

  <!-- Outsider Evaluation Form -->
  <form v-else class="card border-0 shadow-sm rounded-3 bg-white mb-4" @submit.prevent="onSubmit">
    <div class="card-header bg-white border-bottom py-3 px-3">
      <div class="d-flex align-items-center justify-content-between">
        <h6 class="fw-bold mb-0 text-primary text-uppercase d-flex align-items-center gap-2">
          <i class="fa-solid fa-clipboard-check text-primary" />
          <span>HRMPSB Deliberation & Validation (Outsider)</span>
        </h6>
        <span class="badge bg-light text-secondary border rounded-pill extra-small">Evaluation Form</span>
      </div>
    </div>

    <div class="card-body p-3">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold text-muted extra-small text-uppercase">Organizational Competencies</label>
          <input v-model="form.org_competency" type="text" class="form-control form-control-sm rounded-2" placeholder="Rating / Score" />
          <InputError :message="form.errors.org_competency" />
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold text-muted extra-small text-uppercase">Leadership & Managerial Competencies</label>
          <input v-model="form.leadership_competency" type="text" class="form-control form-control-sm rounded-2" placeholder="Rating / Score" />
          <InputError :message="form.errors.leadership_competency" />
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold text-muted extra-small text-uppercase">Technical / Functional Competencies</label>
          <input v-model="form.technical_competency" type="text" class="form-control form-control-sm rounded-2" placeholder="Rating / Score" />
          <InputError :message="form.errors.technical_competency" />
        </div>
        <div class="col-md-6">
          <div class="d-flex align-items-center justify-content-between">
            <label class="form-label fw-semibold text-muted extra-small text-uppercase mb-1">Experience</label>
            <span class="badge bg-primary-subtle text-primary border extra-small">Max 35 pts</span>
          </div>
          <input v-model="form.experience" type="text" class="form-control form-control-sm rounded-2" placeholder="Points" />
          <InputError :message="form.errors.experience" />
        </div>
        <div class="col-md-6">
          <div class="d-flex align-items-center justify-content-between">
            <label class="form-label fw-semibold text-muted extra-small text-uppercase mb-1">Potential</label>
            <span class="badge bg-primary-subtle text-primary border extra-small">Max 15 pts</span>
          </div>
          <input v-model="form.potential" type="text" class="form-control form-control-sm rounded-2" placeholder="Points" />
          <InputError :message="form.errors.potential" />
        </div>
      </div>

      <div class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
        <div>
          <span v-if="form.isDirty" class="badge bg-warning-subtle text-danger border extra-small">
            <i class="fa-solid fa-triangle-exclamation me-1" />Unsaved Changes
          </span>
          <span v-else-if="form.wasSuccessful" class="badge bg-success-subtle text-success border extra-small">
            <i class="fa-solid fa-circle-check me-1" />Saved Successfully
          </span>
        </div>
        <button
          type="submit" 
          :disabled="!form.isDirty && form.wasSuccessful"
          class="btn btn-success btn-sm rounded-pill px-4 shadow-sm d-flex align-items-center gap-2"
        >
          <Spinner :processing="form.processing" /> 
          <span v-if="!form.isDirty && form.wasSuccessful">
            <i class="fa-solid fa-circle-check me-1" />Saved
          </span>
          <span v-else>
            <i v-if="!form.processing" class="fa-solid fa-floppy-disk me-1" />Save Deliberations
          </span>
        </button>
      </div>
    </div>
  </Form>
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