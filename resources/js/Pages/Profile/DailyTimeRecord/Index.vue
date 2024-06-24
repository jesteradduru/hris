<template>
  <Head title="DTR" />  
  <AuthenticatedLayout>
    <h3>Daily Time Record</h3>
    <div class="mb-3">
      <input id="" v-model="filter.month" type="month" name="" class="form-control" @change="onChangeMonth" />
    </div>
    <div v-if="props.suggestions" class="mb-3 text-center">
      <br /> 
      <b>Today, you are expected to have rendered at least	<span class="text-danger">{{ props.suggestions.hours_to_render }} hours</span>. </b>
      <br />
      <b>The suggested time to logout is <span class="text-danger">{{ props.suggestions.timeout }}</span></b>
      <br />
      <!-- <b v-if="seconds > 0"><span class="text-danger">{{ time_remaining }}</span> remaining</b>
      <b v-else>You have successfully rendered <span class="text-success"> {{ props.suggestions.hours_to_render }} hours</span>.</b> -->
    </div>
    <div class="table-responsive container" :style="{position: 'relative'}">
      <div v-if="filter.processing" class="center-element">
        <div
          class="spinner-border text-primary spinner-border-lg"
          role="status"
        >
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <!-- Daily Time Record table -->
      <table class="w-100 text-center dtr-table" :style="{opacity: filter.processing ? 0.2 : 1}">
        <thead>
          <tr>
            <td rowspan="2">#</td>
            <td rowspan="2">Day</td>
            <td colspan="2">Morning</td>
            <td colspan="2">Afternoon</td>
            <td rowspan="2">Total Hours</td>
            <td rowspan="2">Remarks</td>
          </tr>
          <tr>
            <td>In</td>
            <td>Out</td>
            <td>In</td>
            <td>Out</td>
          </tr>
        </thead>
        <tbody>
          <!-- Loop through days in the selected month -->
          <tr v-for="(record) in records" :key="record.date">
            <td>{{ record.date }}</td>
            <td>{{ record.day }}</td>
            <td>
              <b>
                <Link v-if="showAwa(record.date) && !record.inAM" :href="route('daily_time_record.store')" method="post" as="button">Time-In</Link>
                {{ record.inAM }}</b>
            </td>
            <td>
              <Link v-if="showAwa(record.date) && !record.outAM && record.inAM" :href="route('daily_time_record.store')" method="post" as="button">Time-Out</Link>
              <b>{{ record.outAM }}</b>
            </td>
            <td>
              <Link v-if="showAwa(record.date) && !record.inPM && record.outAM " :href="route('daily_time_record.store')" method="post" as="button">Time-In</Link>
              <b>{{ record.inPM }}</b>
            </td>
            <td>
              <Link v-if="showAwa(record.date) && !record.outPM && record.inPM" :href="route('daily_time_record.store')" method="post" as="button">Time-Out</Link>
              <b>{{ record.outPM }}</b>
            </td>
            <td>
              <b>{{ record.totalHours }}</b>
            </td>
            <td>{{ record.remarks }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import {Head, Link} from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { debounce } from 'lodash'
import moment from 'moment'
import { computed, onMounted, ref } from 'vue'


const props = defineProps({
  records: Array,
  filters: Object,
  suggestions: Object,
})

const seconds = ref(props.suggestions.hours_remaining)
const time_remaining = computed(() => {
  var duration =  moment.utc(seconds.value * 1000).format('HH:mm:ss')
  return duration
})

const filter = useForm({
  month: props.filters.month ?? moment().format('YYYY-MM'),
})

const onChangeMonth = debounce(() => {
  filter.get(route('daily_time_record.index'), {
    preserveState: true,
    preserveScroll: true,
  })
}, 1500)

// Function to update currentTime every second
const updateTime = () => {
  seconds.value -= 1
}

// Lifecycle hook to start updating currentTime when component is mounted
onMounted(() => {
  // Update currentTime immediately upon mounting
  updateTime()

  // Set up interval to update currentTime every second
  setInterval(updateTime, 1000)
})

</script>


<style>
.dtr-table, .dtr-table th, .dtr-table td {
  border: 1px solid black;
  border-collapse: collapse;
}</style>