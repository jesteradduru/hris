<template>
  <form @submit.prevent="filter">
    <div class="d-flex flex-column gap-2">
      <!-- Search Input -->
      <div class="input-group input-group-sm shadow-sm rounded">
        <span class="input-group-text bg-light border-end-0 text-muted">
          <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input
          id="search"
          v-model="filterForm.search"
          type="text"
          class="form-control border-start-0 ps-0 bg-light"
          placeholder="Search jobs..."
        />
      </div>
      
      <!-- Sorting Options -->
      <div class="d-flex gap-2">
        <select
          v-model="filterForm.order_by"
          class="form-select form-select-sm shadow-sm text-secondary"
        >
          <option value="posting_date">Posting Date</option>
          <option value="closing_date">Closing Date</option>
        </select>
        <select
          v-model="filterForm.order"
          class="form-select form-select-sm shadow-sm text-secondary"
          style="max-width: 100px;"
        >
          <option value="desc">Latest</option>
          <option value="asc">Oldest</option>
        </select>
      </div>
      
      <!-- Action Buttons -->
      <div class="d-flex gap-2 mt-1">
        <button type="submit" class="btn btn-primary btn-sm flex-grow-1 fw-medium shadow-sm">
          Apply Filter
        </button>
        <button
          type="button"
          class="btn btn-light btn-sm flex-grow-1 border fw-medium shadow-sm"
          @click="resetFilter"
        >
          Reset
        </button>
      </div>
    </div>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  filters: Object,
})

const filterForm = useForm({
  search: props.filters.search,
  order_by: props.filters.order_by ?? 'posting_date',
  order: props.filters.order ?? 'desc',
})

const filter = () =>
  filterForm.get(
    route('recruitment.job_posting.index', {
      preserveState: true,
      preserveScroll: true,
    }),
  )
const resetFilter = () => {
  filterForm.search = null
  filterForm.order_by = 'posting_date'
  filterForm.order = 'desc'
  filter()
}
</script>
