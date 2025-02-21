<template>

<table class="table-bordered" style="border:black; margin-top:1px; font-size:11px; width:100%;">
        <!-- Section Header Row -->
        <tr>
            <td colspan="5">
                <div
                    style="padding-left:10px; text-align:start; font-size:1.2rem;background:gray; color:white; width:100%;">
                    <i>II. FAMILY BACKGROUND</i>
                </div>
            </td>
        </tr>
        <tr>
            <td rowspan="3" style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">22.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.6rem;width:100px;">
                            <div class="pb-3">SPOUSE'S SURNAME</div> LASTNAME <br><br> MIDDLE NAME
                        </div>
                    </div>
                </div>
            </td>
            <td colspan="2" style="padding-left:10px;padding-top:10px;padding-left:10px;">
                <input name="ssname" type="text" style="font-size:0.9rem;border:none; outline: none;">
            </td>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">23.</div>
                    <div>
                        <div style="padding-left:5px; font-size:0.7rem;width:300px;">NAME of CHILDREN (Write fullname
                            and list all)</div>
                    </div>
                </div>
            </td>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px;padding-right:10px; font-size:0.7rem;">DATE OF BIRTH (mm/dd/yyyy)
                    </div>

                </div>
            </td>
        </tr>
        <tr>
            <td style="padding-left:10px;">
                <input type="text" name="slname" style="font-size:0.9rem;border:none; outline: none; width:300px;">
            </td>
            <td style="background-color:lightgray;color:black;">
                NAME EXTENSION (JR., SR)
                <input type="text"
                    style="padding-left:10px;padding-top:10px;padding-bottom:10px;background:lightgray;font-size:0.7rem;border:none; outline: none; width:50px;"
                    value="cxxccccccc">
            </td>
            <td style="padding-left:10px;">
                <input name="ch1" type="text" style="font-size:0.9rem;border:none; outline: none; width:200px;">
            </td>
            <td style="padding-left:10px;">
                <div>
                    <input type="text" name="ch1b" style="font-size:0.9rem;border:none; outline: none; color:black;"
                        placeholder>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left:10px;">
                <input type="text" name="smname"
                    style="padding-top:10px;padding-bottom:10px;font-size:0.7rem;border:none; outline: none; width:200px;">
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="ch1" style="font-size:0.7rem;border:none; outline: none; width:200px;">
            </td>
            <td style="padding-left:10px;">
                <div>
                    <input type="text" name="ch1b" style="font-size:0.7rem;border:none; outline: none; color:black;"
                        placeholder>
                </div>
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;height: 40px;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;"></div>
                    <div
                        style="padding-left: 22px; padding-top: 5px; padding-bottom: 5px; font-size:0.6rem;width:80px;">
                        OCCUPATION</div>
                </div>
            </td>
            <td colspan="2" style="padding-left:10px;">
                <input type="text" name="accu" style="font-size:0.7rem;border:none; outline: none; width:200px;">
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="ch1" style="font-size:0.7rem;border:none; outline: none; width:200px;">
            </td>
            <td style="padding-left:10px;">
                <div>
                    <input type="text" name="ch1b" style="font-size:0.7rem;border:none; outline: none; color:black;"
                        placeholder>
                </div>
            </td>
        </tr>

        <tr>
            <td style="background:lightgray;color:black;height: 40px;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;"> </div>
                    <div>
                        <div style="padding-left:22px; font-size:0.6rem;width:90px;">EMPLOYER/BUSINESS NAME</div>
                    </div>
                </div>
            </td>
            <td colspan="2" style="padding-left:10px;">
                <input type="text" name="emname" style="font-size:0.7rem;border:none; outline: none; width:200px;">
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="ch1" style="font-size:0.7rem;border:none; outline: none; width:200px;">
            </td>
            <td style="padding-left:10px;">
                <div>
                    <input type="text" name="ch1b" style="font-size:0.7rem;border:none; outline: none; color:black;"
                        placeholder>
                </div>
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;"> </div>
                    <div>
                        <div style="padding-left: 22px; font-size:0.6rem;width:80px;">BUSINESS NAME</div>
                    </div>
                </div>
            </td>
            <td colspan="2" style="padding-left:10px;">
                <input type="text" name="busname" style="font-size:0.7rem;border:none; outline: none; width:200px;"
                    value="">
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="ch1" style="font-size:0.7rem;border:none; outline: none; width:200px;"
                    value="">
            </td>
            <td style="padding-left:10px;">
                <div>
                    <input type="text" name="ch1b" style="font-size:0.7rem;border:none; outline: none; color:black;"
                        placeholder>
                </div>
            </td>
        </tr>
        <tr>
            <td style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;"> </div>
                    <div>
                        <div style="padding-left:22px; font-size:0.6rem;width: 80px;">TELEPHONE NO.</div>
                    </div>
                </div>
            </td>
            <td colspan="2" style="padding-left:10px;">
                <input type="text" name="ftele" style="font-size:0.7rem;border:none; outline: none; width:200px;"
                    value="">
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="ch1" style="font-size:0.7rem;border:none; outline: none; width:200px;"
                    value="">
            </td>
            <td style="padding-left:10px;">
                <div>
                    <input type="text" name="ch1b" style="font-size:0.7rem;border:none; outline: none; color:black;"
                        placeholder>
                </div>
            </td>
        </tr>
        <tr>
            <td rowspan="3" style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">24.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.7rem;width:100px;"> FATHER'S SURNAME <br><br>
                            LASTNAME <br><br> MIDDLE NAME</div>
                    </div>
                </div>
            </td>
            <td colspan="2" style="padding-left:10px;">
                <input type="text" name="fsname" style="font-size:0.7rem;border:none; outline: none;" value="">
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="ch1" style="font-size:0.7rem;border:none; outline: none;" value="">
            </td>
            <td style="padding-left:10px;">
                <div>
                    <input type="text" name="ch1b" style="font-size:0.7rem;border:none; outline: none; color:black;"
                        placeholder>
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding-left:10px;">
                <input type="text" name="flname" style="font-size:0.7rem;border:none; outline: none; width:300px;"
                    value="">
            </td>
            <td style="background-color:lightgray;color:black;">
                NAME EXTENSION (JR., SR)
                <input type="text"
                    style="padding-left:10px;background:lightgray;font-size:0.7rem;border:none; outline: none; width:50px;"
                    value="">
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="ch1" style="font-size:0.7rem;border:none; outline: none; width:200px;"
                    value="">
            </td>
            <td style="padding-left:10px;">
                <div>
                    <input type="text" name="ch1b" style="font-size:0.7rem;border:none; outline: none; color:black;"
                        placeholder>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left:10px;">
                <input type="text" name="fmname" style="font-size:0.7rem;border:none; outline: none; width:300px;"
                    value="">
            </td>

            <td style="padding-left:10px;">
                <input type="text" name="ch1" style="font-size:0.7rem;border:none; outline: none; width:200px;"
                    value="">
            </td>
            <td style="padding-left:10px;">
                <div>
                    <input type="text" name="ch1b" style="font-size:0.7rem;border:none; outline: none; color:black;"
                        placeholder>
                </div>
            </td>
        </tr>
        <tr>
            <!-- <td rowspan ="4"style="background:lightgray;color:black;">
                    <div class="d-flex">
                        <div style="padding-left:10px; font-size:0.7rem;">22.</div>

                        <div>
                            <div style="font-size:0.7rem;">
                                MOTHER'S SURNAME
                            </div>
                            <div>
                                LAST NAME
                            </div>
                            <div>
                                MIDDLE NAME
                            </div>
                        </div>
                    </div>
                </td> -->
            <td rowspan="4" style="background:lightgray;color:black;">
                <div class="d-flex">
                    <div style="padding-left:10px; font-size:0.7rem;">25.</div>
                    <div>
                        <div style="padding-left:10px; font-size:0.7rem;width:100px;"> MOTHER'S MAIDEN NAME<br><br>
                            SURNAME <br><br> LASTNAME <br><br> MIDDLE NAME</div>
                    </div>
                </div>
            </td>
            <td colspan="2" style="padding-left:10px;">
                <input type="text" name="msname" style="font-size:0.7rem;border:none; outline: none;" value="">
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="ch1" style="font-size:0.7rem;border:none; outline: none;" value="">
            </td>
            <td style="padding-left:10px;">
                <div>
                    <input type="text" name="ch1b" style="font-size:0.7rem;border:none; outline: none; color:black;"
                        placeholder>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left:10px;">
                <input type="text" name="ch1" style="font-size:0.7rem;border:none; outline: none; width:300px;"
                    value="">
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="ch1" style="font-size:0.7rem;border:none; outline: none; width:300px;"
                    value="">
            </td>
            <td style="padding-left:10px;">
                <div>
                    <input type="text" name="ch1b" style="font-size:0.7rem;border:none; outline: none; color:black;"
                        placeholder>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left:10px;">
                <input type="text" name="mlname" style="font-size:0.7rem;border:none; outline: none; width:200px;"
                    value="">
            </td>
            <td style="padding-left:10px;">
                <input type="text" name="ch1" style="font-size:0.7rem;border:none; outline: none; width:200px;"
                    value="">
            </td>
            <td style="padding-left:10px;">
                <div>
                    <input type="text" name="ch1b" style="font-size:0.7rem;border:none; outline: none; color:black;"
                        placeholder>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left:10px;">
                <input type="text" name="mmname" style="font-size:0.7rem;border:none; outline: none; width:300px;"
                    value="">
            </td>

            <td colspan="2" style="padding-left:10px;background:lightgray;color:black;">
                <div class="text-center" style="color:red; font-size:0.7rem;"><i>(Continue in separate sheet if
                        necessary)</i></div>
            </td>
        </tr>
    </table>
</template>

<script setup>

</script>
