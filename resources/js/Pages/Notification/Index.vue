<template>
  <AuthenticatedLayoutVue>
    <h1 class="text-3xl mb-4">Your Notifications</h1>
    
    <section v-if="notifications.data.length" class="">
      <div v-for="notification in notifications.data" :key="notification.id" :class="{'alert-primary': !notification.read_at, 'alert-secondary': notification.read_at}" class="alert">
        <div class="alert-body d-flex justify-content-between align-items-center">
          <div>
            <span v-if="notification.type === 'App\\Notifications\\PublishApplicationResult'">
              {{ notification.data.message }}
              <Link :href="route('job_application.show', {job_application: notification.data.result?.application_id })">See details</Link>
            </span>
          </div>
          <div>
            <Link v-if="!notification.read_at" method="put" as="button" :href="route('notification.seen', { notification: notification.id})" class="btn btn-primary">
              Mark as read
            </Link>
          </div>
        </div>
      </div>
    </section>
    <div v-else>No notifications yet!</div>
    
    <section
      v-if="notifications.data.length" 
      class="w-full flex justify-center mt-8 mb-8"
    >
      <Pagination :links="notifications.links" />
    </section>
  </AuthenticatedLayoutVue>
</template>
    
<script setup>
import Pagination from '@/Components/Pagination.vue'
import { Link, usePage } from '@inertiajs/vue3'
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue'
defineProps({
  notifications: Object,
})
</script>