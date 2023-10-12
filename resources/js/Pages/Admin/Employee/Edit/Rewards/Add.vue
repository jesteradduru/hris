

<template>
  <Layout :employee="props.employee.id">
    <Head title="Register" />
    <div class="container">
      <div class="card shadow">
        <div class="card-body">
          <Link :href="route('admin.employees.rewards.edit', {employee: props.employee.id})" class="btn  btn-secondary"><i class="fa-solid fa-arrow-left" /> Back</Link>
          <div class="table-responsive">
            <table class="table table-compact">
              <thead>
                <tr>
                  <th scope="col">Title</th>
                  <th scope="col">Points</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in props.rewards.data" :key="item.id" class="">
                  <td scope="row">{{ item.title }}</td>
                  <td>{{ item.points }}</td>
                  <td class="d-flex gap-2">
                    <button :data-id="item.id" class="btn btn-success " @click="addReward">
                      Add
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- <div v-if="props.rewards.length === 0" class="text-center text-muted">No Records</div>
              <Pagination v-if="props.rewards.length > 15" :links="props.rewards.links" /> -->
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>
  
<script setup>
import Layout from '../Layout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  name: props.employee.name,
  username: props.employee.username,
  password: '',
  dtr_user_id: props.employee.dtr_user_id,
  role: props.employee.role,
})
  
const props = defineProps({
  rewards: Array,
  employee: Object,
})
  
const addReward = (e) => {
  const reward_id = e.target.getAttribute('data-id')

  form.post(route('admin.employees.rewards.store', {
    user: props.employee.id,
    reward_id: reward_id,
  }))
}
  
  
      
</script>
  