<template>
  <RolePermissionLayout>
    <template #header>
      <BreadCrumbs :crumbs="crumbs" />
    </template>
    <form @submit.prevent="update">
      <div class="form-group mb-3">
        <label for="" class="input-label">Role name</label>
        <input
          id=""
          v-model="form.role_name"
          type="text"
          name=""
          class="form-control"
        />
        <InputError :message="form.errors.role_name" />
      </div>
      <h4>Permissions</h4>
      <div class="mb-3">
        <div class="form-check">
          <input
            id="all"
            class="form-check-input"
            type="checkbox"
            @change="selectAll"
          />
          <label
            class="form-check-label"
            for="all"
          >
            Select All
          </label>
        </div>
        <div
          v-for="permission in props.all_permissions"
          :key="permission.id"
          class="form-check"
        >
          <input
            :id="`permissionId${permission.id}`"
            class="form-check-input chk-others"
            type="checkbox"
            :value="permission.name"
            :checked="form.permissions?.includes(permission.name)"
            @change="togglePermission"
          />
          <label
            class="form-check-label"
            :for="`permissionId${permission.id}`"
          >
            {{ permission.name }}
          </label>
        </div>
      </div>
      <button type="submit" class="btn btn-success">Update</button>
    </form>
  </RolePermissionLayout>
</template>

<script setup>
import RolePermissionLayout from '@/Pages/Admin/RolePermission/Layout/RolePermissionLayout.vue'
import { useForm } from '@inertiajs/vue3'
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
    link: route('admin.role_permission.role.index'),
  },
  {
    label: props.role.name,
  },
])

const props = defineProps({
  role: Object,
  all_permissions: Array,
})

const form = useForm({
  role_name: props.role.name,
  permissions: props.role.permissions.map((perm) => perm.name),
})

const togglePermission = (e) => {
  if (e.target.checked) {
    if (!form.permissions.includes(e.target.value)) {
      form.permissions.push(e.target.value)
    }
  } else {
    form.permissions = form.permissions.filter(
      (perm) => perm !== e.target.value,
    )
  }
}

const update = () =>
  form.put(
    route('admin.role_permission.role.update', { role: props.role.id }),
  )

const selectAll = (e) => {
  const chkboxes = document.querySelectorAll('.chk-others')
  
  if(!e.target.checked){
    chkboxes.forEach(chk => {
      chk.checked = false
      form.permissions.push(chk.value)
    })
  }else{
    chkboxes.forEach(chk => {
      chk.checked = true
      form.permissions.push(chk.value)
    })
  }
}
</script>
