<template>
  <div
    :id="props.modal_id"
    class="modal fade"
    :class="{'modal-xl': props.modalXl}"
    tabindex="-1"
    :aria-labelledby="props.modal_id + 'Label'"
    aria-hidden="true"
  >
    <div class="modal-dialog" :class="{'modal-max-width': props.modalMaxWidth}">
      <div class="modal-content">
        <div class="modal-header">
          <slot name="header" />
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          />
        </div>
        <div class="modal-body">
          <slot name="body" />
        </div>
      </div>
      <!-- <div class="modal-footer">
                <slot name="footer" />
            </div> -->
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  modal_id: String,
  modalXl: Boolean,
  modalMaxWidth: Boolean,
})
</script>
