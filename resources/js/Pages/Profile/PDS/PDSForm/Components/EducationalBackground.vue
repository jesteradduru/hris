<style>
    @media print {
        @page {
            padding-top: 2mm;
            padding-bottom: 5mm;
        }
        .main-table{
            position: relative;
        }
        .sign_table {
            position: fixed;
            bottom: -14px;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-top: 2px solid black;
        }
    }
    @media screen {
        .sign_table {
            display: none;
        }
        .page_num{
            display: none;
        }
    }
</style>
<style scoped>
    table {
        font-size: 0.5rem;
        width: 98%;
        margin-left: auto;
        margin-right: auto;
        border: 1px solid black;
    }
    .header {
        padding-left: 10px;
        text-align: start;
        font-size: 0.8rem;
        background: gray;
        color: white;
        width: 100%;
    }

    .labels {
        padding: 10px;
        background: lightgray;
        color: black;
    }

    .label_name {
        width: 100%;
    }

    .elem {
        font-weight: bold;
        padding-left: 10px;
    }

    .signature {
        width: 130px;
        background: lightgray;
        color: black;
        text-align: center;
        font-weight: bold;
    }

    .sign_name {
        padding-left: 10px;
        font-size: 1rem;
        width: 50px;
    }

    .continue {
        padding-left: 10px;
        text-align: center;
        background: lightgray;
        color: red;
        font-weight: bold;
    }

