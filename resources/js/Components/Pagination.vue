<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  links: Array,
})
</script>

<template>
  <ul class="pagination pagination-sm justify-content-center mb-0 gap-1">
    <li
      v-for="(link, index) in links"
      :key="index"
      class="page-item"
      :class="{ active: link.active }"
    >
      <Link
        preserve-scroll
        :href="link.url ? link.url : '#'"
        class="page-link rounded-pill border-0 px-3 fw-medium"
        :class="link.active ? 'bg-primary text-white shadow-sm' : 'text-secondary bg-light'"
        v-html="link.label"
      />
    </li>
  </ul>
</template>
