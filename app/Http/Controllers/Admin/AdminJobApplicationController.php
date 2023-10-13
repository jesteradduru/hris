<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;

class AdminJobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $job_posting = JobPosting::all();
        $job_application = [];
        $applicant = null;

        // dd($request->applicant);

        if($request->job_posting){
            $job_application = JobApplication::with(['user'])->where('job_posting_id', $request->job_posting)->get();
        }
        if($request->applicant){
            $applicant = User::find($request->applicant)->load([
                'personal_information',
                'educational_background',
                'civil_service_eligibility',
                'work_experience',
                'learning_and_development',
                'other_information'
            ]);
        }
        // dd($applicant);
        return inertia('Admin/Recruitment/Selection/Index', [
            // "applications" => $job_posting->job_application()->with(['document', 'user'])->paginate()->withQueryString(),
            "posting" => $job_posting,
            "application" => $job_application,
            "posting_id" => $request->job_posting,
            "applicant" => $applicant
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(JobApplication $jobApplication)
    {
        return inertia('Admin/Recruitment/JobApplication/Show', [
            'application' => $jobApplication->load(['job_posting', 'document', 
                'user' => fn($query) => $query->with(['personal_information'])
            ])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobApplication $jobApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobApplication $jobApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $jobApplication)
    {
        //
    }
}
