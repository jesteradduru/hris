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
        // dd($request->input('same_address'));
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
            "gsis_id_number" =>"required|string|max:255",
            "pagibig_id_number" =>"required|string|max:255",
            "sss_number" =>"required|string|max:255",
            "philhealth_number" =>"required|string|max:255",
            "tin_number" =>"required|string|max:255",
            "agency_employee_number" =>"string|max:255",
            "r_address_house_block_lot_number" =>"required|string|max:255",
            "r_address_street" =>"required|string|max:255",
            "r_address_subdivision_village" =>"required|string|max:255",
            "r_address_barangay" =>"required|string|max:255",
            "r_address_city_municipality" =>"required|string|max:255",
            "r_address_zipcode" =>"required|string|max:255",
            "r_address_province" => "required|string|max:255",
            "p_address_house_block_lot_number" =>"required_unless:same_address,true|string|max:255|nullable",
            "p_address_street" =>"required_unless:same_address,true|string|max:255|nullable",
            "p_address_subdivision_village" =>"required_unless:same_address,true|string|max:255|nullable",
            "p_address_barangay" =>"required_unless:same_address,true|string|max:255|nullable",
            "p_address_city_municipality" =>"required_unless:same_address,true|string|max:255|nullable",
            "p_address_zipcode" =>"required_unless:same_address,true|string|max:255|nullable",
            "p_address_province" => "required_unless:same_address,true|string|max:255|nullable",
            "telephone_number" =>"string|nullable",
            "mobile_number" =>"required|string",
            "email_address" =>"required|email|max:255",
            "duplicate_address" =>"boolean",
            "civil_status" =>"required|string|max:255",
            "other_civil_status" =>"string|max:255|nullable",
            "dual_citizenship" =>"boolean",
            "filipino" => "boolean",
            "by_birth" =>" boolean",
            "by_naturalization" =>"boolean",
            "country" =>"string|max:255|nullable",
            "religion" =>"string|max:255|nullable",
            "ethnicity" =>"string|max:255|nullable",
            "same_address" => "boolean"
        ], [
            "r_address_house_block_lot_number.required" =>"This field is required.",
            "r_address_street.required" =>"This field is required.",
            "r_address_subdivision_village.required" =>"This field is required.",
            "r_address_barangay.required" =>"This field is required.",
            "r_address_city_municipality.required" =>"This field is required.",
            "r_address_zipcode.required" =>"This field is required.",
            "r_address_province.required" => "This field is required.",
            "p_address_house_block_lot_number.required_unless" =>"This field is required.",
            "p_address_street.required_unless" =>"This field is required.",
            "p_address_subdivision_village.required_unless" =>"This field is required.",
            "p_address_barangay.required_unless" =>"This field is required.",
            "p_address_city_municipality.required_unless" =>"This field is required.",
            "p_address_zipcode.required_unless" =>"This field is required.",
            "p_address_province.required_unless" => "This field is required.",
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
