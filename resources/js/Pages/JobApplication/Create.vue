<template>
  <ApplicationLayout :job_posting="job_posting">
    <div v-if="props.application.length > 0" class="card shadow-sm border-0 rounded-4 mb-4">
      <div class="card-body p-5 text-center">
        <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle d-inline-block mb-3">
          <i class="fa-solid fa-check fs-1"></i>
        </div>
        <h4 class="fw-bold mb-3">Application Submitted Successfully</h4>
        <p class="text-muted mb-4">You have already submitted an application for this position.</p>
        
        <div class="row justify-content-center mb-4 text-start">
          <div class="col-12 col-md-8 col-lg-6">
            <div class="card border bg-light shadow-none">
              <div class="card-body">
                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Submitted Materials</h6>
                <div class="mb-3">
                  <span class="text-secondary small fw-medium text-uppercase d-block mb-1">E-PDS</span>
                  <a target="_blank" :href="route('profile.pds.personal_information.edit')" class="text-primary text-decoration-none"><i class="fa-solid fa-up-right-from-square me-2"></i>Personal Data Sheet</a>
                </div>
                <div>
                  <span class="text-secondary small fw-medium text-uppercase d-block mb-1">Uploaded Documents</span>
                  <div class="d-flex flex-column gap-2 mt-2">
                    <a v-for="document in application[0].document" :key="document.id" :href="document.src" target="_blank" class="d-flex align-items-center text-decoration-none text-dark bg-white p-2 rounded border">
                      <i class="fa-solid fa-file-pdf text-danger fs-4 me-3"></i>
                      <span class="text-truncate">{{ document.filename }}</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <Link v-if="permissions.includes('Delete Application')" :onBefore="confirm" method="delete" as="button"
          :href="route('job_application.destroy', { job_application: props.application[0].id })"
          class="btn btn-outline-danger rounded-pill px-4 fw-medium">
          <i class="fa-solid fa-trash me-2"></i>Withdraw Application
        </Link>
      </div>
    </div>
    
    <form v-else @submit.prevent="submitApplication">
      <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-white border-bottom p-4">
          <h4 class="fw-bold text-dark mb-0">Personal Data Sheet</h4>
        </div>
        <div class="card-body p-4">
          <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-primary rounded-pill px-4" :href="route('profile.pds.personal_information.edit')" target="_blank">
              <i class="fa-solid fa-up-right-from-square me-2" />Update PDS
            </a>
            <!-- <a class="btn btn-outline-secondary rounded-pill px-4" :href="route('pds.export')" target="_blank">
              <i class="fa-solid fa-download me-2" />Export PDS
            </a> -->
            <!-- <a class="btn btn-outline-secondary rounded-pill px-4" :href="route('wes.print')" target="_blank">
              <i class="fa-solid fa-print me-2" />Print Work Experience Sheet
            </a> -->
          </div>
        </div>
      </div>

      <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
          <div class="alert alert-danger border-0 rounded-3 mb-4">
            <b class="d-block mb-2"><i class="fa-solid fa-circle-exclamation me-2"></i>Critical Reminders:</b>
            <ol class="mb-0 ps-3 small">
              <li class="mb-2">
                Work Experiences and Learning and Development(L&D) Interventions/ Training Programs must be inputted to
                the PDS through the system. Click <b><a :href="route('profile.pds.personal_information.edit')" target="_blank" class="text-danger text-decoration-underline">here</a></b> to update your PDS.
              </li>
              <li>
                Please attach the certificates of Trainings on PDS under <b><Link :href="route('profile.pds.learning_and_development.index')" class="text-danger text-decoration-underline">L&D Interventions/ Training Programs</Link></b> for it to be valid. All trainings without certificate will be invalid.
              </li>
            </ol>
          </div>

          <div class="row g-4 mb-4 pb-4 border-bottom">
            <div class="col-12 col-md-6">
              <h5 class="fw-bold text-primary mb-2">Work Experience</h5>
              <div class="text-dark">
                <span v-if="props.job_posting.plantilla.work_experience">{{ props.job_posting.plantilla.work_experience }} year/s of relevant experience.</span>
                <span v-else class="text-muted fst-italic">None required</span>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <h5 class="fw-bold text-primary mb-2">Training</h5>
              <div class="text-dark">
                <span v-if="props.job_posting.plantilla.training">{{ props.job_posting.plantilla.training }} hour/s of relevant trainings.</span>
                <span v-else class="text-muted fst-italic">None required</span>
              </div>
            </div>
          </div>

          <h5 class="fw-bold text-primary mb-3">Documentary Requirements</h5>
          <p class="text-danger small mb-4">* Required fields</p>
          
          <div class="row g-4">
            <!-- PDS -->
            <div class="col-12">
              <label class="form-label fw-bold text-dark">
                1. Fully accomplished Personal Data Sheet (PDS) <span class="text-danger">*</span>
              </label>
              <p class="small text-muted mb-2">With Work Experience Sheet and recent passport-sized or unfiltered digital picture (CS Form No. 212, Revised 2025); digitally signed or electronically signed. Must be a scanned copy of signed PDS in PDF format.</p>
              <input type="file" class="form-control" multiple data-input="pds" @input="addDocument" accept=".pdf" />
              <InputError :message="form.errors['pds']" class="mt-1" />
              <InputError :message="form.errors['pds.0']" class="mt-1" />
            </div>

            <!-- Rating -->
            <div class="col-12">
              <label class="form-label fw-bold text-dark">
                2. Performance rating in the last rating period <span class="text-muted fw-normal fst-italic">(if applicable)</span>
              </label>
              <input type="file" class="form-control" data-input="rating" multiple @input="addDocument" accept=".pdf" />
              <div class="form-text small text-muted"><i class="fa-solid fa-circle-info me-1"></i>Accepted file formats: pdf</div>
              <InputError :message="form.errors['rating']" class="mt-1" />
              <InputError :message="form.errors['rating.0']" class="mt-1" />
            </div>

            <!-- Eligibility -->
            <div class="col-12">
              <label class="form-label fw-bold text-dark">
                3. Photocopy of certificate of eligibility/rating/license <span class="text-danger">*</span>
              </label>
              <input type="file" class="form-control" data-input="eligibility" multiple @input="addDocument" accept=".pdf" />
              <div class="form-text small text-muted"><i class="fa-solid fa-circle-info me-1"></i>Accepted file formats: pdf</div>
              <InputError :message="form.errors['eligibility']" class="mt-1" />
              <InputError :message="form.errors['eligibility.0']" class="mt-1" />
            </div>

            <!-- TOR -->
            <div class="col-12">
              <label class="form-label fw-bold text-dark">
                4. Photocopy of Transcript of Records <span class="text-danger">*</span>
              </label>
              <input type="file" class="form-control" multiple data-input="tor" @input="addDocument" accept=".pdf" />
              <div class="form-text small text-muted"><i class="fa-solid fa-circle-info me-1"></i>Accepted file formats: pdf</div>
              <InputError :message="form.errors['tor']" class="mt-1" />
              <InputError :message="form.errors['tor.0']" class="mt-1" />
            </div>

            <!-- Other Documents -->
            <div class="col-12">
              <label class="form-label fw-bold text-dark">
                5. Other Documents
              </label>
              <input type="file" class="form-control" data-input="documents" multiple @input="addDocument" accept=".pdf" />
              <div class="form-text small text-muted"><i class="fa-solid fa-circle-info me-1"></i>Accepted file formats: pdf</div>
              <InputError :message="form.errors['documents']" class="mt-1" />
              <InputError :message="form.errors['documents.0']" class="mt-1" />
            </div>
          </div>
        </div>
        <div class="card-footer bg-light border-top p-4 d-flex gap-2 justify-content-end">
          <button type="reset" class="btn btn-outline-secondary rounded-pill px-4 fw-medium" @click="resetForm">
            Reset
          </button>
          <button type="button" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm" :disabled="form.processing" data-bs-toggle="modal" data-bs-target="#privacy_notice">
            <Spinner :processing="form.processing" class="me-2" v-if="form.processing" />
            <span v-else><i class="fa-solid fa-paper-plane me-2"></i>Submit Application</span>
          </button>
        </div>
      </div>

      <Modal modal_id="privacy_notice">
        <template #header>
          <h4 class="fw-bold mb-0">Privacy Notice</h4>
        </template>
        <template #body>
          <div class="alert alert-info border-0 rounded-3 mb-4">
            <p class="mb-3">
              All information provided will remain secure and confidential within the Department of Economic,
              Planning and Development Region 2 (DEPDev2). Only authorized personnel will have access to this data.
              DEPDev2 will retain this information for 2 years.
            </p>
            <p class="mb-3">
              DEPDev2 employs appropriate technical and organizational measures to ensure data security and
              protect it against unauthorized disclosure or access. DEPDev2 complies with the standards set by the <a
                href="https://privacy.gov.ph/data-privacy-act/" target="_blank" class="fw-bold text-primary">Data Privacy Act of 2012</a> and
              does not share data with any third parties.
            </p>
            <p class="mb-0">
              You hold specific rights under the Data Privacy Act, including the right to object to data
              processing, access your data, correct inaccuracies, and request data erasure or blocking. For more
              information on these rights or to make requests concerning your data (review, withdrawal of consent,
              correction, or updates), please contact us at <a
                href="mailto:neda2ict@gmail.com" class="fw-bold text-primary">neda2ict@gmail.com</a>.
            </p>
          </div>
          <div class="d-flex justify-content-end gap-2">
            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary rounded-pill px-4">
              Cancel
            </button>
            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">
              <Spinner :processing="form.processing" class="me-2" v-if="form.processing" />
              <span v-if="form.processing">Submitting...</span>
              <span v-else><i class="fa-solid fa-check me-2"></i>I Agree, Submit Application</span>
            </button>
          </div>
        </template>
      </Modal>
    </form>
  </ApplicationLayout>
</template>

<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3'
import ApplicationLayout from '@/Pages/JobApplication/Layout/ApplicationLayout.vue'
import InputError from '@/Components/InputError.vue'
import Spinner from '@/Components/Spinner.vue'
import Modal from '@/Components/Modal.vue'


const props = defineProps({
  job_posting: Object,
  application: Object,
})

const form = useForm({
  documents: [],
  pds: [],
  rating: [],
  eligibility: [],
  training: [],
  tor: [],
})

const addDocument = (e) => {
  const data_input = e.target.getAttribute('data-input')

  form[data_input] = []

  for (const file of e.target.files) {
    form[data_input].push(file)
  }
}

const submitApplication = () => {
  form.post(route('job_application.store', { job_posting: props.job_posting.id }), {
    onSuccess: () => {
      if (props.application.length > 0) {
        location.reload()
      }
    },
  })
}

const confirm = () => window.confirm('Are you sure to cancel the job application.')

const permissions = usePage().props.auth.permissions.map(p => p.name)

const resetForm = () => {
  form.reset()
}

</script>