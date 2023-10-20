<template>
  <RolePermissionLayout>
    <template #header>
      <BreadCrumbs :crumbs="crumbs" />
    </template>
    <button
      class="btn btn-primary"
      data-bs-toggle="modal"
      data-bs-target="#addRoleModal"
    >
      Create Permission
    </button>
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="permission in props.permissions.data" :key="permission.id">
          <td>{{ permission.name }}</td>
          <td class="d-flex gap-2">
            <Link
              :href="
                route('admin.role_permission.permission.edit', {
                  permission: permission.id
                })
              "
              class="btn btn-success btn-sm"
            >
              <i class="fa-solid fa-pencil" />
            </Link>
            <Link
              class="btn btn-danger btn-sm"
              method="delete"
              :href="
                route(
                  'admin.role_permission.permission.destroy',
                  { permission: permission.id }
                )
              "
              as="button"
            >
              <i class="fa-solid fa-trash" />
            </Link>
          </td>
        </tr>
      </tbody>
    </table>
    <Pagination :links="permissions.links" />
    <!-- </div> -->
  </RolePermissionLayout>
  <Modal modal_id="addRoleModal">
    <template #header>Create Permission</template>
    <template #body>
      <form @submit.prevent="addPermission">
        <div class="form-group">
          <label for="" class="input-label">Permission Name</label>
          <input
            id=""
            v-model="addForm.permission_name"
            type="text"
            name=""
            class="form-control"
          />
          <InputError :message="addForm.errors.permission_name" />
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
    label: 'Permissions',
  },
])

const props = defineProps({
  permissions: Object,
})

const addForm = useForm({
  permission_name: null,
})

const addPermission = () =>
  addForm.post(route('admin.role_permission.permission.store'), {
    onSuccess: () => {
      addForm.permission_name = null
    },
  })
</script>
