<template>
  <AuthenticatedLayout>
    <h3>Rewards and Recognition</h3>
    <Link v-if="permission.includes('Add Reward')" :href="route('profile.rewards.create')" class="btn btn-primary">Add reward</Link>
    <div v-if="props.rewards.length > 0" class="table-responsive">
      <table class="table table-bordered mt-3 table-sm">
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
              <Link v-if="permission.includes('Delete Reward')" :onBefore="confirm" class="btn btn-danger btn-sm" method="delete" as="button" :href="route('profile.rewards.destroy', {reward: item.id})">
                <i class="fa-solid fa-trash" />
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else class="text-center bg-light mt-4 p-4 rounded">
      No Records
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link, usePage } from '@inertiajs/vue3'
import moment from 'moment'

const props = defineProps({
  rewards: Array,
})

const permission = usePage().props.auth.permissions.map(p => p.name)

const confirm = () => {
  return window.confirm('Are you sure to delete this reward?')
}
</script>