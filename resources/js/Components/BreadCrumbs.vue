<template>
  <div class="px-1" style="background: #e0e0e0;">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li
          v-for="(item, index) in props.crumbs"
          :key="index"
          class="breadcrumb-item"
          :class="{ active: item.link }"
        >
          <Link v-if="item.link" :href="item.link">
            {{
              item.label
            }}
          </Link>
          <span v-else>{{ item.label }}</span>
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
