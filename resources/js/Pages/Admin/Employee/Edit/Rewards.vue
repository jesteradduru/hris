

<template>
  <Layout :employee="props.employee.id">
    <Head title="Register" />
    <div class="container">
      <div class="card shadow">
        <div class="card-body">
          <Link :href="route('admin.employees.rewards.add', {employee: props.employee.id})" class="btn btn-primary">Add Reward</Link>
          <div class="table-responsive">
            <table class="table table-compact">
              <thead>
                <tr>
                  <th scope="col">Title</th>
                  <th scope="col">Points</th>
                  <th scope="col">Date Awarded</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in props.rewards" :key="item.id" class="">
                  <td scope="row">{{ item.reward.title }}</td>
                  <td>{{ item.reward.points }}</td>
                  <td>{{ moment(item.created_at).format('MMM D, YYYY') }}</td>
                  <td class="d-flex gap-2">
                    <Link class="btn btn-danger " method="delete" as="button" :href="route('admin.employees.rewards.destroy', {reward: item.id})">
                      <i class="bi-trash-fill" />
                    </Link>
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
import moment from 'moment'
import Layout from './Layout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  name: props.employee.name,
  username: props.employee.username,
  password: '',
  dtr_user_id: props.employee.dtr_user_id,
  password_confirmation: '',
  role: props.employee.role,
})

const props = defineProps({
  roles: Array,
  employee: Object,
  rewards: Array,
})

const submit = () => {
  form.post(route('admin.employees.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
    onSuccess: () => {
      form.reset()
    },
  })
}


    
</script>
