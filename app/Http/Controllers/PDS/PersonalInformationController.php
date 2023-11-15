<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use App\Models\PersonalInformation;
use Illuminate\Http\Request;

class PersonalInformationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */

    public function edit(Request $request){
        return inertia('Profile/PDS/PersonalInformation/Edit', [
            "personal_information" => $request->user()->personal_information,
            "profile" => $request->user()
        ]);
    }
    

    public function store_or_update(Request $request)
    {
        $validateData = $request->validate([
            "surname" => "required|string|max:255",
            "first_name" =>"required|string|max:255",
            "middle_name" =>"required|string|max:255",
            "name_extension" =>"string|max:255|nullable",
            "date_of_birth" =>"required|string|max:255",
            "place_of_birth" =>"required|string|max:255",
            "sex" =>"required|string|max:255",
            "height" =>"required|string|nullable",
            "weight" =>" required|string|nullable",
            "blood_type" =>"required|string|max:255",
            "gsis_id_number" =>"string|max:255|nullable",
            "pagibig_id_number" =>"string|max:255|nullable",
            "sss_number" =>"string|max:255|nullable",
            "philhealth_number" =>"string|max:255|nullable",
            "tin_number" =>"string|max:255|nullable",
            "agency_employee_number" =>"string|max:255|nullable",
            "r_address_house_block_lot_number" =>"string|max:255|nullable",
            "r_address_street" =>"string|max:255|nullable",
            "r_address_subdivision_village" =>"string|max:255|nullable",
            "r_address_barangay" =>"string|max:255|nullable",
            "r_address_city_municipality" =>"string|max:255|nullable",
            "r_address_zipcode" =>"string|max:255|nullable",
            "r_address_province" => "string|max:255|nullable",
            "p_address_house_block_lot_number" =>"string|max:255|nullable",
            "p_address_street" =>"string|max:255|nullable",
            "p_address_subdivision_village" =>"string|max:255|nullable",
            "p_address_barangay" =>"string|max:255|nullable",
            "p_address_city_municipality" =>"string|max:255|nullable",
            "p_address_zipcode" =>"string|max:255|nullable",
            "p_address_province" => "string|max:255|nullable",
            "telephone_number" =>"string|nullable",
            "mobile_number" =>"string|nullable",
            "email_address" =>"email|max:255|nullable",
            "duplicate_address" =>"boolean",
            "civil_status" =>"required|string|max:255",
            "other_civil_status" =>"string|max:255|nullable",
            "dual_citizenship" =>"boolean",
            "filipino" => "boolean",
            "by_birth" =>" boolean",
            "by_naturalization" =>"boolean",
            "country" =>"string|max:255|nullable",
            "same_address" => "boolean"
        ]);

        if($request->user()->personal_information()->exists()){ // IF PROFILE INFORMATION EXISTS, UPDATE PERSONAL INFO
            $request->user()->personal_information()->update($validateData);
            return back()->with('success', 'Personal information updated.');
        }else{ //  // IF PROFILE INFORMATION DOESN'T EXISTS, CREATE PERSONAL INFO
            $request->user()->personal_information()->create($validateData);
            return back()->with('success', 'Personal information saved.');
        }
    }
}
