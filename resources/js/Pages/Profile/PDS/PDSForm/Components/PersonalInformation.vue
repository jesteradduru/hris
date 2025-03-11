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
    .extension{
        padding-left:5px;
        position: absolute; 
        top: 0; left: 0;
    }
    .citi_checkbox{
        padding-left:10px; 
    }
    .input_fields{
        padding-left:10px; 
        border:none; 
        outline: none; 
        font-weight: bold;    
        width: 100%;
    }
    .input_place{
        align-items: center;
        width: 100%;
    }
    .hnum{
        border:none; 
        outline: none; 
        width:80%;
        text-align: start;
        font-weight: bold;
    }
    .street{
        border:none; 
        outline: none; 
        width:80%;
        text-align: end;
        font-weight: bold;
    }
    .hnum_name{
        border-top: 1px solid black; 
        width:100%; 
        height: 10px;
    }
    .checkbox {
        -webkit-appearance: none;
        appearance: none;
        width: 13px;
        height: 13px;
        border: 1.5px solid #000;
        border-radius: 0; /* No rounded corners */
        position: relative;
        cursor: pointer;
        margin: 0;
    }

    .checkbox:checked {
        background-color: #fff;
        border-color: #000;
    }

    .checkbox:checked::before {
        content: '\2713'; /* Unicode checkmark */
        position: absolute;
        font-size: 16px;
        color: #000;
        margin-top: -10px;
        font-weight: bold;
    }


    .civil_checkbox{
        padding-left:5px; 
    }
    .names{
        background:lightgray; 
        color:black; 
        padding-left:10px; 
        width:150px;
    }
    .names .name{
        padding-left:10px; 
    }
    .input{
        padding-left:10px; 
        font-weight: bold;
    }
    .extention{
        background-color:lightgray;
        color:black;
    }
    .exten{
        padding-left:10px; 
        font-weight: bold;
    }
    .zip_code{
        background:lightgray;
        color:black;
        width: 20%;
    }
