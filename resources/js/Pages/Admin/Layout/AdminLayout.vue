<template>
  <div class="min-vh-100 bg-light d-flex flex-column">
    <div class="container-fluid px-3 px-md-4 pt-3">
      <AdminMainNavbar />
    </div>

    <!-- Page Content -->
    <main class="main flex-grow-1">
      <div :class="`${fluid ? 'container-fluid px-3 px-md-4' : 'container'} py-3`">
        <slot />
      </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-4 bg-white border-top">
      <div class="container-fluid text-center">
        <p class="text-muted small mb-0">
          &copy; 2023 - {{ moment().format('Y') }} | 
          <a target="_blank" href="https://dro2.depdev.gov.ph" class="text-decoration-none fw-medium text-primary">
            Department of Economy, Planning, and Development Region 2
          </a>
        </p>
      </div>
    </footer>
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
