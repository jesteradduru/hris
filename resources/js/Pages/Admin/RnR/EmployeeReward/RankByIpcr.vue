<template>
  <EmployeeRewardLayout :reward="reward">
    <div v-for="division in divisions" :key="division.id">
      <h3>{{ division.abbreviation }}</h3>
      <ul>
        <li v-for="employee in division.employees" :key="employee.id">
          <h3>{{ employee.name }}</h3>
          <ul>
            <li v-for="ipcr in employee.spms" :key="ipcr.id">
              {{ ipcr.rating }}
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </EmployeeRewardLayout>
</template>

<script setup>
import EmployeeRewardLayout from '@/Pages/Admin/RnR/EmployeeReward/Layout/EmployeeRewardLayout.vue'

const props = defineProps({
  reward: Object,
  divisions: Array,
  years: Array,
})

</script>