<template>
  <ApplicationLayout :job_posting="job_posting">
    <div v-if="props.application.length > 0" class="alert alert-success d-flex flex-column gap-2">
      <h5>Application submitted</h5>
      <div class="d-flex flex-column">
        <b>E-PDS</b>
        <a target="_blank" :href="route('profile.pds.personal_information.edit')">Personal Data Sheet</a>
      </div>
      <div class="d-flex flex-column">
        <b>Uploaded Documents</b>
        <a v-for="document in application[0].document" :key="document.id" :href="document.src" target="_blank">{{ document.filename }}</a>
      </div>
      <div>
        <Link v-if="permissions.includes('Delete Application')" :onBefore="confirm" method="delete" as="button" :href="route('job_application.destroy', {job_application: props.application[0].id})" class="btn btn-danger btn-md ">Recall Application</Link>
      </div>
    </div>
    <form v-else @submit.prevent="submitApplication">
      <div class="mb-3 p-4 border rounded">
        <h4>Personal Data Sheet</h4>
        <div class="d-flex gap-2">
          <a class="btn btn-primary " :href="route('profile.pds.personal_information.edit')" target="_blank">
            <i class="fa-solid fa-up-right-from-square " />&nbsp; Update PDS 
          </a>
          <a class="btn btn-success " :href="route('pds.export')" target="_blank">
            <i class="fa-solid fa-download " />&nbsp; Download PDS 
          </a>
        </div>
      </div>
      <div class="mb-3 p-4 border rounded">
        <div class="alert alert-danger">
          <b>Important Reminders:</b> 
          <ol>
            <li>
              Work Experiences and Learning and Development(L&D) Interventions/ Training Programs must be inputted to the PDS through the system. Click <b>
                <a :href="route('profile.pds.personal_information.edit')" target="_blank">
                  here
                </a>
              </b>
              to update your PDS.
            </li>
            <li>
              Please attach  the certificates of Trainings on PDS under <b><Link :href="route('profile.pds.learning_and_development.index')">L&D Interventions/ Training Programs</Link></b> for it to be valid. All trainings without certificate will be invalid.
            </li>
          </ol>
        </div>
        <h4>Work Experience</h4>
        <div class="mb-3 text-pre-wrap">
          <div class="mb-2">
            <span v-if="props.job_posting.plantilla.work_experience">{{ props.job_posting.plantilla.work_experience }} year/s of relevant experience.</span>
            <span v-else>None required</span>
          </div>
        </div>
        <h4>Training</h4>
        <div class="mb-3 text-pre-wrap">
          <span v-if="props.job_posting.plantilla.training">{{ props.job_posting.plantilla.training }} hour/s of relevant trainings.</span>
          <span v-else>None required</span>
        </div>
        <!-- DOCUMENTARY REQUIREMENTS -->
        <h4>Documentary Requirements</h4>
        <div class="text-danger mb-3">* Required</div>
        <div>
          <!-- PDS -->
          <div class="form-group mb-3">
            <label for="PDS">
              1. Fully accomplished Personal Data Sheet (PDS) with recent passport-sized picture (CS Form No. 212,
              Revised 2017) which can be downloaded
              <a :href="route('pds.export')" target="_blank">
                <b>here</b>
              </a>
              <span class="text-danger">*</span>
            </label>
            <div class="d-flex gap-2">
              <div>
                <input id="" type="file" class="form-control" name="" placeholder="" aria-describedby="fileHelpId" multiple data-input="pds" @input="addDocument" />
              </div>
              <InputError :message="form.errors['pds']" />
              <InputError :message="form.errors['pds.0']" />
            </div>
            <div class="form-text text-info">Must be a scanned copy of signed PDS in PDF format.</div>
          </div>
          <!-- Rating -->
          <div class="form-group mb-3 ">
            <label for="Rating">
              2. Performance rating in the last rating period (if applicable).
            </label>
            <div class="d-flex gap-2">
              <div>
                <input id="" type="file" class="form-control" name="" placeholder="" aria-describedby="fileHelpId" data-input="rating" multiple @input="addDocument" />
              </div>
              <InputError :message="form.errors['rating']" />
              <InputError :message="form.errors['rating.0']" />
            </div>
            <div class="form-text text-info">Accepted file formats: pdf</div>
          </div>
          <!-- Eligibility -->
          <div class="form-group mb-3 ">
            <label for="Eligibility">
              3. Photocopy of certificate of eligibility/rating/license. <span class="text-danger">*</span>
            </label>
            <div class="d-flex gap-2">
              <div>
                <input id="" type="file" class="form-control" name="" placeholder="" aria-describedby="fileHelpId" data-input="eligibility" multiple @input="addDocument" />
              </div>
              <InputError :message="form.errors['eligibility']" />
              <InputError :message="form.errors['eligibility.0']" />
            </div>
            <div class="form-text text-info">Accepted file formats: pdf</div>
          </div>
          <!-- TOR -->
          <div class="form-group mb-3">
            <label for="TOR">
              4. Photocopy of Transcript of Records. <span class="text-danger">*</span>
            </label>
            <div class="d-flex gap-2">
              <div>
                <input id="" type="file" class="form-control" name="" placeholder="" aria-describedby="fileHelpId" multiple data-input="tor" @input="addDocument" />
              </div>
              <InputError :message="form.errors['tor']" />
              <InputError :message="form.errors['tor.0']" />
            </div>
            <div class="form-text text-info">Accepted file formats: pdf</div>
          </div>
          <!-- training -->
          <!-- <div class="form-group mb-3 ">
            <label for="Documents">
              5. Photocopy of certificates on Learning and Development Interventions/ Training Programs
            </label>
            <div class="mb-3 d-flex gap-2">
              <div>
                <input id="training" type="file" class="form-control" name="" placeholder="" data-input="training" aria-describedby="fileHelpId" multiple @input="addDocument" />
              </div>
              <InputError :message="form.errors['training']" />
              <InputError :message="form.errors['training.0']" />
            </div>
            <div class="form-text text-info">Accepted file formats: pdf</div>
          </div> -->
          <!-- other documents -->
          <div class="form-group mb-3 ">
            <label for="Documents">
              5. Other Documents
            </label>
            <div class="d-flex gap-2">
              <div>
                <input id="" type="file" class="form-control" name="" placeholder="" data-input="documents" aria-describedby="fileHelpId" multiple @input="addDocument" />
              </div>
              <InputError :message="form.errors['documents']" />
              <InputError :message="form.errors['documents.0']" />
            </div>
            <div class="form-text text-info">Accepted file formats: pdf</div>
          </div>
        </div>
      </div>
      <div class="d-flex gap-2">
        <button type="reset" class="btn btn-secondary" :onClick="resetForm">
          Reset
        </button>
        <button type="submit" class="btn btn-success" :disabled="form.processing">
          <Spinner :processing="form.processing" />
          Submit
        </button>
      </div>
    </form>
    <Modal modal_id="reminder">
      <template #header>
        <h3>Reminder</h3>
      </template>
      <template #body>
        <div class="alert alert-danger">
          <b>Important Reminders:</b> 
          <ol>
            <li>
              Work Experiences and Learning and Development(L&D) Interventions/ Training Programs must be inputted to the PDS through the system. Click <b>
                <a :href="route('profile.pds.personal_information.edit')" target="_blank">
                  here
                </a>
              </b>
              to update your PDS.
            </li>
            <li>
              Please attach  the certificates of Trainings on PDS under <b><Link :href="route('profile.pds.learning_and_development.index')">L&D Interventions/ Training Programs</Link></b> for it to be valid. All trainings without certificate will be invalid.
            </li>
          </ol>
        </div>
      </template>
    </Modal>
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

  for(const file of e.target.files){
    form[data_input].push(file)
  }
}

const submitApplication = () => {
  form.post(route('job_application.store', {job_posting: props.job_posting.id}), {
    onSuccess: () => form.reset(),
  })
}

const confirm = () => window.confirm('Are you sure to cancel the job application.')

const permissions = usePage().props.auth.permissions.map(p => p.name)

const resetForm = () => {
  form.reset()
}

window.onload = () => {
  $('#reminder').modal('show')
}

</script>
    