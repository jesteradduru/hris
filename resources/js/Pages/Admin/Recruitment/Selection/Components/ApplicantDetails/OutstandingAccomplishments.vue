<template>
  <div class="mb-3">
    <h5 class="text-primary">Outstanding Accomplishments</h5>
    <!-- <div v-if="plantilla" class="alert alert-primary">
        <div>
          <b>Training Requirement</b>
        </div>
        {{ plantilla.training }}
      </div> -->
    <div class="table-responsive">
      <table class="table table-sm table-bordered mt-3">
        <thead>
          <tr>
            <th scope="col">ACCOMPLISHMENTS</th>
            <th scope="col">DATE AWARDED</th>
          </tr>
        </thead>
        <tbody style="text-transform: uppercase;">
          <tr>
            <td>Sample</td>
            <td>September 1, 2020</td>
            <td />
          </tr>
        </tbody>
      </table>
      <!-- <div v-if="!props.lnds.length" class="text-center">No records to display</div> -->
    </div>
  </div>
</template>
      
<script setup>
      
import {  computed } from 'vue'

const props = defineProps({
  withControls: Boolean,
})
  
</script>