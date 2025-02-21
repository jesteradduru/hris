<template>
   <Header />
   <PersonalInformation/>
   <FamilyBackgorund/>
   <EducationalBackground/>
   <CivilService/>
   <WorkExperience/>
   <VoluntaryWork/>
   <LearningandDev/>
   <OtherInformation/>
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
