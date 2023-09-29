<template>
  <RolePermissionLayout>
    <template #header>
      <BreadCrumbs :crumbs="crumbs" />
    </template>
    <!-- <div class="table-reponsive"> -->
    <button
      class="btn btn-primary"
      data-bs-toggle="modal"
      data-bs-target="#addRoleModal"
    >
      Create Role
    </button>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="role in roles.data" :key="role.id">
          <td>{{ role.name }}</td>
          <td class="d-flex gap-2">
            <Link
              class="btn btn-success btn-sm"
              :href="
                route('admin.role_permission.role.edit', {
                  role: role.id
                })
              "
            >
              <i class="fa-solid fa-pencil" />
            </Link>
            <Link
              class="btn btn-danger btn-sm"
              method="delete"
              :href="
                route('admin.role_permission.role.destroy', {
                  role: role.id
                })
              "
              as="button"
            >
              <i class="fa-solid fa-trash" />
            </Link>
          </td>
        </tr>
      </tbody>
    </table>
    <Pagination :links="roles.links" />
    <!-- </div> -->
  </RolePermissionLayout>
  <Modal modal_id="addRoleModal">
    <template #header>Create Role</template>
    <template #body>
      <form @submit.prevent="addRole">
        <div class="form-group">
          <label for="" class="input-label">Role Name</label>
          <input
            id=""
            v-model="addForm.role_name"
            type="text"
            name=""
            class="form-control"
          />
          <InputError :message="addForm.errors.role_name" />
        </div>
        <div class="mt-3">
          <button
            type="submit"
            class="btn btn-primary"
            :class="{ 'opacity-25': addForm.processing }"
            :disabled="addForm.processing"
          >
            <Spinner :processing="addForm.processing" /> Save
          </button>
        </div>
      </form>
    </template>
  </Modal>
</template>

<script setup>
import RolePermissionLayout from '@/Pages/Admin/RolePermission/Layout/RolePermissionLayout.vue'
import Modal from '@/Components/Modal.vue'
import Spinner from '@/Components/Spinner.vue'
import Pagination from '@/Components/Pagination.vue'
import { useForm, Link } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import { computed } from 'vue'

const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Roles and Permission',
  },
  {
    label: 'Roles',
  },
])

const props = defineProps({
  roles: Object,
})

const addForm = useForm({
  role_name: null,
})

const addRole = () =>
  addForm.post(route('admin.role_permission.role.store'), {
    onSuccess: () => {
      addForm.role_name = null
    },
  })
</script>
