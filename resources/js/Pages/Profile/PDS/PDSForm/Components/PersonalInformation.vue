<template>
    <table class="table-bordered" style="border:black; margin-top:1px; font-size:11px; width:100%;">
        <!-- Name Row -->
        <tr>
            <td style="color:black;" colspan="4">
                <div style="padding-left:10px; text-align:start; font-size:1.2rem;background:gray; color:white;">
                    <i>I. PERSONAL INFORMATION</i>
                </div>
            </td>
        </tr>
        <tr>
            <td rowspan="3"
                style="background:lightgray; color:black; padding-left:10px; font-size:0.7rem; width:205px;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">2.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.7rem;">SURNAME</div><br>
                        <div style="padding-left:10px; font-size:0.7rem;">FIRSTNAME</div><br>
                        <div style="padding-left:10px; font-size:0.7rem;">MIDDLENAME</div>
                    </div>
                </div>
            </td>
            <!-- Align Name with Date of Birth -->
            <td style="color:black;vertical-align: top" colspan="3">
                <div style="display: flex; align-items: center;">
                    <div style="width: 100px;">
                        <input type="text" name="lname"
                            style="font-size:0.7rem;border:none; outline: none; width:800px;" value="">
                    </div>
                </div>
            </td>
        </tr>
        <!-- First Name Row -->
        <tr>
            <td style="color:black;" colspan="2">
                <input type="text" name="fname" style="font-size:0.7rem;border:none; outline: none; width:700px;"
                    value="">
            </td>
            <td style="background-color:lightgray;color:black;">
                <div class="d-flex align-items-center font-size:0.6px;">
                    <div style="width:150px;">
                        NAME EXTENSION (JR., SR)
                    </div>
                    <div>
                        <input type="text" name="ename" value=""
                            style="padding-left:10px;background:lightgray;font: size 1rem;border:none; outline: none; width:100px;">
                    </div>
                </div>
            </td>
        </tr>
        <!-- Middle Name Row -->
        <tr>
            <td style="color:black;" colspan="3">
                <input type="text" name="mname" style="font-size:0.7rem;border:none; outline: none; width:800px;"
                    value="">
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">3.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.7rem;width:100px;">DATE OF BIRTH <br> (mm/dd/yyyy)
                        </div>
                    </div>
                </div>
            </td>
            <td style="color:black;padding-left:100px;">
                <input type="text" name="bday"
                    style="padding-left:10px; font-size:1rem;border:none; outline: none; width:100%;" value="">
            </td>
            <td rowspan="3" style="width:300px; background:lightgray;color:black;">
                <div>
                    <div style=" padding-bottom: 60px; font-size:0.7rem;width:140px;margin: 10px;">16. CITIZENSHIP</div>
                    <br>
                </div>
                <div style="padding-left:10px; font-size:0.8rem; text-align: center;">
                    If holder of dual citizenship, <br> <br>please indicate the details. <br><br>
                </div>
            </td>
            <td style="color:black;width:100px; padding-left:10px;padding-top:5px;" rowspan="2">
                <div class="d-flex" style="padding-left:10px;">
                    <div class="d-flex">
                        <input type="checkbox" id="checkbox1" style="vertical-align: middle;">
                        <div style="padding-left:10px; font-size:0.7rem;">Filipino</div>
                    </div>
                    <div class="d-flex" style="padding-left:50px;">
                        <input type="checkbox" id="checkbox1" style="vertical-align: middle;">
                        <div style="padding-left:10px; font-size:0.7rem;">Dual Citizenship</div>
                    </div>
                </div>
                <br>
                <div class="d-flex" style="padding-left:10px;">
                    <div class="d-flex">
                        <input type="checkbox" id="checkbox1" style="vertical-align: middle;">
                        <div style="padding-left:10px; font-size:0.7rem;">by Birth</div>
                    </div>
                    <div class="d-flex" style="padding-left:50px;">
                        <input type="checkbox" id="checkbox1" style="vertical-align: middle;">
                        <div style="padding-left:10px; font-size:0.7rem;">by Naturalization</div>
                    </div>
                </div>
                <br><br>
                <div style="padding-left:10px; font-size:0.7rem;">Pls. indicate country:</div>
            </td>
        </tr>

        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">4.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.7rem;">PLACE OF BIRTH</div>
                    </div>
                </div>
            </td>
            <td style="color:black;padding-left:100px">
                <input type="text" name="bplace" style="font-size:0.7rem;border:none; outline: none; width:200px;"
                    value="">
            </td>
        </tr>

        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">5.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.7rem;width:100px;">SEX</div>
                    </div>
                </div>
            </td>
            <td style="color:black;">
                <div class="d-flex" style="padding-left:10px;">
                    <div class="d-flex">
                        <input type="checkbox" id="checkbox1" style="vertical-align: middle;">
                        <div style="padding-left:10px; font-size:0.7rem;">Male</div>
                    </div>
                    <div class="d-flex" style="padding-left:50px;">
                        <input type="checkbox" id="checkbox1" style="vertical-align: middle;">
                        <div style="padding-left:10px; font-size:0.7rem;">Female</div>
                    </div>
                </div>
            </td>
            <td style="color:black;padding-left:10px">
                <input type="text" name="country" style="font-size:1rem;border:none; outline: none; width:300px;"
                    value="">
            </td>
        </tr>

        <tr>
            <td rowspan="2" style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">6.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.7rem;width:100px;">CIVIL STATUS</div>
                    </div>
                </div>
            </td>
            <td style="color:black;padding-left:10px;" rowspan="2">
                <div class="d-flex" style="padding-left:10px;">
                    <div class="d-flex">
                        <input type="checkbox" id="checkbox1" style="vertical-align: middle;">
                        <div style="padding-left:10px; font-size:0.7rem;">Single</div>
                    </div>
                    <div class="d-flex" style="padding-left:50px;">
                        <input type="checkbox" id="checkbox1" style="vertical-align: middle;">
                        <div style="padding-left:10px; font-size:0.7rem;">Married</div>
                    </div>
                </div>
                <br>
                <div class="d-flex" style="padding-left:10px;">
                    <div class="d-flex">
                        <input type="checkbox" id="checkbox1" style="vertical-align: middle;">
                        <div style="padding-left:10px; font-size:0.7rem;">Widowed</div>
                    </div>
                    <div class="d-flex" style="padding-left:38px;">
                        <input type="checkbox" id="checkbox1" style="vertical-align: middle;">
                        <div style="padding-left:10px; font-size:0.7rem;">Separated</div>
                    </div>

                </div>
                <br>
                <div class="d-flex" style="padding-left:10px;">
                    <input type="checkbox" id="checkbox1" style="vertical-align: middle;">
                    <div style="padding-left:10px; font-size:0.7rem;">Other/s:</div>
                </div>
            </td>
            <td rowspan="4" style="width:300px; background:lightgray;color:black;">
                <div>
                    <div style=" padding-bottom: 60px; font-size:0.7rem;width:140px;margin: 10px;">17. RESIDENTIAL
                        ADDRESS</div><br>
                </div>
                <div style="padding-left:10px; font-size:0.8rem; text-align: center;">
                    ZIP CODE
                </div>
            </td>

            <td style="padding-left:10px;">
                <div class="d-flex justify-content-around" style="width: 100%;">
                    <!-- Input fields with a min-width to maintain size -->
                    <input type="text" name="hnum"
                        style="font-size:0.9; border:none; outline: none; width:120px; min-width: 120px; margin-left: 25px;"
                        value="">
                    <input type="text" name="street"
                        style="font-size:0.9; border:none; outline: none; width:120px; min-width: 120px; margin-left: 20px"
                        value="">
                </div>

                <div style="border-top: 1px solid black; padding-top: 5px; padding-right: 5px;">
                    <div class="d-flex justify-content-around" style="width: 100%;">
                        <div style="min-width: 140px; text-align: center;">House/Block/Lot No.</div>
                        <div style="min-width: 100px; text-align: center;">Street</div>
                    </div>
                </div>
            </td>


        </tr>
        <tr>
            <td style="padding-left:10px;">
                <div class="d-flex justify-content-around" style="width: 100%;">
                    <!-- Input fields with a min-width to maintain size -->
                    <input type="text" name="hnum"
                        style="font-size:0.9; border:none; outline: none; width:120px; min-width: 110px; margin-left: 25px;"
                        value="">
                    <input type="text" name="street"
                        style="font-size:0.9; border:none; outline: none; width:120px; min-width: 120px; margin-left: 20px"
                        value="">
                </div>

                <div style="border-top: 1px solid black; padding-top: 5px; padding-right: 5px;">
                    <div class="d-flex justify-content-around" style="width: 100%;">
                        <div>
                            Subdivision/Village
                        </div>
                        <div>
                            Barangay
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">7.</div>
                    <div style="padding-left:10px; font-size:0.7rem;width:100px;">HEIGHT (m)</div>

                </div>
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="ht" style="font-size:0.7rem;border:none; outline: none; width:300px;">
            </td>
            <td style="padding-left:10px;">
                <div class="d-flex justify-content-around" style="width: 100%;">
                    <!-- Input fields with a min-width to maintain size -->
                    <input type="text" name="hnum"
                        style="font-size:0.9; border:none; outline: none; width:120px; min-width: 120px; margin-left: 25px;"
                        value="">
                    <input type="text" name="street"
                        style="font-size:0.9; border:none; outline: none; width:120px; min-width: 120px; margin-left: 20px"
                        value="">
                </div>

                <div style="border-top: 1px solid black; padding-top: 5px; padding-right: 5px;">
                    <div class="d-flex justify-content-around" style="width: 100%;">
                        <div>
                            City/Municipality
                        </div>
                        <div>
                            Province
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex align-items-center">
                    <div style="padding-left:10px; font-size:0.7rem;">8.</div>
                    <div>
                        <div
                            style="padding-left:10px;padding-top:5px; padding-bottom: 5px; font-size:0.7rem;width:100px;">
                            WEIGHT (kg)</div>
                    </div>
                </div>
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="wt" style="font-size:0.9rem;border:none; outline: none; width:200px;">
            </td>
            <td style="padding-left:10px;">
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">9.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.7rem;width:100px;">BLOOD TYPE</div>
                    </div>
                </div>
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="bt" style="font-size:0.9rem;border:none; outline: none; width:300px;">
            </td>
            <td rowspan="4" style="width:300px; background:lightgray;color:black;">
                <div>
                    <div style=" padding-bottom: 60px; font-size:0.7rem;width:140px;margin: 10px;">18. PERMANENT ADDRESS
                    </div><br>
                </div>
                <div style="padding-left:10px; font-size:0.8rem; text-align: center;">
                    ZIP CODE
                </div>
            </td>
            <td style="padding-left:10px;">
                <div class="d-flex justify-content-around" style="width: 100%;">
                    <!-- Input fields with a min-width to maintain size -->
                    <input type="text" name="hnum"
                        style="font-size:0.9; border:none; outline: none; width:120px; min-width: 120px; margin-left: 25px;"
                        value="">
                    <input type="text" name="street"
                        style="font-size:0.9; border:none; outline: none; width:120px; min-width: 120px; margin-left: 20px"
                        value="">
                </div>

                <div style="border-top: 1px solid black; padding-top: 5px; padding-right: 5px;">
                    <div class="d-flex justify-content-around" style="width: 100%;">
                        <div style="min-width: 140px; text-align: center;">House/Block/Lot No.</div>
                        <div style="min-width: 100px; text-align: center;">Street</div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">10.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.6rem;width:100px;">GSIS ID NO.</div>
                    </div>
                </div>
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="gsis" style="font-size:0.9rem;border:none; outline: none; width:300px;">
            </td>
            <td style="padding-left:10px;">
                <div class="d-flex justify-content-around" style="width: 100%;">
                    <!-- Input fields with a min-width to maintain size -->
                    <input type="text" name="hnum"
                        style="font-size:0.9; border:none; outline: none; width:120px; min-width: 120px; margin-left: 25px;"
                        value="">
                    <input type="text" name="street"
                        style="font-size:0.9; border:none; outline: none; width:120px; min-width: 120px; margin-left: 20px"
                        value="">
                </div>

                <div style="border-top: 1px solid black; padding-top: 5px; padding-right: 5px;">
                    <div class="d-flex justify-content-around" style="width: 100%;">
                        <div>
                            Subdivision/Village
                        </div>
                        <div>
                            Barangay
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">11.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.7rem;width:100px;">PAGIBIG ID NO.</div>
                    </div>
                </div>
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="pagibig" style="font-size:0.9rem;border:none; outline: none; width:300px;">
            </td>
            <td style="padding-left:10px;">
                <div class="d-flex justify-content-around" style="width: 100%;">
                    <!-- Input fields with a min-width to maintain size -->
                    <input type="text" name="hnum"
                        style="font-size:0.9; border:none; outline: none; width:120px; min-width: 120px; margin-left: 25px;"
                        value="">
                    <input type="text" name="street"
                        style="font-size:0.9; border:none; outline: none; width:120px; min-width: 120px; margin-left: 20px"
                        value="">
                </div>

                <div style="border-top: 1px solid black; padding-top: 5px; padding-right: 5px;">
                    <div class="d-flex justify-content-around" style="width: 100%;">
                        <div>
                            City/Municipality
                        </div>
                        <div>
                            Province
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex align-items-center">
                    <div style="padding-left:10px; font-size:0.7rem;">12.</div>
                    <div>
                        <div
                            style="padding-left:10px;padding-top:5px; padding-bottom: 5px; font-size:0.7rem;width:100px;">
                            PHILHEALTH NO.</div>
                    </div>
                </div>
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="phil" style="font-size:0.9rem;border:none; outline: none; width:200px;">
            </td>
            <td style="padding-left:10px;">
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex align-items-center">
                    <div style="padding-left:10px;padding-top:5px; padding-bottom: 5px; font-size:0.7rem;">13.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.7rem;width:100px;">SSS NO.</div>
                    </div>
                </div>
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="sss" style="font-size:0.9rem;border:none; outline: none; width:300px;">
            </td>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">19.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.7rem;width:240px;">TELEPHONE NO.</div>
                    </div>
                </div>
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="tele" style="font-size:0.9rem;border:none; outline: none; width:300px;">
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex align-items-center">
                    <div style="padding-left:10px; font-size:0.7rem;">14.</div>
                    <div>
                        <div
                            style="padding-left:10px;padding-top:5px;padding-bottom:5px; font-size:0.7rem;width:100px;">
                            TIN NO.</div>
                    </div>
                </div>
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="tin" style="font-size:0.9rem;border:none; outline: none; width:300px;">
            </td>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">20.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.7rem;width:240px;">MOBILE NO.</div>
                    </div>
                </div>
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="num" style="font-size:0.9rem;border:none; outline: none; width:300px;">
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex align">
                    <div style="padding-left:10px; font-size:0.7rem;">15.</div>
                    <div class="d-flex align-items-center" style="padding-left:10px; font-size:0.6rem;width:100px;">
                        AGENCY EMPLOYEE NO.</div>
                </div>
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="agency" style="font-size:0.7rem;border:none; outline: none; width:300px;">
            </td>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">21.</div>

                    <div style="padding-left:10px; font-size:0.7rem;width:240px;">E-MAIL ADDRESS (if any)</div>

                </div>
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="email" style="font-size:0.9rem;border:none; outline: none; width:300px;">
            </td>
        </tr>
    </table>
</template>

<script setup>

</script>
