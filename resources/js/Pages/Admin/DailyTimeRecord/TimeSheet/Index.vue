<template>
  <Head title="Daily Time Record" />
        
  <DTRLayout :crumbs="crumbs">
    <div class="d-flex gap-2">
      <div>
        <Link class="btn btn-secondary btn-sm" :href="route('admin.dtr.dtr.create')"><i class="fa-solid fa-arrow-left" /></Link>
      </div>
      <h3>{{ timesheet_draft.name }}</h3>
    </div>
    <br />
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>
            <input id="" type="checkbox" name="" />
          </th>
          <th>Employee</th>
          <th>Purpose</th>
          <th>Pass Type</th>
          <th>Date (mm/dd/yyyy)</th>
          <th>Duration</th>
          <th>Remarks</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="entry in timesheet_draft.entries" :key="entry.id">
          <td><input id="" type="checkbox" name="" /></td>
          <td>{{ entry.user.name }}</td>
          <td v-if="entry.purpose === 'pass'">Pass Slip</td>
          <td v-else-if="entry.purpose === 'supp'">Supplementary</td>
          <td v-else-if="entry.purpose === 'off'">Official</td>
          <td>
            <span v-if="entry.pass_type == 'personal'">Personal</span>
            <span v-else-if="entry.pass_type == 'official'">Official</span>
            <span v-else class="badge badge-secondary">-</span>
          </td>
          <td>
            <span v-if="entry.date">{{ getDate(entry.date) }}</span>
            <span v-else class="badge badge-secondary">-</span>
          </td>
          <td>
            <div v-if="entry.purpose === 'pass'">
              <span class="badge badge-danger">DEPARTURE {{ get12hr(entry.pass_out) }}</span>
              <span class="badge badge-success">RETURN {{ get12hr(entry.pass_in) }}</span>
            </div>
            <div v-else-if="entry.purpose === 'supp'">
              <span class="badge badge-success">{{ get12hr(entry.supp_am_in) }}</span>
              <span class="badge badge-danger">{{ get12hr(entry.supp_am_out) }}</span>
              <span class="badge badge-success">{{ get12hr(entry.supp_pm_in) }}</span>
              <span class="badge badge-danger">{{ get12hr(entry.supp_pm_out) }}</span>
            </div>
            <div v-else-if="entry.eo_sched_type == 'PARTIAL'">
              <div class="badge badge-success ">{{ get12hr(entry.eo_start) }}</div>
              <div class="badge badge-success ">{{ get12hr(entry.eo_end) }}</div>
            </div>
            <div v-else-if="entry.off_hours">
              <div class="badge badge-success ">{{ entry.off_hours }} HOURS</div>
            </div>
            <div v-else-if="entry.remarks === 'STUDY_LEAVE' || entry.remarks === 'ON_SCHOLARSHIP'">
              <div class="badge badge-success ">{{ getDate(entry.off_start) }}</div>
              <div class="badge badge-danger ">{{ getDate(entry.off_end) }}</div>
            </div>
            <div v-else class="badge badge-secondary">-</div>
          </td>
          <!-- <td v-else-if="entry.purpose === 'off'">Official Travel, Leave, Holiday, Tardy, WFH</td> -->
          <td>
            <span v-if="entry.remarks"> {{ entry.remarks }}</span>
            <span v-else class="badge badge-secondary">-</span>
          </td>
          <td>
            <button class="btn btn-sm btn-success"><i class="fa-solid fa-pen" /></button>
            <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash" /></button>
          </td>
        </tr>
      </tbody>
    </table>
    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addRow"><i class="fa-solid fa-plus" /> Add row</button>
    <button class="btn btn-sm btn-warning"><i class="fa-solid fa-save" /> Clear selected</button>
    <button class="btn btn-sm btn-primary"><i class="fa-solid fa-save" /> Save all Entries</button>

    <Modal modal_id="addRow">
      <template #header>
        <h3>Add Entry</h3>
      </template>
      <template #body>
        <!-- EMPLOYEE -->
        <div class="mb-3">
          <label for="" class="form-label">Employee</label>
          <select
            id=""
            v-model="entryForm.employee"
            class="form-select form-select-lg"
            name=""
          >
            <option value="">Select one</option>
            <option value="0">All</option>
            <option v-for="employee in employees" :key="employee.id" :value="employee.id">{{ employee.name }}</option>
          </select>
          <InputError :message="entryForm.errors.employee" />
        </div>
        <!-- PURPOSE -->
        <div class="mb-3">
          <label for="" class="form-label">Purpose</label>
          <select
            id=""
            v-model="entryForm.purpose"
            class="form-select form-select-lg"
            name=""
          >
            <option value="">Select one</option>
            <option value="pass">Pass Slip</option>
            <option value="supp">Supplementary [ Security guard Log ]</option>
            <option value="off">Official Travel, Leave, Holiday, Tardy, WFH</option>
          </select>
          <InputError :message="entryForm.errors.purpose" />
        </div>
        <!-- DATE -->
        <div v-if="entryForm.purpose">
          <!-- PASS SLIP -->
          <div v-if="entryForm.purpose === 'pass'" class="mb-3">
            <div class="form-check form-check-inline">
              <input
                id="passper"
                v-model="entryForm.pass_type"
                class="form-check-input"
                type="radio"
                name="pass"
                value="personal"
              />
              <label class="form-check-label" for="passper">Personal</label>
            </div>
            <div class="form-check form-check-inline">
              <input
                id="passoff"
                v-model="entryForm.pass_type"
                class="form-check-input"
                type="radio"
                name="pass"
                value="official"
              />
              <label class="form-check-label" for="passoff">Official</label>
            </div>
          </div>
          <!-- DATE -->
          <div v-if="entryForm.remarks != 'STUDY_LEAVE' && entryForm.remarks != 'ON_SCHOLARSHIP'" class="mb-3">
            <label for="" class="form-label">Date</label>
            <input
              id=""
              v-model="entryForm.date"
              type="date"
              class="form-control"
              name=""
              aria-describedby="helpId"
              placeholder=""
            />
            <InputError :message="entryForm.errors.date" />
          </div>
          <!-- PASS TIME OUT IN -->
          <div v-if="entryForm.purpose === 'pass'">
            <div class="mb-3">
              <label for="" class="form-label">Time Out</label>
              <input
                id=""
                v-model="entryForm.pass_out"
                type="time"
                class="form-control"
                name=""
                aria-describedby="helpId"
                placeholder=""
              />
              <InputError :message="entryForm.errors.pass_out" />
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Time In</label>
              <input
                id=""
                v-model="entryForm.pass_in"
                type="time"
                class="form-control"
                name=""
                aria-describedby="helpId"
                placeholder=""
              />
              <InputError :message="entryForm.errors.pass_in" />
            </div>
          </div>
          <!-- SUPPLEMENTARY -->
          <div v-if="entryForm.purpose === 'supp'">
            <fieldset class="mb-3 row">
              <legend class="col-12">AM</legend>
              <div class="mb-3 col-6">
                <label for="" class="form-label">Time In</label>
                <input
                  id=""
                  v-model="entryForm.supp_am_in"
                  type="time"
                  class="form-control"
                  name=""
                  aria-describedby="helpId"
                  placeholder=""
                />
                <InputError :message="entryForm.errors.supp_am_in" />
              </div>
              <div class="mb-3 col-6">
                <label for="" class="form-label">Time Out</label>
                <input
                  id=""
                  v-model="entryForm.supp_am_out"
                  type="time"
                  class="form-control"
                  name=""
                  aria-describedby="helpId"
                  placeholder=""
                />
                <InputError :message="entryForm.errors.supp_am_out" />
              </div>
            </fieldset>
            <fieldset class="row">
              <legend class="col-12">PM</legend>
              <div class="mb-3 col-6">
                <label for="" class="form-label">Time In</label>
                <input
                  id=""
                  v-model="entryForm.supp_pm_in"
                  type="time"
                  class="form-control"
                  name=""
                  aria-describedby="helpId"
                  placeholder=""
                />
                <InputError :message="entryForm.errors.supp_pm_in" />
              </div>
              <div class="mb-3 col-6">
                <label for="" class="form-label">Time Out</label>
                <input
                  id=""
                  v-model="entryForm.supp_pm_out"
                  type="time"
                  class="form-control"
                  name=""
                  aria-describedby="helpId"
                  placeholder=""
                />
                <InputError :message="entryForm.errors.supp_pm_out" />
              </div>
            </fieldset>
          </div>
          <!-- OFFICIAL -->
          <div v-if="entryForm.purpose === 'off'">
            <div class="mb-3">
              <label for="" class="form-label">Remarks</label>
              <select
                id=""
                v-model="entryForm.remarks"
                class="form-select form-select-lg"
                name=""
              >
                <option value="">Select one</option>
                <option v-for="remark in remarks" :key="remark" :value="remark">{{ remark }}</option>
              </select>
              <InputError :message="entryForm.errors.remarks" />
            </div>
            <!-- EO -->
            <div v-if="entryForm.remarks === 'EO'">
              <div class="mb-3">
                <label for="" class="form-label">Title</label>
                <input
                  id=""
                  v-model="entryForm.off_title"
                  type="text"
                  class="form-control"
                  name=""
                  aria-describedby="helpId"
                  placeholder=""
                  maxlength="100"
                />
                <InputError :message="entryForm.errors.off_title" />
              </div>
              <div class="mb-3">
                <div class="form-check form-check-inline">
                  <input
                    id="eo_8"
                    v-model="entryForm.eo_sched_type"
                    class="form-check-input"
                    type="radio"
                    name="eo_hours"
                    value="ALLDAY"
                  />
                  <label class="form-check-label" for="eo_8">8 hours</label>
                </div>
                <div class="form-check form-check-inline">
                  <input
                    id="eo_partial"
                    v-model="entryForm.eo_sched_type"
                    class="form-check-input"
                    type="radio"
                    name="eo_hours"
                    value="PARTIAL"
                  />
                  <label class="form-check-label" for="eo_partial">Partial</label>
                </div>
                <InputError :message="entryForm.errors.eo_sched_type" />
              </div>
              <div v-if="entryForm.eo_sched_type === 'PARTIAL'">
                <div class="mb-3">
                  <label for="" class="form-label">Start</label>
                  <input
                    id=""
                    v-model="entryForm.eo_start"
                    type="time"
                    class="form-control"
                    name=""
                    aria-describedby="helpId"
                    placeholder=""
                    maxlength="100"
                  />
                  <InputError :message="entryForm.errors.eo_start" />
                </div>
                <div class="mb-3">
                  <label for="" class="form-label">End</label>
                  <input
                    id=""
                    v-model="entryForm.eo_end"
                    type="time"
                    class="form-control"
                    name=""
                    aria-describedby="helpId"
                    placeholder=""
                    maxlength="100"
                  />
                  <InputError :message="entryForm.errors.eo_end" />
                </div>
              </div>
            </div>
            <!-- STUDY LEAVE and SCHOLARSHIP -->
            <div v-if="entryForm.remarks === 'STUDY_LEAVE' || entryForm.remarks === 'ON_SCHOLARSHIP'">
              <div class="mb-3">
                <label for="" class="form-label">Start</label>
                <input
                  id=""
                  v-model="entryForm.off_start"
                  type="date"
                  class="form-control"
                  name=""
                  aria-describedby="helpId"
                  placeholder=""
                />
                <InputError :message="entryForm.errors.off_start" />
              </div>
              <div class="mb-3">
                <label for="" class="form-label">End</label>
                <input
                  id=""
                  v-model="entryForm.off_end"
                  type="date"
                  class="form-control"
                  name=""
                  aria-describedby="helpId"
                  placeholder=""
                />
                <InputError :message="entryForm.errors.off_end" />
              </div>
            </div>
            <!-- OFFSETTING -->
            <div v-if="entryForm.remarks === 'OFFSETTING'">
              <div class="mb-3">
                <label for="" class="form-label">Hours</label>
                <input
                  id=""
                  v-model="entryForm.off_hours"
                  type="number"
                  class="form-control"
                  name=""
                  aria-describedby="helpId"
                  placeholder=""
                />
                <InputError :message="entryForm.errors.off_hours" />
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-sm btn-primary mt-3" @click="onAdd">Add Entry</button>
      </template>
    </Modal>
  </DTRLayout>
