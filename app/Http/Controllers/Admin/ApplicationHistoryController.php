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
                'college_graduate_studies' => ['files'],
                'civil_service_eligibility'  => ['files'],
                'work_experience',
                'learning_and_development',
                'other_information',
                'job_application' => fn($query) => $query->with(['document', 'included', 'psb_points'])->where('job_posting_id', $job_posting->id),
                'spms',
                'position',
                'college_graduate_studies' => ['files', 'academic_award'],
                'academic_distinction'=> ['files'],
                'non_academic_distinction' => ['files'],
                'pes_rating',
                
            ]);
        }
        
        
        $posting_with_score =  $activeResult->load([
                'result' => [
                     'application' => ['scores', 'user']
                 ]
        ]);

        $posting_with_score = $posting_with_score->result->map(function($item) {
            return $item->application;
        });

        // dd($posting_with_score);


        return inertia('Admin/Recruitment/JobApplication/History/Show', [
            "posting" => $job_posting,
            "posting_with_scores" => $posting_with_score,
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
