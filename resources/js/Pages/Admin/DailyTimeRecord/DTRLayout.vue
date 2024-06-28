<template>
  <Head title="Daily Time Record" />
      
  <AdminLayout fluid>
    <BreadCrumbs :crumbs="crumbs" />
    <h3>Daily Time Record</h3>
    <div class="row">
      <div class="col-2">
        <div class=" p-2">
          <div class="nav-item">
            <Link
              class="" :href="route('admin.dtr.dtr.index')" :class="{'dtr-active': route().current(
                'admin.dtr.dtr.index'
              )}"
            >
              DTR Logs
            </Link>
          </div>
          <div class="nav-item">
            <Link
              class="" :href="route('admin.dtr.dtr.create')" :class="{'dtr-active': route().current(
                'admin.dtr.dtr.*'
              )}"
            >
              HR Timesheet Entry
            </Link>
          </div>
          <div class="nav-item">
            <Link
              class="" :href="route('admin.dtr.index')" :class="{'dtr-active': route().current(
                'admin.dtr.index'
              )}"
            >
              Export Monthly DTR
            </Link>
          </div>
        </div>
      </div>
      <div class="col-10">
        <slot />
      </div>
    </div>
  </AdminLayout>
</template>
      
<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
    

const props = defineProps({
  crumbs: Array,
})
    
    
      
</script>
      