</style>
<template>
    <table class="table-bordered main-table">
        <thead>
            <tr>
                <td colspan="8">
                    <div class="header">
                        <i>III. EDUCATIONAL BACKGROUND</i>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr class="labels">
                <td rowspan="2" style="width:20%;">
                    <div class="level p-2">26. LEVEL
                    </div>
                </td>
                <td rowspan="2" style="width:120px;">
                    <div class="label_name text-center"><i>NAME OF SCHOOL</i></div>
                    <div class="label_name text-center"><i>(Write in full)</i></div>
                </td>
                <td rowspan="2" style="width:150px;">
                    <div class="label_name text-center"><i>BASIC EDUCATION/DEGREE/COURSE</i></div>
                    <div class="label_name text-center"><i>(Write in full)</i></div>
                </td>
                <td colspan="2">
                    <div class="label_name text-center"><i>PERIOD OF ATTENDANCE</i></div>
                </td>
                <td rowspan="2">
                    <div class="label_name text-center"><i>HIGHEST LEVEL/ UNITS EARNED</i></div>
                    <br>
                    <div class="label_name text-center" style="margin-top:-10px;"><i>(if not graduated)</i></div>
                </td>


                <td rowspan="2">
                    <div class="label_name text-center" style=""><i>YEAR GRADUATED</i></div><br>
                </td>
                <td rowspan="2">
                    <div class="label_name text-center" style=""><i>SCHOLARSHIP / ACADEMIC HONORS
                            RECEIVED</i></div><br>
                </td>
            </tr>
            <tr class="labels">
                <td>
                    <div class="label_name text-center" style="width: 50px;">FROM</div>
                </td>
                <td>
                    <div class="label_name text-center" style="width: 50px;">TO</div>
                </td>
            </tr>
            <tr v-for="(college, index) in elementary" :key="college.id">
                <td :rowspan="elementary.length" class="labels" v-if="index === 0"><div>ELEMENTARY</div></td>
                <td class="elem">{{ college.name_of_school }}</td>
                <td class="elem">{{ college.basic_ed_degree_course }}</td>
                <td class="elem">{{ college.period_from }}</td>
                <td class="elem">{{ college.period_to }}</td>
                <td class="elem">{{ college.highest_lvl_units_earned }}</td>
                <td class="elem">{{ college.basic_ed_degree_course }}</td>
                <td class="elem">{{ college.year_graduated }}</td>
            </tr>
            <tr v-if="elementary.length === 0">
                    <td class="labels"><div>VOCATIONAL / TRADE COURSE</div></td>
                    <td class="elem"></td>
                    <td class="elem"></td>
                    <td class="elem"></td>
                    <td class="elem"></td>
                    <td class="elem"></td>
                    <td class="elem"></td>
                </tr>
            <tr v-for="(college, index) in secondary" :key="college.id">
                <td :rowspan="secondary.length" class="labels" v-if="index === 0"><div>SECONDARY</div></td>
                <td class="elem">{{ college.name_of_school }}</td>
                <td class="elem">{{ college.basic_ed_degree_course }}</td>
                <td class="elem">{{ college.period_from }}</td>
                <td class="elem">{{ college.period_to }}</td>
                <td class="elem">{{ college.highest_lvl_units_earned }}</td>
                <td class="elem">{{ college.basic_ed_degree_course }}</td>
                <td class="elem">{{ college.year_graduated }}</td>
            </tr>
            <tr v-if="secondary.length === 0">
                <td class="labels"><div>VOCATIONAL / TRADE COURSE</div></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
            </tr>
            <tr v-for="(college, index) in vocational" :key="college.id">
                <td :rowspan="vocational.length" class="labels" v-if="index === 0"><div>VOCATIONAL / TRADE COURSE</div></td>
                <td class="elem">{{ college.name_of_school }}</td>
                <td class="elem">{{ college.basic_ed_degree_course }}</td>
                <td class="elem">{{ college.period_from }}</td>
                <td class="elem">{{ college.period_to }}</td>
                <td class="elem">{{ college.highest_lvl_units_earned }}</td>
                <td class="elem">{{ college.basic_ed_degree_course }}</td>
                <td class="elem">{{ college.year_graduated }}</td>
            </tr>
            <tr v-if="vocational.length === 0">
                <td class="labels"><div>VOCATIONAL / TRADE COURSE</div></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
            </tr>
            <tr v-for="(college, index) in colleges" :key="college.id">
                <td :rowspan="colleges.length" class="labels" v-if="index === 0"><div>COLLEGE</div></td>
                <td class="elem">{{ college.name_of_school }}</td>
                <td class="elem">{{ college.basic_ed_degree_course }}</td>
                <td class="elem">{{ college.period_from }}</td>
                <td class="elem">{{ college.period_to }}</td>
                <td class="elem">{{ college.highest_lvl_units_earned }}</td>
                <td class="elem">{{ college.basic_ed_degree_course }}</td>
                <td class="elem">{{ college.year_graduated }}</td>
            </tr>
            <tr v-if="colleges.length === 0">
                <td class="labels"><div>COLLEGE</div></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
            </tr>
            <tr v-for="(college, index) in graduate_studies" :key="college.id">
                <td :rowspan="graduate_studies.length" class="labels" v-if="index === 0"><div>GRADUATE STUDIES</div></td>
                <td class="elem">{{ college.name_of_school }}</td>
                <td class="elem">{{ college.basic_ed_degree_course }}</td>
                <td class="elem">{{ college.period_from }}</td>
                <td class="elem">{{ college.period_to }}</td>
                <td class="elem">{{ college.highest_lvl_units_earned }}</td>
                <td class="elem">{{ college.basic_ed_degree_course }}</td>
                <td class="elem">{{ college.year_graduated }}</td>
            </tr>
            <tr v-if="graduate_studies.length === 0">
                <td class="labels"><div>GRADUATE STUDIES</div></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
                <td class="elem"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8">
                    <div class="continue">
                        <i>(Continue in separate sheet if necessary)</i>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
    <table class="sign_table table-bordered">
        <tbody>
            <tr>
                <td class="signature">
                    <div class="d-flex">
                        <div>
                            <div class="sign_name">SIGNATURE</div>
                        </div>
                    </div>
                </td>
                <td>
                </td>
                <td class="signature">
                    <div class="d-flex">
                        <div>
                            <div class="sign_name">DATE</div>
                        </div>
                    </div>
                </td>
                <td>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import {ref, computed} from 'vue'

const props = defineProps({
//   educational_background: Object,
  college_graduate_studies: Object
})

const elementary = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'ELEMENTARY')
})

const secondary = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'SECONDARY')
})

const vocational = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'VOCATIONAL')
})

const colleges = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'COLLEGE')
})
const graduate_studies = computed(() => {
  return props.college_graduate_studies.filter(ed => ed.type === 'GRADUATE')
})

// console.log(props.college_graduate_studies)


</script>
