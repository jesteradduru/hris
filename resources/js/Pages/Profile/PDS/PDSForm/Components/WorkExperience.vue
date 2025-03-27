<style scoped>
table {
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 0.5rem;
        width:100%; 
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
    height:25px;
}
.signature{
        width:130px;
        background:lightgray;
        color:black;
    }
.sign_name{
    padding-left:10px;
    font-size:1rem;
    width:70px;
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
            <td colspan="8">
                <div class="header">
                    <i>V. WORK EXPERIENCE</i>
                </div>
                <div class="include">
                    <i>(Include provate employment. Start from your recent work) Description of duties should be
                        included in the attached Work Experience sheet.</i>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr class="labels">
            <td colspan="2" style="width:100px;">
                <div class="label_name text-center">
                    28.  INCLUSIVE DATES <br>(mm/dd/yy)
                </div>
            </td>
            <td rowspan="2" style="width:500px;">
                <div class="label_name text-center">
                    POSITION TITLE <br>
                    (Write in full/Do not abbreviate)
                </div>
            </td>
            <td rowspan="2" style="width:500px;">
                <div class="label_name text-center">
                    DEPARTMENT / AGENCY /
                    OFFICE / COMPANY<br>
                    (Write in full/Do not abbreviate)
                </div>
            </td>
            <td rowspan="2" style="width:100px;">
                <div class="label_name text-center">
                    MONTHLY<br>
                    SALARY
                </div>
            </td>
            <td rowspan="2" style="width:100px;">
                <div class="label_name text-center">
                    SALARY/ JOB / PAY <br>
                    GRADE (if applicable) & STEP <br>(Format "00-0")/ <br>INCREMENT
                </div>
            </td>
            <td rowspan="2" style="width:100px;">
                <div class="label_name text-center">
                    STATUS OF <br> APPOINTMENT
                </div>
            </td>
            <td rowspan="2" style="width:150px;">
                <div class="label_name text-center">
                    GOV'T
                    SERVICE
                    (Y/N)
                </div>
            </td>
        </tr>
        <tr class="labels">
            <td class="text-center" style="width:10%;height:5px;">FROM
            </td>
            <td class="text-center" style="width:10%;">TO
            </td>
        </tr>
        <tr v-for="(we) in work_experience" :key="we.id">
            <td class="elem">{{ we.inclusive_date_from }}</td>
            <td class="elem">{{ we.inclusive_date_to }}</td>
            <td class="elem">{{ we.position_title }}</td>
            <td class="elem">{{ we.dept_agency_office_company }}</td>
            <td class="elem">{{ we.monthly_salary }}</td>
            <td class="elem">{{ we.paygrade }}</td>
            <td class="elem">{{ we.status_of_appointment }}</td>
            <td class="elem">{{ we.govt_service }}</td>
        </tr>
            <tr v-for="n in (32 - work_experience.length)" :key="n">
                <td class="elem"></td>
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
</template>
<script setup>
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import TextInput from '@/Components/TextInput.vue'
    import { Link, useForm, usePage } from '@inertiajs/vue3'

    const props = defineProps({
    work_experience: Object,
    })

    // console.log(props.work_experience)
</script>
