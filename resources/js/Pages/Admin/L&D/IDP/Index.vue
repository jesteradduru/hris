<template>
  <Head title="Learning and Development" />
  <LndLayout>
    <div class="row">
      <div class="col-3">
        <div>
          <label for="" class="form-label">Search</label>
          <input
            id=""
            v-model="filterForm.name"
            type="text" class="form-control form-control-sm" name="" aria-describedby="helpId" placeholder="Name" @keyup="filter"
          />
        </div>
      </div>
      <div class="col-3">
        <div>
          <label for="" class="form-label">Year</label>
          <select id="" v-model="filterForm.year" class="form-select form-select-sm" name="" @change="filter">
            <option value="">All</option>
            <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
          </select>
        </div>
      </div>
      <div class="mt-2 mb-3">
        <button class="btn btn-secondary" @click="clearFilter">Clear filter</button>
      </div>
    </div>
    <div v-if="filterForm.processing">Loading...</div>
    <div class="table-responsive uppercase">
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th scope="col">NAME</th>
            <th scope="col">FORM</th>
            <th scope="col">ACCOMPLISHED</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="idp in props.idp_forms.data" :key="idp.key" class="">
            <td scope="row">{{ idp.user.name }}</td>
            <td>
              <a :href="idp.src" target="_blank">
                {{ `${idp.type} ${idp.year}` }}
              </a>
            </td>
            <td>
              <ul v-if="idp.idp_accomplishment.length">
                <li v-for="accomplishment in idp.idp_accomplishment" :key="accomplishment.id">
                  <a target="_blank" :href="accomplishment.src">{{ accomplishment.activity }}</a>
                </li>
              </ul>
              <Link 
                :href="route('admin.idp.edit', {idp: idp.id})"
                class="btn btn-secondary"
              >
                Edit Accomplishment
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-if="!props.idp_forms.length" class="text-center text-muted">No record found</div>
    <Pagination :links="props.idp_forms.links" />
  </LndLayout>
</template>
  
<script setup>
import {Head, useForm, Link} from '@inertiajs/vue3'
import LndLayout from '@/Pages/Admin/L&D/Layout/LndLayout.vue'
import { computed } from 'vue'
import moment from 'moment'
import {debounce} from 'lodash'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  idp_forms: Object,
  years: Array,
})

const filterForm = useForm({
  year: '',
  name: '',
})

const filter = debounce(() => {
  filterForm.get(route('admin.idp.index'), {
    preserveScroll: true,
    preserveState: true,
  })
}, 1000)

const clearFilter = () => {
  filterForm.year = ''
  filterForm.name = ''
  filter()
}

</script>