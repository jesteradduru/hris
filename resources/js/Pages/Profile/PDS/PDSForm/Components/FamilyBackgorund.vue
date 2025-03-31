<style scoped>
    table {
        font-size: 0.5rem;
        border-collapse: collapse; /* Removes spacing between borders */
        border-spacing: 0; /* Ensures no extra space */
        margin: 0;
        padding: 0;
        border: black;
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
    .header{
        padding-left:10px; 
        text-align:start; 
        font-size:0.8rem;
        background:gray; 
        color:white; 
        width:100%;
    }
    .names{
        background:lightgray; 
        color:black; 
        padding-left:10px; 
         
        width:205px;
        height: 20px;
    }
    .names .name{
        padding-left:10px; 
        
    }
    .input{
        padding-left:10px; 
        font-weight: bold;
        height: 20px;
    }
    .extention{
        background-color:lightgray;
        color:black;
        width: 0px;
    }
    .exten{
        padding-left:5px; 
        font-weight: bold;
    }
    .label_name{
        
         width:100%;
         padding-left: 10px;
    }
    .occupation{
        background:lightgray;
        color:black;
        padding-left:27px;
        
    }
    .children{
        padding-left:10px; 
        font-weight: bold;
        height: 22px;
    }
    .continue{
        padding-left:10px; 
        text-align:center; 
        background:lightgray;
        color:red; 
        
        height: 15px;
    }
</style>
<template>
    <table class="w-100">
        <tbody>
            <tr>
                <td colspan="8">
                    <div class="header">
                        <i>II. FAMILY BACKGROUND</i>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="d-flex">
                        <table class="table-bordered">
                            <tbody>
                                <tr>
                                    <td rowspan="3" class="names" style="width:38%;">
                                        <div class="d-flex">
                                            <div>2.</div>
                                            <div>
                                                <div class="name ">SPOUSE'S SURNAME</div>
                                                <div class="name pt-2">FIRSTNAME</div>
                                                <div class="name pt-2">MIDDLENAME</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="input" colspan="3" style="width:600px;">{{ family_background.spouse_surname }}</td>
                                </tr>
                                <tr>
                                    <td class="input" width="90px">{{ family_background.spouse_first_name }}</td>
                                    <td class="extention">
                                        <div class="d-flex">
                                            <div>
                                                <sup>NAME EXTENSION (JR., SR)</sup>
                                            </div>
                                            <div class="exten">{{ family_background.spouse_name_extension }}</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="input" colspan="2">{{ family_background.spouse_middle_name }}</td>
                                </tr>
                                <tr>
                                    <td class="occupation">OCCUPATION</td>
                                    <td class="input" colspan="2">{{ family_background.spouse_occupation }}</td>
                                </tr>
                                <tr>
                                    <td class="occupation">EMPLOYER/BUSINESS NAME</td>
                                    <td class="input" colspan="2">{{ family_background.spouse_employer_business_name }}</td>
                                </tr>
                                <tr>
                                    <td class="occupation">BUSINESS NAME</td>
                                    <td class="input" colspan="2">{{ family_background.spouse_business_address }}</td>
                                </tr>
                                <tr>
                                    <td class="occupation">TELEPHONE NO.</td>
                                    <td class="input" colspan="2">{{ family_background.spouse_telephone_number }}</td>
                                </tr>
                                <tr>
                                    <td rowspan="3" class="names">
                                        <div class="d-flex">
                                            <div>24.</div>
                                            <div>
                                                <div class="name ">FATHER'S SURNAME</div>
                                                <div class="name pt-2">FIRSTNAME</div>
                                                <div class="name pt-2">MIDDLENAME</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="input" colspan="2">{{ family_background.fathers_surname }}</td>
                                </tr>
                                <tr>
                                    <td class="input">{{ family_background.fathers_first_name }}</td>
                                    <td class="extention">
                                        <div class="d-flex">
                                            <div>
                                                <sup>NAME EXTENSION (JR., SR)</sup>
                                            </div>
                                            <div class="exten">{{ family_background.fathers_name_extension }}</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="input" colspan="2">{{ family_background.fathers_middle_name }}</td>
                                </tr>
                                <tr>
                                    <td rowspan="4" class="names">
                                        <div class="d-flex">
                                            <div>25.</div>
                                            <div>
                                                <div class="name">MOTHER'S MAIDEN NAME</div>
                                                <div class="name pt-2">SURNAME</div>
                                                <div class="name pt-2">FIRSTNAME</div>
                                                <div class="name pt-2">MIDDLENAME</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="2" class="input">{{ family_background.mothers_surname }}</td>   
                                </tr>
                                <tr>
                                    <td colspan="2" class="input">{{ family_background.mothers_surname }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="input">{{ family_background.mothers_first_name }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="input">{{ family_background.mothers_middle_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table-bordered w-100">
                            <tbody>
                                <tr>
                                    <td class="names"  style="width:215px;">
                                        <div class="label_name">23. NAME of CHILDREN (Write fullnameand list all)
                                        </div>
                                    </td>
                                    <td class="names"  style="width:130px;">
                                        <div class="d-flex">
                                            <div class="label_name">DATE OF BIRTH (mm/dd/yyyy)
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-for="(child) in children" :key="child.id">
                                    <td class="children">{{ child.fullname }}</td>
                                    <td class="children">{{ child.date_of_birth }}</td>
                                </tr>
                                <tr v-for="n in (12 - children.length)" :key="n">
                                    <td class="children"></td>
                                    <td class="children"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <div class="continue">
                                            <i>(Continue in separate sheet if necessary)</i>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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

const props = defineProps({
  family_background: Object,
  children: Array
})

// console.log(props.children)
</script>
