<style scoped>
table{
        font-size: 0.5rem;
        width:100%; 
        margin-left: auto; 
        margin-right: auto;
        border: black;
    }
.header4{
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
    height:20px;
}
.footer{
    padding-left:10px; 
    text-align:center; 
    background:lightgray;
    color:red; 
}
</style>
<template>
    <table class="table-bordered">
        <thead>
            <tr>
                <td colspan="8">
                    <div class="header4">
                        <i>IV. CIVIL SERVICE ELIGIBILITY</i>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr class="labels">
                <td rowspan="2" style="width:550px;">
                    <div class="label_name text-center">
                        27.  CAREER
                        SERVICE/ RA 1080 (BOARD/BAR) UNDER <br>
                        SPECIAL LAWS/ CES/ CSEE <br>
                        BARANGAY ELIGIBILITY / DRIVER'S LECENSE<br>
                    </div>
                </td>
                <td rowspan="2" style="width:250px;">
                    <div class="label_name text-center">
                        RATING <br>
                        (If Applicable)
                    </div>
                </td>
                <td rowspan="2" style="width:250px;">
                    <div class="label_name text-center">
                        EXAMINATION / <br>
                        CONFERMENT
                    </div>
                </td>
                <td rowspan="2" style="width:500px;">
                    <div class="label_name text-center">
                        PLACE OF EXAMINATION / CONFERMENT
                    </div>
                </td>
                <td colspan="2">
                    <div class="label_name text-center">
                        LICENSE (if applicable)
                    </div>
                </td>
            </tr>
            <tr class="labels">
                <td class="text-center" style="width:10%;">
                    NUMBER
                </td>
                <td class="text-center" style="width:10%;">
                    Date of Validity
                </td>
            </tr>
            <tr v-for="(cse) in civil_service_eligibility" :key="cse.id">
                <td colspan="1" class="elem">
                    {{ cse.cs_board_bar_ces_csee_barangay_drivers }}
                </td>
                <td colspan="1" class="elem">
                    {{ cse.rating }}
                </td>
                <td colspan="1" class="elem">
                    {{ cse.date_of_exam_conferment }}
                </td>
                <td colspan="1" class="elem">
                    {{ cse.place_of_exam_conferment }}
                </td>
                <td colspan="1" class="elem">
                    {{ cse.license_number }}
                </td>
                <td colspan="1" class="elem">
                    {{ cse.license_date_of_validity }}
                </td>
            </tr>
            <tr v-for="n in (7 - civil_service_eligibility.length)" :key="n">
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
                    <div class="footer">
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
    civil_service_eligibility: Object,
    })

    // console.log(props.civil_service_eligibility)
</script>
