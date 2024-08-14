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
          <slot />
        </div>
      </main>

      <footer class="footer text-center rounded shadow p-1 mt-5">
        <div><small>&copy; 2023 - {{ moment().format('Y') }} | <a target="_blank" href="https://neda.rdc2.gov.ph">NATIONAL ECONOMIC DEVELOPMENT AUTHORITY REGION 2</a></small></div>
      </footer>
    </div>
  </div>
</template>

<script setup>
import AdminMainNavbar from '../Components/AdminMainNavbar.vue'
import moment from 'moment'
import {usePage} from '@inertiajs/vue3'
import { watch} from 'vue'
import Swal from 'sweetalert2'
import flasher from '@flasher/flasher'

const page = usePage()

watch(() => page.props.messages, (value) => {
  value.envelopes.forEach((val) => {
    if(val.handler === 'flasher'){
      flasher.render(value)
    }else{
      Swal.fire({
        title:  val.notification.title,
        text: val.notification.message,
        icon: val.notification.options.icon,
        timerProgressBar: true,
      })
    }
  })
})


defineProps({
  fluid: Boolean,
})
</script>
