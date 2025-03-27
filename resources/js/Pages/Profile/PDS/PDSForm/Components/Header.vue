<style scoped>

table {
        font-size: 0.5rem;
        border-collapse: collapse;
        border-spacing: 0;
        margin: 0;
        padding: 0;
        border: black;

    }

    td, th {
        padding: 0;
    }

    .nested-table {
        margin: 0;
        padding: 0;
        border-collapse: collapse;
        border-spacing: 0;
    }
    .cs_fill{
        width: 40%;
    }
    .cs_id {
        background: gray;
        color: black;
        font-size: 0.5rem;
        width: 50px;
    }
    .cs_form {
        padding-left: 5px;
        text-align: start;
        font-size: 0.7rem;
    }
    .revised {
        padding-left: 5px;
        text-align: start;
        font-size: 0.6rem;
        margin-top: -5px;
    }
    .pds {
        font-weight: bold;
        color: black;
        font-size: 1.4rem;
    }
    .warning {
        padding-left: 5px;
        text-align: start;
        font-size: 0.6rem;
        width: 100%;
    }
    .print_legibly {
        padding-left: 5px;
        text-align: start;
        font-size: 0.6rem;
        width: 100%;
        letter-spacing: -0.8px;
    }
    tfoot tr {
        border-top: none;
    }
    .checkbox {
        -webkit-appearance: none;
        appearance: none;
        width: 9px;
        height: 9px;
        border: 1px solid #000;
        border-radius: 0;
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
        font-size: 12px;
        color: #000;
        margin-top: -7px;
        font-weight: bold;
    }
    .do_not_fill{
        font-size:0.5rem;
    }

</style>
<template>
    <table class="table-bordered w-100">
        <tbody>
            <tr class="text-center">
                <td colspan="4">
                    <i>
                        <div class="cs_form">
                            <b>CS Form No. 212</b>
                        </div>
                        <div class="revised">
                            <b>Revised 2017</b>
                        </div>
                    </i>
                    <h2 class="pds"><b>PERSONAL DATA SHEET</b></h2>
                    <i>
                        <div class="warning">
                            <b>WARNING: Any misrepresentation made in the Personal Data Sheet and the Work Experience Sheet
                                shall cause the filing of administrative/criminal case/s against the person concerned.</b>
                        </div>
                        <div class="warning">
                            <b>READ THE ATTACHED GUIDE TO FILLING OUT THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE
                                PDS FORM.</b>
                        </div>
                    </i>
                    <br>
                    <div class="d-flex">
                        <div class="print_legibly">
                            Print legibly. Tick appropriate boxes (
                            <input type="checkbox" class="checkbox"> ) and use a separate sheet if necessary. Indicate N/A if
                            not applicable. <b> DO NOT ABBREVIATE.</b>
                        </div>
                        <table class="table-bordered cs_fill float-end">
                            <tbody>
                                <tr>
                                    <td class="cs_id">
                                        1. CS ID No.
                                    </td>
                                    <td class="align-items-center">
                                        <div class="text-end" style="font-size:0.5rem;">
                                            (Do not fill up. For CSC use only)
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
        <!-- <tfoot>
            <tr>
                <td>
                    <div class="print_legibly">
                        Print legibly. Tick appropriate boxes (
                        <input type="checkbox" class="checkbox"> ) and use a separate sheet if necessary. Indicate N/A if
                        not applicable. <b> DO NOT ABBREVIATE.</b>
                    </div>
                </td>
                <td class="cs_id">
                    1. CS ID No.
                </td>
                <td class="align-items-center">
                    <div class="do_not_fill text-end">
                        (Do not fill up. For CSC use only)
                    </div>
                </td>
            </tr>
        </tfoot> -->
    </table>
</template>
