<template>
  <Head title="Performance Management" />
  <AdminLayout>
    <h3>Performance Management</h3>
    <div class="container border p-4 rounded">
      <div class="row">
        <div class="col">
          <label for="" class="form-label">Select Year</label>
          <select id="" v-model="form.year" class="form-select form-select-lg" name="">
            <option value="">All</option>
            <option v-for="year in years" :key="year">{{ year }}</option>
          </select>
        </div>
        <div class="col">
          <label for="" class="form-label">Select Type</label>
          <select id="" v-model="form.type" class="form-select form-select-lg" name="">
            <option value="">All</option>
            <option value="IPCR">IPCR</option>
            <option value="DPCR">DPCR</option>
            <option value="OPCR">OPCR</option>
          </select>
        </div>
        <div class="col">
          <label for="" class="form-label">Select Semester</label>
          <select id="" v-model="form.semester" class="form-select form-select-lg" name="">
            <option value="">All</option>
            <option value="FIRST">FIRST</option>
            <option value="SECOND">SECOND</option>
          </select>
        </div>
      </div>
      <button class="btn btn-primary mt-3" @click="filter">Filter</button>
    </div>

    <Link v-if="permission.includes('Add SPMS')" class="btn btn-secondary mt-3 ms-auto" :href="route('admin.spms.create')">Add SPMS Form <i class="fa-solid fa-plus" /></Link>

    <div class="mt-3">
      <div class="table-responsive">
        <table class="table table-bordered table-light">
          <thead>
            <tr>
              <th scope="col">NAME</th>
              <th scope="col">SEMESTER</th>
              <th scope="col">RATING</th>
              <th scope="col">ACTION</th>
            </tr>
          </thead>
          <tbody v-for="(user) in spmsByUser" :key="user.user_id" class=""> 
            <tr v-for="(semester, index) in user.semester" :key="semester.id">
              <td v-if="index === 0" :rowspan="user.semester.length">
                <b>{{ user.name }}</b>
              </td>
              <td><a :href="semester.src" target="_blank">{{ `${semester.year} ${semester.semester} SEMESTER ${semester.type}` }} <i class="fa-solid fa-up-right-from-square" /></a></td>
              <td>
                {{ semester.rating }}
                <b>
                  {{ semester.rating == 5 ? 'Outstanding' : null }}
                  {{ semester.rating < 5 && semester.rating >= 4 ? 'Very Satisfactory' : null }}
                  {{ semester.rating < 4 && semester.rating >= 3 ? 'Satisfactory' : null }}
                  {{ semester.rating < 3 && semester.rating >= 2 ? 'Unsatisfactory' : null }}
                  {{ semester.rating < 2 && semester.rating >= 1 ? 'Poor' : null }}
                </b>
              </td>
              <td>
                <Link v-if="permission.includes('Edit SPMS')" :href="route('admin.spms.edit', {spm: semester.id})" class="btn btn-success btn-sm"><i class="fa-solid fa-pen" /></Link>
                <Link v-if="permission.includes('Delete SPMS')" method="delete" as="button" :href="route('admin.spms.destroy', {spm: semester.id})" class="btn btn-danger btn-sm" type="button" :onBefore="() => confirm()"><i class="fa-solid fa-trash" /></Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <Pagination :links="spms.links" />
  </AdminLayout>
</template>
    
<script setup>
import Pagination from '@/Components/Pagination.vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import {Head, Link, useForm, usePage} from '@inertiajs/vue3'
import {computed} from 'vue'
  
const props = defineProps({
  spms: Object,
  years: Array,
  users: Array,
})

const confirm = () => window.confirm('Are you sure you want to delete this?')

const spmsByUser = computed(() => {
  const users = []
  props.spms.data.forEach(form => {
    const hasName = users.filter(user => user.user_id === form.user_id)
    if(hasName.length === 0){
      users.push({
        user_id: form.user_id,
        name: form.user.name,
        semester: props.spms.data.filter(f => f.user_id === form.user_id),
      })
    }
  })

  return users
})
  
const permission = usePage().props.auth.permissions.map(p => p.name)

const form = useForm({
  type: '',
  year: '',
  semester: '',
})


const filter = () => {
  form.get(route('admin.spms.index'), {
    preserveScroll: true,
    preserveState: true,
  })
}

</script>