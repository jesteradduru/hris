<template>
  <AuthenticatedLayout>
    <PDSLayout>
      <!-- <Link :href="route('profile.pds.voluntary_work.create')" class="btn btn-success">Add Voluntary Work</Link> -->
      <h5>References</h5>
      <div class="table-responsive">
        <table class="table table-sm table-bordered mt-3" style="text-transform: uppercase;">
          <thead>
            <tr>
              <th scope="col">NAME</th>
              <th scope="col">ADDRESS</th>
              <th scope="col">TEL. NO.</th>
            </tr>
          </thead>
          <tbody v-if="props.reference_id">
            <tr>
              <td>
                {{ props.reference_id.references_name_one }}
                <span v-if="!props.reference_id.references_name_one">-</span>
              </td>
              <td>
                {{ props.reference_id.references_address_one }}
                <span v-if="!props.reference_id.references_address_one">-</span>
              </td>
              <td>
                {{ props.reference_id.references_telephone_one }}
                <span v-if="!props.reference_id.references_telephone_one">-</span>
              </td>
            </tr>
            <tr>
              <td>
                {{ props.reference_id.references_name_two }}
                <span v-if="!props.reference_id.references_name_two">-</span>
              </td>
              <td>
                {{ props.reference_id.references_address_two }}
                <span v-if="!props.reference_id.references_address_two">-</span>
              </td>
              <td>
                {{ props.reference_id.references_telephone_two }}
                <span v-if="!props.reference_id.references_telephone_two">-</span>
              </td>
            </tr>
            <tr>
              <td>
                {{ props.reference_id.references_name_three }}
                <span v-if="!props.reference_id.references_name_three">-</span>
              </td>
              <td>
                {{ props.reference_id.references_address_three }}
                <span v-if="!props.reference_id.references_address_three">-</span>
              </td>
              <td>
                {{ props.reference_id.references_telephone_three }}
                <span v-if="!props.reference_id.references_telephone_three">-</span>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td colspan="3"><div class="text-muted text-center">No record to display</div></td>
            </tr>
          </tbody>
        </table>
        <h5>Government Issued ID</h5>
        <table class="table table-sm table-bordered mt-3" style="text-transform: uppercase;">
          <thead>
            <tr>
              <th scope="col">Government Issued ID (i.e.Passport, GSIS, SSS, PRC, Driver's License, etc.)</th>
              <th scope="col">PLEASE INDICATE ID Number and Date of Issuance</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Government Issued ID:</td>
              <td>
                {{ props.reference_id?.government_issued_id }}
                <span v-if="!props.reference_id?.government_issued_id">-</span>
              </td>
            </tr>
            <tr>
              <td>ID/License/Passport No. </td>
              <td>
                {{ props.reference_id?.id_license_passport_number }}
                <span v-if="!props.reference_id?.id_license_passport_number">-</span>
              </td>
            </tr>
            <tr>
              <td>Date/Place of Issuance</td>
              <td>
                {{ props.reference_id?.date_place_of_issuance }}
                <span v-if="!props.reference_id?.date_place_of_issuance">-</span>
              </td>
            </tr>
            <tr>
              <td>Scanned Copy</td>
              <td>
                <a target="_blank" :href="reference_id?.files[0].src"> {{ reference_id?.files[0].filename }}</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mb-3 d-flex gap-2 justify-content-between">
        <div class="d-flex gap-2">
          <Link :href="route('profile.pds.reference_id.edit')" class="btn btn-success">Edit</Link>
        </div>
        <div class="d-flex gap-2">
          <Link
            :href="route('profile.pds.page_four_questions.edit')" type="button"
            class="btn btn-dark"
          >
            <i class="fa-solid fa-arrow-left" />
          </Link>
        </div>
      </div>
    </PDSLayout>
  </AuthenticatedLayout>
</template>
  
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PDSLayout from '@/Pages/Profile/PDS/Layout/PDSLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
    
const props = defineProps({
  reference_id: Object,
})
    
</script>