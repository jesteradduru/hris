<template>
  <div class="card">
    <div class="card-body">
      <div class="card-title">
        <h5 class="text-primary"><slot name="header" /></h5>
      </div>
      <slot />
    </div>
  </div>
</template>