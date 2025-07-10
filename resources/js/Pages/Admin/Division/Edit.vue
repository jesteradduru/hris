<template>
  <AdminLayout>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>Edit Division</h3>
    <form action="">
      <div class="mb-3">
        <label for="" class="form-label">Division</label>
        <input
          id=""
          v-model="editForm.name"
          type="text"
          class="form-control"
          name=""
          aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="editForm.errors.name" />
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Abbreviation</label>
        <input
          id=""
          v-model="editForm.abbreviation"
          type="text"
          class="form-control"
          name=""
          aria-describedby="helpId"
          placeholder=""
        />
        <InputError :message="editForm.errors.abbreviation" />
      </div>
      <br />
      <button type="submit">Save</button>
    </form>

    <!-- <hr />
    <div
      class="table-responsive"
    >
      <table
        class="table table-striped table-hover table-borderless align-middle"
      >
        <thead class="table-light">
          <caption class="w-100 d-block">
            Division Chief Appointment History
          </caption>
          <button class="btn btn-sm btn-success">Assign New Chief</button>
          <tr>
            <th>Name</th>
            <th>Appointment Start Date</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          <tr v-for="chief in division.chief" :key="chief.user.id">
            <td scope="row">{{ chief.user.name }}</td>
            <td>{{ moment(chief.start_date).format('MMM d, Y') }}</td>
          </tr>
        </tbody>
        <tfoot />
      </table>
    </div> -->
  </AdminLayout>
</template>

<script setup>
import InputError from '@/Components/InputError.vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import moment from 'moment'

const editForm = useForm({
  name: props.division.name,
  abbreviation: props.division.abbreviation,
})

const props = defineProps({
  users: Array,
  division: Object,
})

const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Division',
    link: route('admin.divisions.index'),
  },
  {
    label: 'Edit',
  },
])



</script>