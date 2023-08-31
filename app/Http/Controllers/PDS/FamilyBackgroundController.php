<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use App\Models\Children;
use Illuminate\Http\Request;

class FamilyBackgroundController extends Controller
{
    // Display the edit form
    public function edit(Request $request) {
        return inertia('Profile/PDS/FamilyBackground/Edit', [
            'children' => $request->user()->children,
            'family_background' => $request->user()->family_background
        ]);
    }

    // store or update the family background
    public function store_or_update(Request $request){
        $validate = $request->validate([
            'spouse_surname' => "string|max:255|nullable",
            'spouse_first_name' => "string|max:255|nullable",
            'spouse_name_extension' => "string|max:255|nullable",
            'spouse_middle_name' => "string|max:255|nullable",
            'spouse_occupation' => "string|max:255|nullable",
            'spouse_employer_business_name' => "string|max:255|nullable",
            'spouse_business_address' => "string|max:255|nullable",
            'spouse_telephone_number' => "string|max:255|nullable",
            'fathers_surname' => "required|string|max:255|nullable",
            'fathers_first_name' => "required|string|max:255|nullable",
            'fathers_name_extension' => "required|string|max:255|nullable",
            'fathers_middle_name' => "required|string|max:255|nullable",
            'mothers_surname' => "required|string|max:255|nullable",
            'mothers_first_name' => "required|string|max:255|nullable",
            'mothers_middle_name' => "required|string|max:255|nullable",
        ]);

        if(!$request->user()->family_background()->exists()){
            $request->user()->family_background()->create($validate);
            return back()->with('success', 'Family background has been saved.');
        }else{
            $request->user()->family_background()->update($validate);
            return back()->with('success', 'Family background has been updated.');
        }

        
    }

    //  function to add children
    public function store_child(Request $request) {
        $validate = $request->validate([
            'fullname' => 'required|string|max:255',
            'date_of_birth' => 'required|date'
        ]);

        $request->user()->children()->create($validate);

        return back()->with('success', 'Record saved.');
    }

    // delete child function
    public function delete_child(Children $children) {
        $children->delete();
        return back()->with('success', 'Successfully Deleted.');
    }
}
