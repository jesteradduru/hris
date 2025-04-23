<template>
  <!-- CREATE FORM -->
  <Modal id="create">
    <template #header>
      Create Division
    </template>
    <template #body>
      <div class="mb-3">
        <label for="" class="form-label">Name <small class="text-danger">*</small></label>
        <input
          id=""
          v-model="createForm.name"
          type="text"
          class="form-control"
          name=""
          aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="createForm.errors.name" />
      </div>

      <div class="mb-3">
        <label for="" class="form-label">Abbreviation <small class="text-danger">*</small></label>
        <input
          id=""
          v-model="createForm.abbreviation"
          type="text"
          class="form-control"
          name=""
          aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="createForm.errors.abbreviation" />
      </div>

      <div class="mb-3">
        <button class="btn btn-success btn-small" @click="onAdd">Create</button>
      </div>
    </template>
  </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  createForm: Object,
})


const onAdd = () => props.createForm.submit('post', route('admin.divisions.store'))

</script>