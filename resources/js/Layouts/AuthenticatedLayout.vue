<template>
  <div>
    <MainNavbar />
    <!-- Page Content -->
    <div class="row g-0">
      <div class="col-2 side-nav-col">
        <SideNav />
      </div>
      <div class="col bg-light min-vh-100">
        <div class="container-fluid pt-5 mt-4">
          <br />
          <slot />
          <br />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import MainNavbar from '@/Components/MainNavbar.vue'
import SideNav from '@/Components/SideNav.vue'
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


</script>import { forEach } from 'lodash'

