<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EducationalBackgroundController extends Controller
{
    public function edit(Request $request) {
        return inertia('Profile/PDS/EducationalBackground/Edit', [
            "educational_background" => $request->user()->educational_background,
            "college_graduate_studies" => $request->user()->college_graduate_studies->load('files')
        ]);
    }

    public function store_or_update(Request $request){
        $validate = $request->validate([
            "elem_name_of_school" => "required|string|max:255",
            "elem_basic_ed_degree_course" => "string|max:255|nullable",
            "elem_period_from" => "required|integer",
            "elem_period_to" => "required|integer",
            "elem_highest_lvl_units_earned" => "integer|nullable",
            "elem_year_graduated" => "required|integer",
            "elem_scholarship_academic_honors" => "string|max:255|nullable",
            "second_name_of_school" => "required|string|max:255",
            "second_basic_ed_degree_course" => "string|max:255|nullable",
            "second_period_from" => "required|integer",
            "second_period_to" => "required|integer",
            "second_highest_lvl_units_earned" => "integer|nullable",
            "second_year_graduated" => "required|integer",
            "second_scholarship_academic_honors" => "string|max:255|nullable",
            "vocational_name_of_school" => "string|max:255|nullable",
            "vocational_basic_ed_degree_course" => "string|max:255|nullable",
            "vocational_period_from" => "integer|nullable",
            "vocational_period_to" => "integer|nullable",
            "vocational_highest_lvl_units_earned" => "integer|nullable",
            "vocational_year_graduated" => "integer|nullable",
            "vocational_scholarship_academic_honors" => "string|max:255|nullable",
            // "college_name_of_school" => "string|max:255|nullable",
            // "college_basic_ed_degree_course" => "string|max:255|nullable",
            // "college_period_from" => "integer|nullable",
            // "college_period_to" => "integer|nullable",
            // "college_highest_lvl_units_earned" => "integer|nullable",
            // "college_year_graduated" => "integer|nullable",
            // "college_scholarship_academic_honors" => "string|max:255|nullable",
            // "graduate_name_of_school" => "string|max:255|nullable",
            // "graduate_basic_ed_degree_course" => "string|max:255|nullable",
            // "graduate_period_from" => "integer|nullable",
            // "graduate_period_to" => "integer|nullable",
            // "graduate_highest_lvl_units_earned" => "integer|nullable",
            // "graduate_year_graduated" => "integer|nullable",
            // "graduate_scholarship_academic_honors" => "string|max:255|nullable",
        ]);

        if(!$request->user()->educational_background()->exists()){
            $request->user()->educational_background()->create($validate);
            return back()->with('success', 'Educational background has been saved.');
        }else{
            $request->user()->educational_background()->update($validate);
            return back()->with('success', 'Educational background has been updated.');
        }
    }
}