</template>
        
<script setup>
import DTRLayout from '@/Pages/Admin/DailyTimeRecord/DTRLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import moment from 'moment'
import Pagination from '@/Components/Pagination.vue'
import {debounce} from 'lodash'
import Modal from '@/Components/Modal.vue'
import InputError from '@/Components/InputError.vue'


const remarks = [
  'REG_OB',
  'REG_SPL',
  'REG_SL',
  'REG_VL',
  'REG_FL',
  'REG_HOLIDAY',
  'OFFSETTING',
  'EO',
  'RA_9710',
  'STUDY_LEAVE',
  'ON_SCHOLARSHIP',
]
const crumbs = computed(() => [
  {
    label: 'Admin Dashboard',
    link: route('admin.dashboard'),
  },
  {
    label: 'Daily Time Record',
  },
])

const entryForm = useForm({
  timesheet_draft_id: props.timesheet_draft.id,
  employee: '',
  purpose: '',
  date: '',
  pass_type: 'personal',
  pass_out: '',
  pass_in: '',
  supp_am_in: '08:00',
  supp_am_out: '12:00',
  supp_pm_in: '13:00',
  supp_pm_out: '17:00',
  off_title: '',
  off_start: '',
  off_end: '',
  eo_start: '',
  eo_end: '',
  off_hours: '',
  eo_sched_type: '',
  remarks: '',
})

const onAdd = () => {
  entryForm.post(route('admin.dtr.timesheet.store'))
}
      
const props = defineProps({
  employees: Array,
  timesheet_draft: Object,
})

const get12hr = (time) => {
  return moment(time, 'HH:mm').format('hh:mm A')
}

const getDate = (date) => {
  return moment(date, 'HH:mm').format('MMM, D, Y')
}
      
        
</script>
        