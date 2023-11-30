<template>
  <div v-if="lists.length" class="d-flex gap-2 flex-wrap">
    <span v-for="(list, index) in trimmedList" :key="index" class="badge bg-dark">{{ list }}</span>
  </div>
</template>
  
<script setup>
import { computed } from 'vue'

const props = defineProps({
  lists: Array,
})

const trimmedList = computed(() => {
  return props.lists.filter((list) => {
    const trimList = list.trim()
    return trimList !== ''
  })
})
</script>