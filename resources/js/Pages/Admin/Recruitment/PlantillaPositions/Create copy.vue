<template>
  <RecruitmentLayout>
    <Link class="btn btn-secondary btn-sm mb-3" :href="route('admin.recruitment.plantilla.index')"><i class="fa-solid fa-arrow-left" /></Link>
    <div class="mb-3">
      <label for="" class="form-label">Plantilla Name</label>
      <input
        id=""
        v-model="plantillaForm.title" type="text" class="form-control" name="" aria-describedby="helpId" placeholder=""
      />
    </div>
    <div class="mb-3">
      <label for="" class="form-label">Item No.</label>
      <input
        id=""
        v-model="plantillaForm.item" type="text" class="form-control" name="" aria-describedby="helpId" placeholder=""
      />
    </div>
    <div class="mb-3">
      <label for="" class="form-label">Division</label>
      <select id="" class="form-select form-select-lg" name="">
        <option v-for="division in divisions" :key="division.id" :value="division.id">{{ division.name }}</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="" class="form-label">Education</label>
      <select id="" class="form-select form-select-lg" name="">
        <option value="">None Required</option>
        <option value="ELEMENTARY">Elementary</option>
        <option value="HIGH_SCHOOL">High School / Vocational</option>
        <option value="BACHELORS_DEGREE">College Graduate</option>
        <option value="MASTERS_DEGREE">Graduate Studies</option>
        <option value="DOCTORATE_DEGREE">Graduate Studies</option>
      </select>
    </div>
    <div class="mb-3">
      <div class="d-flex gap-2 align-items-center">
        <label for="" class="form-label">Eligibility</label>
        <a href="#" data-bs-toggle="modal" data-bs-target="#eligibilitiesModal" class="mb-2"><div class="fa-solid fa-cog" /></a>
      </div>
      <ul v-if="selectedELigibilities.length > 0" class="list-group list-group-numbered mb-2">
        <li v-for="elig in selectedELigibilities" :key="elig.id" class="list-group-item">
          <span>{{ elig.title }}</span>
          &nbsp;
          <a href="#" @click="() => removeElig(elig.id)">Remove</a>
        </li>
      </ul>
      <div v-else class="text-center text-muted mb-2">No required eligibility</div>
      <div class="d-flex gap-2 align-items-center">
        <select id="" v-model="plantillaForm.selectedElig" class="form-select form-select-lg" name="">
          <option value="">Select Eligibility</option>
          <option v-for="elig in eligibilities" :key="elig.id" :value="elig.id">{{ elig.title }}</option>
        </select>
        <button class="btn btn-success" @click="addElig"><i class="fa-solid fa-plus" /></button>
      </div>
    </div>
    <!-- Modal -->
    <Modal modal_id="eligibilitiesModal">
      <template #header>Eligibilities</template>
      <template #body>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addEligibility" class="mb-2 btn btn-success">Add <div class="fa-solid fa-plus" /></a>
        <div class="table-responsive">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="elig in eligibilities" :key="elig.id" class="">
                <td scope="row">{{ elig.title }}</td>
                <td>
                  <div class="d-flex gap-2">
                    <button data-bs-toggle="modal" data-bs-target="#editEligibility" class="btn btn-success btn-sm" @click="() => onShowEdit(elig)"><i class="fa-solid fa-pen" /></button>
                    <Link :onBefore="confirm" as="button" method="delete" :href="route('admin.recruitment.eligibility.destroy', {eligibility: elig.id})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash" /></Link>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div v-if="eligibilities.length === 0" class="text-center">No record</div>
        </div>
      </template>
    </Modal>
    <!-- end of line -->
    <!-- modal for adding eligibility -->
    <Modal modal_id="addEligibility">
      <template #header>Add eligibility</template>
      
      <template #body>
        <a href="#" data-bs-toggle="modal" data-bs-target="#eligibilitiesModal" class="mb-2 btn btn-secondary"><div class="fa-solid fa-arrow-left" /></a>
        <div class="mb-3">
          <label for="" class="form-label">Eligibility</label>  
          <input
            id=""
            v-model="addForm.title" type="text" class="form-control" name="" aria-describedby="helpId" placeholder=""
          />
          <InputError :message="addForm.errors.title" />
        </div>
        <div v-if="addForm.recentlySuccessful" class="text-success">Success</div>
        <button class="btn btn-success" @click="add">Save</button>
      </template>
    </Modal>
    <!-- end of add modal eligibility -->
    <!-- modal for edit eligibility -->
    <Modal modal_id="editEligibility">
      <template #header>Edit eligibility</template>
      
      <template #body>
        <a href="#" data-bs-toggle="modal" data-bs-target="#eligibilitiesModal" class="mb-2 btn btn-secondary"><div class="fa-solid fa-arrow-left" /></a>
        <div class="mb-3">
          <label for="" class="form-label">Eligibility</label>
          <input
            id=""
            v-model="editForm.title"
            type="text" class="form-control" name="" aria-describedby="helpId" placeholder=""
          />
          <InputError :message="editForm.errors.title" />
        </div>
        <div v-if="editForm.recentlySuccessful" class="text-success">Success</div>
        <button class="btn btn-success" @click="update">Save</button>
      </template>
    </Modal>
    <!-- end of edit modal eligibility -->
  </RecruitmentLayout>
</template>

<script setup>
import RecruitmentLayout from '@/Pages/Admin/Recruitment/Layout/RecruitmentLayout.vue'
import Modal from '@/Components/Modal.vue'
import InputError from '@/Components/InputError.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const props = defineProps({
  eligibilities: Array,
  divisions: Array,
})

const plantillaForm = useForm({
  eligibilities: [],
  selectedElig: '',
  title: '',
  item: null,
  division_id: null,
  education: null,
})

const selectedELigibilities = computed(() => {
  return props.eligibilities.filter(elig => plantillaForm.eligibilities.includes(elig.id))
})

const addElig = () => {
  if(plantillaForm.selectedElig  !== null){
    plantillaForm.eligibilities.push(plantillaForm.selectedElig)
  }
}
const removeElig = (id) => {
  plantillaForm.eligibilities = plantillaForm.eligibilities.filter(elig => elig != id)
}

const addForm = useForm({
  title: null,
})


const editForm = useForm({
  title: null,
  id: null,
})

const add = () => {
  addForm.post(route('admin.recruitment.eligibility.store'))
}

const update = () => {
  editForm.put(route('admin.recruitment.eligibility.update', {eligibility: editForm.id}))
}

const onShowEdit = (elig) => {
  editForm.title = elig.title
  editForm.id = elig.id
}

const confirm = () => window.confirm('Are you sure to delete this eligibility?')
</script>