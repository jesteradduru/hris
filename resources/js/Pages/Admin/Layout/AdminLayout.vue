<template>
  <div>
    <div class="container-fluid">
      <AdminMainNavbar />
      <!-- Page Heading -->
      <header v-if="$slots.header" class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" />
      </header>

      <!-- Page Content -->
      <main class="main">
        <div :class="`${fluid ? 'container-fluid' : 'container'} mt-3`">
          <Notifications :flash="$page.props.flash" />
          <slot />
        </div>
      </main>

      <footer class="footer text-center bg-dark rounded shadow p-3 text-light mt-5">
        <div>NEDA RO2 ICT</div>
        <div>ALL RIGHTS RESERVED {{ moment().format('Y') }}</div>
      </footer>
    </div>
  </div>
</template>

<script setup>
import Notifications from '@/Components/Notifications.vue'
import AdminMainNavbar from '../Components/AdminMainNavbar.vue'
import moment from 'moment'
import {usePage} from '@inertiajs/vue3'
import { watch} from 'vue'
import Swal from 'sweetalert2'

const page = usePage()

watch(() => page.props.messages, (value) => {
  value.envelopes.forEach((val) => {
    Swal.fire({
      title:  val.notification.title,
      text: val.notification.message,
      icon: val.notification.options.icon,
      timerProgressBar: true,
    })
  })
})


defineProps({
  fluid: Boolean,
})
</script>
