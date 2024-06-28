

<template>
  <AdminLayout>
    <Head title="Register" />
    <div class="container">
      <h3>{{ reward.title }} Awardees</h3>
      <BreadCrumbs :crumbs="crumbs" />
      <!-- Nav tabs -->
      <ul id="myTab" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button
            id="home-tab"
            class="nav-link active"
            data-bs-toggle="tab"
            data-bs-target="#home"
            type="button"
            role="tab"
            aria-controls="home"
            aria-selected="true"
          >
            All
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <Link
            :href="route('admin.employees.rewards.rank_by_ipcr', {reward: reward.id, division: 'All'})"
            class="nav-link"
          >
            PERFORMANCE RANKING
          </Link>
        </li>
      </ul>
      
      <div class="row mt-3">
        <div class="col-4">
          <input
            id=""
            v-model="filterForm.name"
            type="text" class="form-control form-control-sm" name="" aria-describedby="helpId" placeholder="Search Name"
          />
        </div>
        <div class="col-4">
          <div class="d-flex gap-2">
            <label for="" class="form-label">Division</label>
            <select id="division" v-model="filterForm.division" class="form-select form-select-sm" name="">
              <option value="" selected>All</option>
              <option v-for="division in divisions" :key="division.id" :value="division.id">
                {{ 
                  division.name }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-1 d-flex gap-2">
          <button class="btn btn-dark btn-sm" @click="onFilter">Filter</button>
          <button class="btn btn-secondary btn-sm" @click="onReset">Reset</button>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-compact">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Division</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in props.employees.data" :key="item.id" class="">
              <td scope="row">{{ item.name }}</td>
              <td scope="row">{{ item.division?.abbreviation }}</td>
              <td class="d-flex gap-2">
                <button :data-id="item.id" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addReward" @click="() => onSelectUser(item)">
                  Add
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="props.employees.data === 0" class="text-center text-muted">No Records</div>
        <Pagination :links="props.employees.links" />
      </div>
    </div>
    <Modal modal_id="addReward">
      <template #header>Add Reward</template>
      <template #body>
        <div class="form-group mb-2">
          <div class="form-text">Award</div>
          <input
            id=""
            :value="reward.title"
            type="text" class="form-control form-control-sm" name="" aria-describedby="helpId"
            disabled
          />
        </div>
        <div class="form-group mb-2">
          <label for="" class="form-text">Awarded To</label>
          <input
            id=""
            :value="awardForm.user?.name"
            type="text" class="form-control form-control-sm" name="" aria-describedby="helpId" disabled
            required
          />
        </div>
        <div class="form-group mb-2">
          <label for="" class="form-text">Date Awarded:</label>
          <input
            id=""
            v-model="awardForm.dateAwarded"
            type="date" class="form-control form-control-sm" name="" aria-describedby="helpId"
          />
          <InputError :message="awardForm.errors.date_awarded" />
        </div>
        <button class="btn btn-sm btn-success" @click="addReward">Save</button>
      </template>
    </Modal>
  </AdminLayout>
</template>
    
<script setup>
import BreadCrumbs from '@/Components/BreadCrumbs.vue'
import AdminLayout from '@/Pages/Admin/Layout/AdminLayout.vue'
import { Head, router, useForm, Link } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import Pagination from '@/Components/Pagination.vue'
import Modal from '@/Components/Modal.vue'
import InputError from '@/Components/InputError.vue'
  
const props = defineProps({
  employees: Object,
  reward: Object,
  divisions: Array,
})

const awardForm = useForm({
  user: null, 
  dateAwarded: null,
})


const onSelectUser = (data) => {
  awardForm.user = data
}

const filterForm = useForm({
  name: '',
  division: '',
})

const onFilter = () => {
  filterForm.get(route('admin.employees.rewards.create',{reward: props.reward.id}), {
    preserveScroll: true,
    preserveState: true,
  })
}

const onReset = () => {
  filterForm.name = ''
  filterForm.division = ''
  filterForm.get(route('admin.employees.rewards.create',{reward: props.reward.id}), {
    preserveScroll: true,
    preserveState: true,
  })
}

const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Rewards and Recognition',
    link: route('admin.rewards.index'),
  },
  {
    label: props.reward.title,
    link: route('admin.rewards.show', {reward: props.reward.id}),
  },
  {
    label: 'Add Awardees',
  },
])

const addReward = (e) => {
  const employee_id = awardForm.user.id

  awardForm.post(route('admin.employees.rewards.store', {
    user: employee_id,
    reward_id: props.reward.id,
    date_awarded: awardForm.dateAwarded,
  }), {
    onSuccess: () => {
      awardForm.user = null
      awardForm.dateAwarded = null
    },
  })
}
  
    
        
</script>
