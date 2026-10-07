<template>
  <div class="px-0 py-1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li
          v-for="(item, index) in props.crumbs"
          :key="index"
          class="breadcrumb-item small"
          :class="{ active: item.link }"
        >
          <Link v-if="item.link" :href="item.link" class="text-decoration-none text-muted">
            {{
              item.label
            }}
          </Link>
          <span v-else class="text-dark fw-medium">{{ item.label }}</span>
        </li>
      </ol>
    </nav>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
const props = defineProps({
  crumbs: Array,
})
</script>
