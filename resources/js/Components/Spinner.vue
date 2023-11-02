<template>
  <div
    v-if="processing"
    class="spinner-border spinner-border-sm"
    role="status"
  >
    <span class="visually-hidden">Loading...</span>
  </div>
  <span v-if="processing">{{ text }}</span>
</template>

<script setup>
defineProps({
  processing: Boolean,
  text: String,
})
</script>
