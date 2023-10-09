

<template>
  <ProfileLayout :employee="props.employee.id">
    <Head title="Add Reward" />
    <div class="container">
      <div class="card shadow">
        <div class="card-body">
          <Link :href="route('profile.rewards.index')" class="btn  btn-secondary"><i class="bi-arrow-left" /> Back</Link>
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
                    <Link method="post" as="button" :href="route('profile.rewards.store', {reward: item.id})" class="btn btn-success " @click="addReward">
                      Add
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
  </ProfileLayout>
</template>
  
<script setup>
import ProfileLayout from '../Layout/ProfileLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
  rewards : Array,
  employee: Object,
})

</script>
  