<template>
  <div :id="accordionId" class="accordion">
    <div class="accordion-item">
      <h2 id="headingOne" class="accordion-header">
        <button
          class="accordion-button"
          :class="{collapsed: !collapsed}"
          type="button"
          data-bs-toggle="collapse"
          :data-bs-target="`#${accordionId}collapseOne`"
          aria-expanded="true"
          :aria-controls="`${accordionId}collapseOne`"
        >
          {{ accordionName }}
        </button>
      </h2>
      <div
        :id="`${accordionId}collapseOne`"
        class="accordion-collapse collapse"
        :class="{show: collapsed}"
        aria-labelledby="headingOne"
        :data-bs-parent="`#${accordionId}`"
      >
        <div class="accordion-body">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  accordionId: String,
  accordionName: String,
  collapsed: Boolean,
})
</script>