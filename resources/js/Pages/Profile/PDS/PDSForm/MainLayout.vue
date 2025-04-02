<style scoped>
    table {
        border-collapse: collapse; /* Removes spacing between borders */
        border-spacing: 0; /* Ensures no extra space */
        margin: 0;
        padding: 0;
    }

    td, th {
        padding: 0; /* Removes padding inside table cells */
    }

    .nested-table {
        margin: 0; /* Ensures no extra margin */
        padding: 0;
        border-collapse: collapse;
        border-spacing: 0;
    }
    table.report-container{
        page-break-after: always;
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
    @media screen {
        tfoot{
            display: none;
        }
    }
</style>
<template>
<table class="table-bordered report-container">
    <tbody>
        <tr>
            <th colspan="8">
                <Header />
                <PersonalInformation :personal_information="props.personal_information" />
                <FamilyBackgorund :family_background="props.family_background" :children="props.children" />
                <EducationalBackground :college_graduate_studies="props.college_graduate_studies" />
                <CivilService :civil_service_eligibility="props.civil_service_eligibility" />
                <WorkExperience :work_experience="props.work_experience" />
                <VoluntaryWork :voluntary_work="props.voluntary_work" />
                <LearningandDev :learning_and_development="props.learning_and_development" />
                <OtherInformation :other_information="props.other_information" :questions="props.questions" :references_id="props.references_id" />
            </th>
        </tr>
        
    </tbody>
   <tfoot class="report-footer table-bordered">
        <tr>
            <td class="signature">
                <div class="d-flex">
                    <div>
                        <div class="sign_name">SIGNATURE</div>
                    </div>
                </div>
            </td>
            <td class="input">
            </td>
            <td class="signature">
                <div class="d-flex">
                    <div>
                        <div class="sign_name">DATE</div>
                    </div>
                </div>
            </td>
            <td class="input">
            </td>
        </tr>
   </tfoot>
</table>
</template>

<script setup>
import Header from './Components/Header.vue';
import PersonalInformation from './Components/PersonalInformation.vue';
import FamilyBackgorund from './Components/FamilyBackgorund.vue';
import EducationalBackground from './Components/EducationalBackground.vue';
import CivilService from './Components/CivilService.vue';
import WorkExperience from './Components/WorkExperience.vue';
import VoluntaryWork from './Components/VoluntaryWork.vue';
import LearningandDev from './Components/LearningandDev.vue';
import OtherInformation from './Components/OtherInformation.vue';

const props = defineProps({
    personal_information: Object,
    profile: Object,
    family_background: Object,
    children: Array,
    college_graduate_studies: Object,
    civil_service_eligibility: Object,
    work_experience: Object,
    voluntary_work: Object,
    learning_and_development: Object,
    other_information: Object,
    questions: Object,
    references_id: Object,
})

// console.log(props.references_id)
</script>

<style>

    .print-date {
        display: none;
    }

    @media print {
        body {
            -webkit-print-color-adjust: exact;
            /* Ensure colors print */
            color-adjust: exact;
            /* Ensure colors print */
        }

        /* Set the page size to 8.5 x 13 inches (legal size) */
        @page {
            size: 8.5in 13in;
            margin: 0.2in;
        }

        .table-bordered {
            border: 1px solid black;
        }


        /* Hide the Back and Print buttons during print */
        .hidden-print {
            display: none;
        }
    }

    .center {
        margin-left: auto;
        margin-right: auto;
    }
</style>
