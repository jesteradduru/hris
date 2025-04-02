<style scoped>
    table {
        border-collapse: collapse; /* Removes spacing between borders */
        border-spacing: 0; /* Ensures no extra space */
        margin: 0;
        padding: 0;
        border: 0.5px solid black;
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
table{
        width: 100%;
        font-size: 0.5rem;
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
.footer{
    padding-left:10px; 
    text-align:center; 
    background:lightgray;
    color:red; 
}
    .signature{
        width:130px;
        background:lightgray;
        color:black;
    }
    .sign_name{
        padding-left:10px;
        font-size:1rem;
        width:50px;
    }
.continue{
    padding-left:10px; 
    text-align:center; 
    background:lightgray;
    color:red; 
}
    .checkbox {
        -webkit-appearance: none;
        appearance: none;
        width: 12px;
        height: 12px;
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
        font-size: 14px;
        color: #000;
        margin-top: -12px;
        margin-left: -3px;
        font-weight: bold;
    }
    .yes_no{
        margin-top:30px;
        margin-left:10px;
    }
    .yes_no1{
        margin-left:10px;
    }
    .thirty_five{
        padding-left:10px; 
        align-items: center;
        display: flex;
        height: 18px;
    }
    .input{
        border:none; 
        outline: none; 
        width:100%; 
        display: inline-block;
        font-weight: bold;
    }
    .underline{
        border-top: 1px solid black; 
        padding-top: 5px;
    }
    .subscribed{
        display: flex; 
        justify-content: center; 
        align-items: center; 
        flex-direction: column; 
        text-align: center;
    }
    .photo_id{
        margin-left:75px;margin-top:-15px;
    }
</style>

<template>
<table class="table-bordered">
    <thead>
        <tr>
            <td colspan="8">
                <div class="header">
                    <i>VIII. OTHER INFORMATION</i>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr class="labels">
            <td colspan="2" style="width:270px;">
                <div class="d-flex">
                    <div class="label_name text-center">
                        31.  SPECIAL SKILLS and HOBBIES
                    </div>
                    <div class="label_name text-center">
                        NON- ACADEMIC DISTINCTIONS / RECOGNITION <br>
                        (Write in full)
                    </div>
                </div>
            </td>
            <td colspan="2" style="width:100px;">
                <div class="label_name text-center">
                    33.  MEMBERSHIP IN <br>
                            ASSOCIATION/ORGANIZATION <br>
                            (Write in full)

                </div>
            </td>
        </tr>
        <tr>
            <td class="elem" style="height:30px; width:480px;">{{ other_information.special_skills_hobbies }}</td>
            <td class="elem" style="height:30px; width:500px;">sample</td>
            <td colspan="2" class="elem" style="height:30px;">{{ other_information.membership_in_assoc_org }}</td>
        </tr>
        <tr>
            <td class="elem" style="height:30px;">{{ other_information.special_skills_hobbies }}</td>
            <td class="elem" style="height:30px;">sample</td>
            <td colspan="2" class="elem" style="height:30px;">{{ other_information.membership_in_assoc_org }}</td>
        </tr>
        <tr>
            <td class="elem" style="height:30px;">{{ other_information.special_skills_hobbies }}</td>
            <td class="elem" style="height:30px;">sample</td>
            <td colspan="2" class="elem" style="height:30px;">{{ other_information.membership_in_assoc_org }}</td>
        </tr>
        <tr>
            <td class="elem" style="height:30px;">{{ other_information.special_skills_hobbies }}</td>
            <td class="elem" style="height:30px;">sample</td>
            <td colspan="2" class="elem" style="height:30px;">{{ other_information.membership_in_assoc_org }}</td>
        </tr>
        <tr>
            <td class="elem" style="height:30px;">{{ other_information.special_skills_hobbies }}</td>
            <td class="elem" style="height:30px;">sample</td>
            <td colspan="2" class="elem" style="height:30px;">{{ other_information.membership_in_assoc_org }}</td>
        </tr>
        <tr>
            <td class="elem" style="height:30px;">{{ other_information.special_skills_hobbies }}</td>
            <td class="elem" style="height:30px;">sample</td>
            <td colspan="2" class="elem" style="height:30px;">{{ other_information.membership_in_assoc_org }}</td>
        </tr>
        <tr>
            <td class="elem" style="height:30px;">{{ other_information.special_skills_hobbies }}</td>
            <td class="elem" style="height:30px;">sample</td>
            <td colspan="2" class="elem" style="height:30px;">{{ other_information.membership_in_assoc_org }}</td>
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
<!-- <table class="table-bordered">
    <tbody>
        <tr>
            <td class="signature">
                <div class="d-flex">
                    <div>
                        <div class="sign_name">SIGNATURE</div>
                    </div>
                </div>
            </td>
            <td colspan="2">
            </td>
            <td class="signature">
                <div class="d-flex">
                    <div>
                        <div class="sign_name">DATE</div>
                    </div>
                </div>
            </td>
            <td colspan="4">
            </td>
        </tr>
    </tbody>
</table>
<div style="text-align:end; font-size:0.5rem; margin-right:15px;">
    <i>CS FORM 212 (Revised 2017), Page 1 of 4</i>
</div> -->
<table>
    <tbody>
        <tr>
            <td>
                <div class="d-flex">
                    <table class="table-bordered w-100">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex" style="height:71px;">
                                        <div style="padding-left:10px;">34.</div>
                                        <div>
                                            <div style="padding-left:5px;"> Are you related by consanguity to
                                                the appointing or recommenting authority, or to the chief of bureau or office or to the
                                                person who has immediate supervision over you in the Office, Bureau or Department where you
                                                will be appionted,<br>
                                                a. within the third degree?<br><br>
                                                b. within the fourth degree(for Local Goverment Umit - Career Employees)?
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex pt-2" style="height:92px;">
                                        <div style="padding-left:10px;">35.</div>
                                        <div>
                                            <div style="padding-left:5px;padding-bottom:45px;">
                                                a. Have you ever been found guilty of any administrative offenses?
                                            </div>
                                            <div style="padding-left:5px;">
                                                b. Have you been criminally charged before any court?
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex" style="height:27px;">
                                        <div style="padding-left:10px;">36.</div>
                                        <div>
                                            <div style="padding-left:5px;">
                                                Have you ever been convicted of any crime or violation of any law, decree, ordinance or
                                                regulation by any court or tribunal?
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex" style="height:30px;">
                                        <div style="padding-left:10px;">37.</div>
                                        <div>
                                            <div style="padding-left:5px;"> Have you ever been seperated from
                                                the service in any of the following modes: resignation,
                                                retirement, dropped from the rolls, dismissal, termination, end of term, finished contract
                                                or phased out (abolition) in the public or private sector?
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex" style="height:50px;">
                                        <div style="padding-left:10px;">38.</div>
                                        <div>
                                            <div style="padding-left:5px;">
                                                <div class="pb-2">
                                                    a. Have you ever been a candidate in a national or local election held within the last year
                                                    (except Barangay election)?
                                                </div>  
                                                <div>
                                                    b. Have you resigned from the government service during the three(3)-month period before the
                                                    last election to promoted/ actively campaign for a national or local candidate?
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex"  style="height:23px;">
                                        <div style="padding-left:10px;">39.</div>
                                        <div>
                                            <div style="padding-left:5px;"> Have you acquired the status of an
                                                immigration or permanent resident of another country?
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex" style="height:89px;">
                                        <div style="padding-left:10px;">40.</div>
                                        <div>
                                            <div style="padding-left:5px;">
                                                Pursuant to: (a) Indegenous People's Act(RA 8371); (b) Magna Carta for Disabled Persons (RA
                                                7277); and (c) Solo Parent Welfare Act of 2000 (RA 8972), Please answer the following
                                                items:? <br>
                                                a. Are you a member of any indigenous group? <br><br>
                                                b. Are you a person with disability? <br><br>
                                                c. Are you a solo parent?<br><br><br>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table-bordered" style="width:70%; page-break-before: always;">
                        <tbody>
                            <tr>
                                <td style="height:20px;">
                                    <!-- 34. a. -->
                                    <div class="yes_no d-flex">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_four_a === 'Yes'">
                                            <div class="p-1">YES</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="padding-left:30px;">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_four_a === 'No'">
                                            <div class="p-1">NO</div>
                                        </div>
                                    </div>
                                    <!-- 34. b. -->
                                    <div class="yes_no1 d-flex">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_four_b === 'Yes'">
                                            <div class="p-1">YES</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="padding-left:30px;">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_four_b === 'No'">
                                            <div class="p-1">NO</div>
                                        </div>
                                    </div>
                                    <div class="mb-1" style="margin-left:10px;">
                                        <div>If YES, give details:</div>
                                        <div class="d-flex justify-content-between">
                                            <input type="text" name="hnum" 
                                            v-model="questions.thirty_four_a_b_if_yes"
                                            style="border:none; outline: none; width:100%; font-weight:bold;">
                                        </div>
                                        <div style="border-top: 1px solid black;"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="yes_no1 d-flex">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_five_a === 'Yes'">
                                            <div class="p-1">YES</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="padding-left:30px;">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_five_a === 'No'">
                                            <div class="p-1">NO</div>
                                        </div>
                                    </div>
                                    <div class="mb-1" style="margin-left:10px;">
                                        <div>If YES, give details:</div>
                                        <div class="d-flex justify-content-between">
                                            <input type="text" name="hnum" v-model="questions.thirty_five_a_if_yes" style="border:none; outline: none; width:100%; font-weight:bold;">
                                        </div>
                                        <div style="border-top: 1px solid black;"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="yes_no1 d-flex">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_five_b === 'Yes'">
                                            <div class="p-1">YES</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="padding-left:30px;">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_five_b === 'No'">
                                            <div class="p-1">NO</div>
                                        </div>
                                    </div>
                                    <div class="thirty_five">
                                        <div>If YES, give details:</div>
                                        <div>
                                            <input type="text" class="input" v-model="questions.thirty_five_b_if_yes">
                                            <div class="underline" style="width:100%;"></div>
                                        </div>
                                    </div>
                                    <div class="thirty_five">
                                        <div>Date Filed: </div>
                                        <div>
                                            <input type="text" class="input" v-model="questions.thirty_five_b_if_yes_case">
                                            <div class="underline" style="width:100%;"></div>
                                        </div>
                                    </div>
                                    <div class="thirty_five">
                                        <div>Status of Case/s:</div>
                                        <div>
                                            <input type="text" class="input">
                                            <div class="underline" style="width:100%;"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="yes_no1 d-flex">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_six === 'Yes'">
                                            <div class="p-1">YES</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="padding-left:30px;">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_six === 'No'">
                                            <div class="p-1">NO</div>
                                        </div>
                                    </div>
                                    <div class="thirty_five mb-1" style="height:15px;">
                                        <div>If YES, give details:</div>
                                        <div>
                                            <input type="text" class="input" v-model="questions.thirty_six_if_yes">
                                            <div class="underline" style="width:100%;"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="yes_no1 d-flex">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_seven === 'Yes'">
                                            <div class="p-1">YES</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="padding-left:30px;">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_seven === 'No'">
                                            <div class="p-1">NO</div>
                                        </div>
                                    </div>
                                    <div class="thirty_five" style="height:21px;">
                                        <div>If YES, give details:</div>
                                        <div>
                                            <input type="text" class="input" v-model="questions.thirty_seven_if_yes">
                                            <div class="underline" style="width:100%;"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="yes_no1 d-flex">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_eight_a === 'Yes'">
                                            <div class="p-1">YES</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="padding-left:30px;">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_eight_a === 'No'">
                                            <div class="p-1">NO</div>
                                        </div>
                                    </div>
                                    <div class="thirty_five" style="height:10px;">
                                        <div>If YES, give details:</div>
                                        <div>
                                            <input type="text" class="input" v-model="questions.thirty_eight_a_if_yes">
                                            <div class="underline" style="width:100%;"></div>
                                        </div>
                                    </div>
                                    <div class="yes_no1 d-flex">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_eight_b === 'Yes'">
                                            <div class="p-1">YES</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="padding-left:30px;">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_eight_b === 'No'">
                                            <div class="p-1">NO</div>
                                        </div>
                                    </div>
                                    <div class="thirty_five" style="height:20px;">
                                        <div>If YES, give details:</div>
                                        <div>
                                            <input type="text" class="input" v-model="questions.thirty_eight_b_if_yes">
                                            <div class="underline" style="width:100%;"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="yes_no1 d-flex" style="height:15px;">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_nine === 'Yes'">
                                            <div class="p-1">YES</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="padding-left:30px;">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.thirty_nine === 'No'">
                                            <div class="p-1">NO</div>
                                        </div>
                                    </div>
                                    <div class="thirty_five">
                                        <div>If YES, give details(country): </div>
                                        <div>
                                            <input type="text" class="input" v-model="questions.thirty_nine_if_yes">
                                            <div class="underline" style="width:100%;"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="yes_no1 d-flex mt-4">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.fourty_a === 'Yes'">
                                            <div class="p-1">YES</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="padding-left:30px;">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.fourty_a === 'No'">
                                            <div class="p-1">NO</div>
                                        </div>
                                    </div>
                                    <div class="thirty_five" style="height:10px;">
                                        <div>If YES, please specify:</div>
                                        <div>
                                            <input type="text" class="input" v-model="questions.fourty_a_if_yes">
                                            <div class="underline" style="width:100%;"></div>
                                        </div>
                                    </div>
                                    <div class="yes_no1 d-flex">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.fourty_b === 'Yes'">
                                            <div class="p-1">YES</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="padding-left:30px;">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.fourty_b === 'No'">
                                            <div class="p-1">NO</div>
                                        </div>
                                    </div>
                                    <div class="thirty_five" style="height:10px;">
                                        <div>If YES, please specify ID No: </div>
                                        <div>
                                            <input type="text" class="input" v-model="questions.fourty_b_if_yes">
                                            <div class="underline" style="width:100%;"></div>
                                        </div>
                                    </div>
                                    <div class="yes_no1 d-flex">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.fourty_c === 'Yes'">
                                            <div class="p-1">YES</div>
                                        </div>
                                        <div class="d-flex align-items-center" style="padding-left:30px;">
                                            <input type="checkbox" class="checkbox p-1"  :checked="questions.fourty_c === 'No'">
                                            <div class="p-1">NO</div>
                                        </div>
                                    </div>
                                    <div class="thirty_five" style="height:20px;">
                                        <div>If YES, please specify ID No: </div>
                                        <div>
                                            <input type="text" class="input" v-model="questions.fourty_c_if_yes">
                                            <div class="underline" style="width:100%;"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<table class="table-bordered">
    <tr>
        <td>
            <div class="d-flex">
                <table class="table-bordered w-100" style="border-top: none;">
                    <tbody>
                        <tr>
                            <td class="p-3" colspan="4">
                                41. REFERENCES <span style="color:red;">(Person not related by consanguinity or affinity to applicant /appointee)</span>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td style="width:100px;height:25px;">NAME</td>
                            <td style="width:50px;">ADDRESS</td>
                            <td style="width:50px;">TEL. NO</td>
                        </tr>
                        <tr>
                            <td style="height:25px;">
                                <input type="text" class="input p-2" v-model="references_id.references_name_one">
                            </td>
                            <td style="height:25px;">
                                <input type="text" class="input p-2" v-model="references_id.references_address_one">
                            </td>
                            <td style="height:25px;">
                                 <input type="text" class="input p-2" v-model="references_id.references_telephone_one">
                            </td>
                        </tr>
                        <tr>
                            <td style="height:25px;">
                                <input type="text" class="input p-2" v-model="references_id.references_name_two">
                            </td>
                            <td style="height:25px;">
                                <input type="text" class="input p-2" v-model="references_id.references_address_two">
                            </td>
                            <td style="height:25px;">
                                <input type="text" class="input p-2" v-model="references_id.references_telephone_two">
                            </td>
                        </tr>
                        <tr>
                            <td style="height:25px;">
                                <input type="text" class="input p-2" v-model="references_id.references_name_three">
                            </td>
                            <td style="height:25px;">
                                <input type="text" class="input p-2" v-model="references_id.references_address_three">
                            </td>
                            <td style="height:25px;">
                                <input type="text" class="input p-2" v-model="references_id.references_telephone_three">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="d-flex text-dark">
                                    <div class="p-2">
                                        42.
                                    </div>
                                    <div class="text-start p-2">
                                        I declare under oath that I have personally accomplished this Personal Data Sheet
                                        which is a true, correct and complete statement pursuant to the provisions of pertinent
                                        laws, rules and regulations of the Republic of the Philippines. I authorize the agency
                                        head/authorized representative to verify/validate the contents stated herein. I agree
                                        that any misrepresentation made in this document and its attachments shall cause the
                                        filing of administrative/criminal case/s against me.
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="width:40%">
                    <tbody>
                        <tr>
                            <td>
                                <div class="">
                                    <div style="padding: 25px;">
                                        <div style="border: 1px solid black; width: 3.5cm; height: 4.5cm; display: flex; justify-content: center; align-items: center; overflow: hidden;">
                                            <p
                                                style=" padding:10px; font-size: 0.5rem; line-height: 1.2; word-wrap: break-word; text-align: center;">
                                                Center this ID picture taken within the last 6 months<br>
                                                3.5 cm X 4.5 cm (passport size)<br>
                                                With full and handwritten name tag and signature over printed name<br>
                                                Computer generated or photocopied picture is not accepted.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="photo_id">PHOTO</div>
                                </div>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex">
                <table border="1" class="table-bordered border-dark text-dark m-2" style="width:60%;"> 
                    <thead>
                        <tr>
                            <td class="text-start p-2">
                                Government Issued ID <span>(i.e Passport, GSIS, SSS, PRC, Driver's License, etc.)</span>
                                    <div>PLEASE INDICATE ID Number and Date of Issuance</div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-2">Government Issued ID: {{ references_id.government_issued_id }}</td>
                        </tr>
                        <tr>
                            <td class="p-2">ID/License/Passport No.: {{ references_id.id_license_passport_number }}</td>
                        </tr>
                        <tr>
                            <td class="p-2">Date/Place of Issuance: {{ references_id.date_place_of_issuance }}</td>
                        </tr>
                    </tbody>
                </table>
                <table border="1" class="table-bordered border-dark text-dark m-2" style="width:50%;">
                    <tr>
                        <td class="text-center" style="height:80px;"></td>
                    </tr>
                    <tr>
                        <td class="text-center" style="height:5px;">Signature (Sign
                            inside the box)</td>
                    </tr>
                    <tr>
                        <td class="text-center"  style="height:15px;"></td>
                    </tr>
                    <tr>
                        <td class="text-center" style="height:5px;">Date
                            Accomplished
                        </td>
                    </tr>
                </table>
                <table class="m-2" style="width:30%;">
                    <tr>
                        <td>
                            <div class="text-center" style="">
                                <div style="border: 1px solid black; padding: 5px; width: 180px; height: 3.5cm;">
                                </div>
                                <div style="border: 1px solid black; padding: 5px; width: 180px; border-top: none;">
                                    Right Thumbmark
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div>
                <table class="w-100 text-center border-black">
                    <tr>
                        <td colspan="2">
                            <div class="subscribed mt-4">
                                <div class="d-flex" style="align-items: center;">
                                    SUBSCRIBED AND SWORN to before me this
                                    <div>
                                        <input type="text" name="hnum" style="border:none; outline: none; width:200px; display: inline-block;">
                                        <div style="border-top: 1px solid black; padding-top: 5px; width:280px;"></div>
                                    </div>
                                    , affiant exhibiting his/her validly issued government ID as indicated above.
                                </div>
                                <div style="width: 500px;">
                                    <div class="p-1 mt-3" style="border: 1px solid black; height: 2cm;">
                                    </div>
                                    <div
                                        class="p-1 mb-2" style="border: 1px solid black; border-top: none;">
                                        Person Administering Oath
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
</template>

<script setup>
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import TextInput from '@/Components/TextInput.vue'
    import { Link, useForm, usePage } from '@inertiajs/vue3'

    const props = defineProps({
    other_information: Object,
    questions: Object,
    references_id: Object,
    })

    // console.log(props.references_id)
</script>
