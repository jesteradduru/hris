<template>
  <div>
    <div class="container-fluid">
      <AdminMainNavbar />
      <!-- Page Heading -->
      <header v-if="$slots.header" class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" />
      </header>

      <!-- Page Content -->
      <main>
        <div :class="`${fluid ? 'container-fluid' : 'container'} mt-3`">
          <Notifications :flash="$page.props.flash" />
          <slot />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import Notifications from '@/Components/Notifications.vue'
import AdminMainNavbar from '../Components/AdminMainNavbar.vue'

defineProps({
  fluid: Boolean,
})
</script>