</style>
<template>
    <table class="table-bordered">
        <thead>
            <tr>
                <td colspan="4">
                    <div class="header">
                        <i>I. PERSONAL INFORMATION</i>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="3" class="names">
                    <div class="d-flex">
                        <div class="p-1">2.</div>
                        <div>
                            <div class="name pt-1">SURNAME</div>
                            <div class="name pt-2">FIRSTNAME</div>
                            <div class="name pt-2">MIDDLENAME</div>
                        </div>
                    </div>
                </td>
                <td class="input" colspan="3">{{ personal_information.surname }}</td>
            </tr>
            <tr>
                <td class="input" colspan="2">{{ personal_information.first_name }}</td>
                <td class="extention">
                    <div class="d-flex">
                        <div>
                            <sup>NAME EXTENSION (JR., SR)</sup>
                        </div>
                        <div class="exten">{{ personal_information.name_extension }}</div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="input" colspan="3">{{ personal_information.middle_name }}</td>
            </tr>
            <tr>
                <td class="names" style="height:5px;">
                    <div class="d-flex">
                        <div class="p-1">3.</div>
                        <div class="p-1">
                            DATE OF BIRTH <br> (mm/dd/yyyy)
                        </div>
                    </div>
                </td>
                <td class="input">{{ personal_information.date_of_birth }}</td>
                <td rowspan="3" class="zip_code">
                    <div class="p-1 pb-5">16. CITIZENSHIP</div>
                    <div class="text-center">
                        If holder of dual citizenship, <br> <br>please indicate the details. <br><br>
                    </div>
                </td>
                <td style="color:black;" rowspan="2">
                    <div class="d-flex" style="padding-left:10px;">
                        <div class="d-flex pb-1">
                            <input type="checkbox" id="checkbox1" class="checkbox" :checked="personal_information.filipino === '1'">
                            <div class="citi_checkbox">Filipino</div>
                        </div>
                        <div class="d-flex pb-1" style="padding-left:10px;">
                            <input type="checkbox" id="checkbox1" class="checkbox" :checked="personal_information.dual_citizenship === '1'">
                            <div class="citi_checkbox">Dual Citizenship</div>
                        </div>
                    </div>
                    <div class="d-flex" style="padding-left:58px;">
                        <div class="d-flex pb-1">
                            <input type="checkbox" id="checkbox1" class="checkbox" :checked="personal_information.by_birth === '1'">
                            <div class="citi_checkbox">by Birth</div>
                        </div>
                        <div class="d-flex pb-1" style="padding-left:10px;">
                            <input type="checkbox" id="checkbox1" class="checkbox" :checked="personal_information.by_naturalization === '1'">
                            <div class="citi_checkbox">by Naturalization</div>
                        </div>
                    </div>
                    <br>
                    <div class="citi_checkbox">Pls. indicate country:</div>
                </td>
            </tr>
            <tr>
                <td class="names" style="height:5px;">
                    <div class="d-flex">
                        <div class="p-1">4.</div>
                        <div class="p-1">
                            PLACE OF BIRTH
                        </div>
                    </div>
                </td>
                <td class="input">{{ personal_information.place_of_birth }}</td>
            </tr>
            <tr>
                <td class="names" style="height:5px;">
                    <div class="d-flex">
                        <div class="p-1">5.</div>
                        <div class="p-1">
                            SEX
                        </div>
                    </div>
                </td>
                <td style="color:black;">
                    <div class="d-flex" style="padding-left:20px;">
                        <div class="d-flex">
                            <input class="checkbox" type="checkbox" :checked="personal_information.sex === 'male'">
                            <!-- {{ personal_information.sex }} -->
                            <div style="padding-left:10px;">Male</div>
                        </div>
                        <div class="d-flex  align-items-center" style="padding-left:50px;">
                            <input class="checkbox" type="checkbox" :checked="personal_information.sex === 'female'">
                            <div style="padding-left:10px;">Female</div>
                        </div>
                    </div>
                </td>
                <td class="input">
                    <input 
                        type="text" 
                        name="country" 
                        style="border:none; 
                        outline: none; 
                        padding-left:10px; 
                        font-weight: bold;" 
                    >
                </td>
            </tr>
            <tr>
                <td rowspan="2" class="names">
                    <div class="d-flex">
                        <div class="p-1">6.</div>
                        <div class="p-1">
                            CIVIL STATUS
                        </div>
                    </div>
                </td>
                <td style="color:black;padding-left:10px;" rowspan="2">
                    <div class="d-flex" style="padding-left:10px;">
                        <div class="d-flex pb-1">
                            <input type="checkbox" class="checkbox" :checked="personal_information.civil_status === 'single'">
                            <div class="civil_checkbox">Single</div>
                        </div>
                        <div class="d-flex pb-1" style="padding-left:50px;">
                            <input type="checkbox" class="checkbox" :checked="personal_information.civil_status === 'married'">
                            <div class="civil_checkbox">Married</div>
                        </div>
                    </div>
                    <div class="d-flex" style="padding-left:10px;">
                        <div class="d-flex pb-1">
                            <input type="checkbox" class="checkbox" :checked="personal_information.civil_status === 'widowed'">
                            <div class="civil_checkbox">Widowed</div>
                        </div>
                        <div class="d-flex pb-1" style="padding-left:37px;">
                            <input type="checkbox" class="checkbox" :checked="personal_information.civil_status === 'separated'">
                            <div class="civil_checkbox">Separated</div>
                        </div>
                    </div>
                    <div class="d-flex" style="padding-left:10px;">
                        <input type="checkbox" id="checkbox1" class="checkbox" :checked="personal_information.civil_status === 'others'">
                        <div style="padding-left:10px;">Other/s:</div>
                    </div>
                </td>
                <td rowspan="4" class="zip_code">
                    <div>
                        <div class="p-1 pb-5">17. RESIDENTIAL
                            ADDRESS</div><br><br>
                    </div>
                    <div class="text-center">
                        ZIP CODE
                    </div>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div class="input_place text-start">
                                    <input class="hnum" v-model="personal_information.r_address_house_block_lot_number" type="text">
                                    <div class="hnum_name">House/Block/Lot No</div>
                                </div>
                            </td>
                            <td>
                                <div class="input_place text-end">
                                    <input class="street" v-model="personal_information.r_address_street" type="text">
                                    <div class="hnum_name">Street</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div class="input_place text-start">
                                    <input class="hnum" v-model="personal_information.r_address_subdivision_village" type="text">
                                    <div class="hnum_name">Subdivision/Village</div>
                                </div>
                            </td>
                            <td>
                                <div class="input_place text-end">
                                    <input class="street" v-model="personal_information.r_address_barangay" type="text">
                                    <div class="hnum_name"> Barangay</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="names">
                    <div class="d-flex">
                        <div class="p-1">7.</div>
                        <div class="p-1">
                            HEIGHT (m)
                        </div>
                    </div>
                </td>
                <td class="input">{{ personal_information.height }}</td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div class="input_place text-start">
                                    <input class="hnum" v-model="personal_information.r_address_city_municipality" type="text">
                                    <div class="hnum_name">City/Municipality</div>
                                </div>
                            </td>
                            <td>
                                <div class="input_place text-end">
                                    <input class="street" v-model="personal_information.r_address_province" type="text">
                                    <div class="hnum_name">Province</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="names">
                    <div class="d-flex">
                        <div class="p-1">8.</div>
                        <div class="p-1">
                            WEIGHT (kg)
                        </div>
                    </div>
                </td>
                <td class="input">{{ personal_information.weight }}</td>
                <td class="input">{{ personal_information.r_address_zipcode }}</td>
            </tr>
            <tr>
                <td class="names">
                    <div class="d-flex">
                        <div class="p-1">9.</div>
                        <div class="p-1">
                            BLOOD TYPE
                        </div>
                    </div>
                </td>
                <td class="input">{{ personal_information.blood_type }}</td>
                <td rowspan="4" class="zip_code">
                    <div>
                        <div class="p-1 pb-5">18. PERMANENT ADDRESS
                        </div><br><br>
                    </div>
                    <div class="text-center">
                        ZIP CODE
                    </div>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div class="input_place text-start">
                                    <input class="hnum" v-model="personal_information.p_address_house_block_lot_number" type="text">
                                    <div class="hnum_name">House/Block/Lot No</div>
                                </div>
                            </td>
                            <td>
                                <div class="input_place text-end">
                                    <input class="street" v-model="personal_information.p_address_street" type="text">
                                    <div class="hnum_name">Street</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="names">
                    <div class="d-flex">
                        <div class="p-1">10.</div>
                        <div class="p-1">
                            GSIS ID NO.
                        </div>
                    </div>
                </td>
                <td>
                    <input type="text" name="bday" v-model="personal_information.gsis_id_number" class="input_fields">
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div class="input_place text-start">
                                    <input class="hnum" v-model="personal_information.p_address_subdivision_village" type="text">
                                    <div class="hnum_name">Subdivision/Village</div>
                                </div>
                            </td>
                            <td>
                                <div class="input_place text-end">
                                    <input class="street" v-model="personal_information.p_address_barangay" type="text">
                                    <div class="hnum_name">Barangay</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="names">
                    <div class="d-flex">
                        <div class="p-1">11.</div>
                        <div class="p-1">
                            PAGIBIG ID NO.
                        </div>
                    </div>
                </td>
                <td>
                    <input type="text" name="bday" v-model="personal_information.pagibig_id_number" class="input_fields">
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div class="input_place text-start">
                                    <input class="hnum" v-model="personal_information.p_address_city_municipality" type="text">
                                    <div class="hnum_name">City/Municipality</div>
                                </div>
                            </td>
                            <td>
                                <div class="input_place text-end">
                                    <input class="street" v-model="personal_information.p_address_province" type="text">
                                    <div class="hnum_name">Province</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="names">
                    <div class="d-flex">
                        <div class="p-1">12.</div>
                        <div class="p-1">
                            HILHEALTH NO.
                        </div>
                    </div>
                </td>
                <td class="input">{{ personal_information.philhealth_number }}</td>
                <td class="input">{{ personal_information.p_address_zipcode }}</td>
            </tr>
            <tr>
                <td class="names">
                    <div class="d-flex">
                        <div class="p-1">13.</div>
                        <div class="p-1">
                            SSS NO.
                        </div>
                    </div>
                </td>
                <td class="input">{{ personal_information.sss_number }}</td>
                <td class="names">
                    <div class="d-flex">
                        <div class="p-1">19.</div>
                        <div class="p-1">
                            TELEPHONE NO.
                        </div>
                    </div>
                </td>
                <td class="input">{{ personal_information.telephone_number }}</td>
            </tr>
            <tr>
                <td class="names">
                    <div class="d-flex">
                        <div class="p-1">19.</div>
                        <div class="p-1">
                            TIN NO.
                        </div>
                    </div>
                </td>
                <td class="input">{{ personal_information.tin_number }}</td>
                <td class="names">
                    <div class="d-flex">
                        <div class="p-1">20.</div>
                        <div class="p-1">
                            MOBILE NO.
                        </div>
                    </div>
                </td>
                <td class="input">{{ personal_information.mobile_number }}</td>
            </tr>
            <tr>
                <td class="names">
                    <div class="d-flex">
                        <div class="p-1">15.</div>
                        <div class="p-1">
                            AGENCY EMPLOYEE NO.
                        </div>
                    </div>
                </td>
                <td class="input">{{ personal_information.agency_employee_number }}</td>
                <td class="names">
                    <div class="d-flex">
                        <div class="p-1">21.</div>
                        <div class="p-1">
                            E-MAIL ADDRESS (if any)
                        </div>
                    </div>
                </td>
                <td class="input">{{ personal_information.email_address }}</td>
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
    personal_information: Object
})


// console.log(props.personal_information)

</script>