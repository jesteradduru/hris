<style scoped>
table{
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
}
.continue{
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
                <div class="header">
                    <i>VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY
                        ORGANIZATION/S</i>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr class="labels">
            <td rowspan="2" style="width:500px;">
                <div class="label_name text-center">
                    29.  NAME AND ADDRESS OF ORGANIZATION <br> 
                    <i>(Write in full)</i>
                </div>
            </td>
            <td colspan="2" style="width:250px;">
                <div class="label_name text-center">
                    INCLUSIVE DATES <br> (mm/dd/yyyy)
                </div>
            </td>
            <td rowspan="2" style="width100px;">
                <div class="label_name text-center">
                    NUMBER OF HOURS
                </div>
            </td>
            <td rowspan="2" style="width:500px;">
                <div class="label_name text-center">
                    POSITION / NATURE OF WORK
                </div>
            </td>
        </tr>
        <tr class="labels">
            <td class="text-center" style="width:15%;">FROM
            </td>
            <td class="text-center" style="width:15%;">TO
            </td>
        </tr>
        <tr v-for="(vw) in voluntary_work" :key="vw.id">
            <!-- <td><input type="text" v-model="vw.name_address_of_org" class="elem" style="height:30px;"></td>
            <td><input type="text" v-model="vw.inclusive_date_from" class="elem" style="height:30px;"></td>
            <td><input type="text" v-model="vw.inclusive_date_to" class="elem" style="height:30px;"></td>
            <td><input type="text" v-model="vw.number_of_hours" class="elem" style="height:30px;"></td>
            <td><input type="text" v-model="vw.position_work" class="elem" style="height:30px;"></td> -->
            <td class="elem" style="height:30px;">{{ vw.name_address_of_org }}</td>
            <td class="elem" style="height:30px;">{{ vw.inclusive_date_from }}</td>
            <td class="elem" style="height:30px;">{{ vw.inclusive_date_to }}</td>
            <td class="elem" style="height:30px;">{{ vw.number_of_hours }}</td>
            <td class="elem" style="height:30px;">{{ vw.position_work }}</td>
        </tr>
        <tr v-for="n in (7 - voluntary_work.length)" :key="n">
            <td class="elem" style="height:30px;"></td>
            <td class="elem" style="height:30px;"></td>
            <td class="elem" style="height:30px;"></td>
            <td class="elem" style="height:30px;"></td>
            <td class="elem" style="height:30px;"></td>
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
    voluntary_work: Object,
    })

    // console.log(props.voluntary_work)
</script>