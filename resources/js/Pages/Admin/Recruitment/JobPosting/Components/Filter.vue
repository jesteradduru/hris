<template>
  <form @submit.prevent="filter">
    <div class="row g-3 align-items-center">
      <div class="col-auto">
        <label for="search" class="col-form-label">Search</label>
      </div>
      <div class="col-auto">
        <input
          id="search"
          v-model="filterForm.search"
          type="text"
          class="form-control"
        />
      </div>
      <div class="col-auto">
        <label for="search" class="col-form-label">Sort By</label>
      </div>
      <div class="col-auto">
        <div class="input-group flex-nowrap">
          <select
            id=""
            v-model="filterForm.order_by"
            name=""
            class="form-control"
          >
            <option value="posting_date">Posting Date</option>
            <option value="closing_date">Closing Date</option>
          </select>
          <select
            id=""
            v-model="filterForm.order"
            name=""
            class="form-control"
          >
            <option value="desc">Latest</option>
            <option value="asc">Oldest</option>
          </select>
        </div>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-dark ">
          Filter
        </button>
      </div>
      <div class="col-auto">
        <button
          type="reset"
          class="btn btn-secondary "
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
    route('admin.recruitment.job_posting.index', {
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
