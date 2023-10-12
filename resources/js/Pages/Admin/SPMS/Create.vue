<template>
  <Head title="SPMS" />
  <AdminLayout>
    <Link class="btn btn-secondary col btn-sm mb-3" :href="route('admin.spms.index')"><i class="fa-solid fa-arrow-left" /></Link>
    <h3>Add SPMS</h3>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">NAME</th>
            <th scope="col">YEAR</th>
            <th scope="col">SEMESTER</th>
            <th scope="col">FILE</th>
            <th scope="col">RATING</th>
            <th scope="col">ACTION</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(form, index) in formLists.forms" :key="index">
            <td scope="col">{{ form.user.name }}</td>
            <td scope="col">{{ form.year }}</td>
            <td scope="col">{{ form.semester }}</td>
            <td scope="col">{{ form.file[0].name }}</td>
            <td scope="col">{{ form.rating }}</td>
            <td scope="col"><button class="btn btn-danger btn-sm" @click="() => removeFromList(form.id)"><i class="fa-solid fa-x" /></button></td>
          </tr>
        </tbody>
      </table>
      <div v-if="formLists.forms.length === 0" class="text-muted text-center">No Data</div>
    </div>
    <button v-if="formLists.forms.length > 0" class="btn btn-success" :disabled="formLists.processing" @click="submitForms">
      <Spinner :processing="formLists.processing" />
      Submit
    </button>
    <form class="row border p-2 mt-5 mb-3 shadow" @submit.prevent="addFormIntoList">
      <div class="col-4">
        <label for="" class="form-label">Employee</label>
        <select id="" v-model="addForm.user" name="" class="form-control" required="true">
          <option value="">Select one</option>
          <option v-for="employee in props.users" :key="employee.id" :value="employee">{{ employee.name }}</option>
        </select>
        <InputError :message="addForm.errors.user" />
      </div>
      <div class="col-4">
        <label for="" class="form-label">FORM TYPE</label>
        <select id="" v-model="addForm.type" name="" class="form-control" required="true">
          <option value="">Select one</option>
          <option value="IPCR">IPCR</option>
          <option value="DPCR">DPCR</option>
          <option value="OPCR">OPCR</option>
        </select>
        <InputError :message="addForm.errors.type" />
      </div>
      <div class="col-4">
        <label for="" class="form-label">Year</label>
        <input
          id=""
          v-model="addForm.year"
          type="number" class="form-control" name="" aria-describedby="helpId" placeholder=""
          max="2099" min="2000"
          required="true"
        />
        <InputError :message="addForm.errors.year" />
      </div>
      <div class="col-4">
        <label for="" class="form-label">SEMESTER</label>
        <select id="" v-model="addForm.semester" name="" class="form-control" required="true">
          <option value="">Select one</option>
          <option value="FIRST">1ST SEMESTER</option>
          <option value="SECOND">2ND SEMESTER</option>
        </select>
        <InputError :message="addForm.errors.semester" />
      </div>
      <div class="col-4">
        <label for="" class="form-label">ATTACH FILE</label>
        <input
          id=""
          type="file" class="form-control" name="" aria-describedby="helpId" placeholder=""
          required="true"
          @change="addFile"
        />
        <small id="helpId" class="form-text text-muted">ONLY PDF FILE IS ALLOWED</small>
        <InputError :message="addForm.errors.file" />
      </div>
      <div class="col-4">
        <label for="" class="form-label">Rating</label>
        <input
          id=""
          v-model="addForm.rating" type="number" class="form-control" min="1" max="5" name="" aria-describedby="helpId"
          placeholder="" required="true"
        />
        <InputError :message="addForm.errors.rating" />
      </div>
      <div class="col-12">
        <button class="btn btn-primary" type="submit">Add <i class="fa-solid fa-plus" /></button>
      </div>
    </form>
  </AdminLayout>
</template>
      
<script setup>
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import {useForm, Link, Head} from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import moment from 'moment'  
import Spinner from '@/Components/Spinner.vue'

const props = defineProps({
  spms: Object,
  users: Array,
})

const formLists = useForm({
  forms: [],
})

  
const addForm = useForm({
  user: '',
  semester: '', 
  type: '',
  year: moment().format('YYYY'),
  file: '',
  rating: '',
})

const addFormIntoList = () => {
  formLists.forms.push({
    id: formLists.forms.length + 1,
    ...addForm.data(),
  })
}

const addFile = (e) => {
  addForm.file = e.target.files
}

const removeFromList = (form_id) => {
  formLists.forms = formLists.forms.filter(form => form.id !== form_id)
}

const submitForms = () => {
  if(window.confirm('Are you sure to submit the forms?')){
    formLists.post(route('admin.spms.store'),{
      onSuccess: () => {
        formLists.forms = []
      },
    })
  }
}
     
</script>