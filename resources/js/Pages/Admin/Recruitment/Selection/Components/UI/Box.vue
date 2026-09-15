<template>
  <div class="card border-0 shadow-sm rounded-3 bg-white mb-4 transition-all">
    <div class="card-header bg-white border-bottom py-3 px-3">
      <h6 class="fw-bold mb-0 text-primary text-uppercase d-flex align-items-center gap-2">
        <slot name="header" />
      </h6>
    </div>
    <div class="card-body p-3">
      <slot />
    </div>
  </div>
</template>