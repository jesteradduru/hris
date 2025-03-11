<style scoped>
table{
        font-size: 0.5rem;
        width:98%; 
        margin-left: auto; 
        margin-right: auto;
        border: black;
    }
.header{
    padding-left:10px; 
    text-align:start; 
    font-size:0.8rem;
    background:gray; 
    color:white; 
    width:100%;
}
.label_name{
    width:100%;
}
.labels{
    padding:10px;
    background:lightgray;
    color:black;
}
.elem{
    padding-left:10px; 
    font-weight: bold;
    height: 25px;
}
.continue{
        padding-left:10px; 
        text-align:center; 
        background:lightgray;
        color:red; 
    }
.include{
    padding-left:10px; 
    background:gray; 
    color:rgb(255, 255, 255); 
    margin-top: -5px;
}
</style>
<template>
<table class="table-bordered">
    <thead>
        <tr>
            <td colspan="9">
                <div class="header">
                    <i>VII. LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED</i>
                </div>
                <div class="include">
                    <i>(Start from the most recent L&D/training program and include only the relevant L&D/training taken
                        for the last five (5) years for Division Chief:Executive/Managerial positions)</i>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr class="labels">
                <td rowspan="2" style="width:500px;">
                    <div class="label_name text-center">
                        30.  TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAMS
                            (Write in full)
                    </div>
                </td>
                <td colspan="2" style="width:250px;">
                    <div class="label_name text-center">
                        INCLUSIVE DATES OF ATTENDANCE <br>
                        (mm/dd/yyyy)
                    </div>
                </td>
                <td rowspan="2" style="width:250px;">
                    <div class="label_name text-center">
                        NUMBER OF HOURS
                    </div>
                </td>
                <td rowspan="2" style="width:250px;">
                    <div class="label_name text-center">
                        Type of LD (Managerial/Supervisory/
                        Technical/etc)
                    </div>
                </td>
                <td rowspan="2" style="width:250px;">
                    <div class="label_name text-center">
                        CONDUCTED/SPONSORED BY <br>
                        (Write in full)
                    </div>
                </td>
            </tr>
            <tr class="labels">
                <td class="text-center" style="width:10%;">FROM
                </td>
                <td class="text-center" style="width:10%;">TO
                </td>
            </tr>
            <tr  v-for="(ld) in learning_and_development" :key="ld.id">
                <td class="elem">{{ ld.title_of_learning}}</td>
                <td class="elem">{{ ld.inclusive_date_from}}</td>
                <td class="elem">{{ ld.inclusive_date_to}}</td>
                <td class="elem">{{ ld.number_of_hours}}</td>
                <td class="elem">{{ ld.type_of_ld}}</td>
                <td class="elem">{{ ld.conducted_sponsored_by}}</td>
            </tr>
            <tr v-for="n in (19 - learning_and_development.length)" :key="n">
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
            <td colspan="9">
                <div class="continue">
                    <i>(Continue in separate sheet if necessary)</i>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
</template>

<script setup>
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import TextInput from '@/Components/TextInput.vue'
    import { Link, useForm, usePage } from '@inertiajs/vue3'

    const props = defineProps({
    learning_and_development: Object,
    })

    console.log(props.learning_and_development)
</script>
