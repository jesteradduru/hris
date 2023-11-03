<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobApplicationResults;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicationHistoryController extends Controller
{
    public function index(Request $request){
        $job_posting = JobPosting::find($request->job_posting);

        return inertia('Admin/Recruitment/JobApplication/History/Index',
            [
                'application_results' => $job_posting->load([
                    'results'
                ])
            ]
        );
    }

    public function show(Request $request, JobPosting $job_posting){
        $applicant_details = null;
        $activeResult = JobApplicationResults::find($request->result);

        if($request->applicant){
            $applicant_details = User::find($request->applicant)->load([
                'personal_information',
                'educational_background',
                'civil_service_eligibility',
                'work_experience',
                'learning_and_development',
                'other_information',
                'job_application' => fn($query) => $query->with([
                    'document',
                    'result' => fn($query) =>  $query->where('result_id', $request->result)->first()
                ])->where('job_posting_id', $request->job_posting->id)
            ]);
        }

        return inertia('Admin/Recruitment/JobApplication/History/Show', [
            "job_applications" => $activeResult->load([
                'result' => [
                    'application', 'user'
                ]
            ]),
            // "job_vacancy_status" => $result,
            "posting" => $job_posting,
            "applicant_details" => $applicant_details,
            "result" => $activeResult->load([
                'result' => [
                    'application', 'user'
                ]
            ]),
            "application_results" => $job_posting->results
        ]);
    }
}
