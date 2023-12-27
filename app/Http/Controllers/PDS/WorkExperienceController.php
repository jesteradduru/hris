<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use App\Models\WorkExperience;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('Profile/PDS/WorkExperience/Index', [
            'work_experiences' => $request->user()->work_experience()->mostRecent()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Profile/PDS/WorkExperience/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            "inclusive_date_from"=> "required|date",
            "inclusive_date_to"=> "required_if:to_present,false|date|nullable",
            "position_title"=> "required|string",
            "dept_agency_office_company"=> "required|string",
            "name_of_office_unit"=> "string|nullable",
            "office_address"=> "string",
            "immediate_supervisor"=> "string|nullable",
            "monthly_salary"=> "required|decimal:2",
            "paygrade"=> "string|nullable",
            "status_of_appointment"=> "string|nullable",
            "govt_service"=> "boolean|nullable",
            "list_of_accomplishments"=> "string|nullable",
            "summary_of_duties"=> "string|nullable",
            "to_present" => "boolean"
        ]);

        $request->user()->work_experience()->create($validate);

        return back()->with('success', 'Work experience has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkExperience $workExperience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkExperience $workExperience)
    {
        return inertia('Profile/PDS/WorkExperience/Edit', [
            "work_experience" => $workExperience
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkExperience $workExperience)
    {
        $validate = $request->validate([
            "inclusive_date_from"=> "required|date",
            "inclusive_date_to"=> "required_if:to_present,false|date|nullable",
            "position_title"=> "required|string",
            "dept_agency_office_company"=> "required|string",
            "name_of_office_unit"=> "string|nullable",
            "office_address"=> "string",
            "immediate_supervisor"=> "string|nullable",
            "monthly_salary"=> "required|decimal:2",
            "paygrade"=> "string|nullable",
            "status_of_appointment"=> "string|nullable",
            "govt_service"=> "boolean|nullable",
            "list_of_accomplishments"=> "string|nullable",
            "summary_of_duties"=> "string|nullable",
            "to_present" => "boolean"
        ]);

        $workExperience->update($validate);

        return back()->with('success', 'Work experience has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkExperience $workExperience)
    {
        $workExperience->delete();
        return back()->with('success', 'Work experience has been deleted.');
    }
}
