<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationResult;
use App\Models\ApplicationScore;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\PlantillaPosition;
use App\Models\SpmsForm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminJobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $job_vacancy_status = null;

        if($request->job_posting){
            $job_vacancy = JobPosting::find($request->job_posting);
            $job_vacancy_status = $job_vacancy->results()->orderBy('created_at', 'DESC')->first();
        }

        if($request->job_posting && $job_vacancy_status->phase === 'INITIAL_SCREENING'){
            return self::initial_screening($request, $job_vacancy_status);
        }
        // SHORTLISTING
        else if($request->job_posting && $job_vacancy_status->phase === 'SHORTLISTING'){
            return self::shortlisting($request);
        }
        // NEDA EXAM
        else if($request->job_posting && $job_vacancy_status->phase === 'NEDA_EXAM'){
            return self::neda_exam($request);
        }
        // INTERVIEW SCHEDULE
        else if($request->job_posting && $job_vacancy_status->phase === 'INTERVIEW_SCHEDULE'){
            return self::interview_schedule($request);
        }
        // INTERVIEW
        else if($request->job_posting && $job_vacancy_status->phase === 'FOR_INTERVIEW'){
            return self::interview($request);
        }
        // FINAL
        else if($request->job_posting && $job_vacancy_status->phase === 'FINAL'){
            return self::final($request);
        }
        // SELECTION
        else if($request->job_posting && $job_vacancy_status->phase === 'SELECTION'){
            return self::final($request);
        }
        // NO SELECTED JOB VACANCY
        else{
            $job_vacancies = JobPosting::notArchived()->get();

            return inertia('Admin/Recruitment/Selection/Index', [
                "job_vacancies" => $job_vacancies,
                "posting_id" => null,
            ]);
        }

    }


    public function show(JobApplication $jobApplication)
    {
        return inertia('Admin/Recruitment/JobApplication/Show', [
            'application' => $jobApplication->load(['job_posting', 'document', 
                'user' => fn($query) => $query->with(['personal_information'])
            ])
        ]);
    }

    // INITIAL SCREENING
    private static function initial_screening(Request $request, $job_vacancy_status){
        // dd('initial_screen');
        $job_vacancies = JobPosting::notArchived()->get();
        $job_applications = [];
        $applicant_details = null;

        if($request->applicant){
            $applicant_details = User::find($request->applicant)->load([
                'personal_information',
                'educational_background',
                'civil_service_eligibility'  => ['files'],
                'work_experience',
                'learning_and_development',
                'other_information',
                'job_application' => fn($query) => $query->with('document')->where('job_posting_id', $request->job_posting),
                'spms',
                'position',
                'college_graduate_studies' => ['files', 'academic_award'],
                'academic_distinction'=> ['files'],
                'non_academic_distinction' => ['files'],
            ]);
        }

        $job_applications = JobApplication::with(
            [
                'result',
                'user' => fn($query) => $query->orderBy('surname', 'desc')
            ])->where('job_posting_id', $request->job_posting)->get();

           
        return inertia('Admin/Recruitment/Selection/InitialScreening/Index', [
            "job_applications" => $job_applications,
            "job_vacancies" => $job_vacancies,
            "job_vacancy_status" => $job_vacancy_status,
            "posting" => JobPosting::find($request->job_posting)->load(['plantilla']),
            "applicant_details" => $applicant_details,
        ]);
    }


    // SHORTLISTING
    private static function shortlisting(Request $request){
        $job_vacancies = JobPosting::notArchived()->get();
        $job_applications = [];
        $applicant_details = null;
        $latestSpms = null;
        

        // dd($job_vacancies);

        if($request->job_posting){
            $job_vacancy = JobPosting::find($request->job_posting);
            $job_vacancy_status = $job_vacancy->results()->orderBy('created_at', 'DESC')->first();
        }

        if($request->applicant){
            $user = User::find($request->applicant);

            if($user->hasRole('employee')){
                $posting_date = Carbon::parse($job_vacancy->posting_date);

                if($posting_date->month <= 6){
                    $previousYear = $posting_date->year - 1;
                    $latestSpms = $user->spms()
                                    ->where('year', $previousYear)
                                    ->where(function (Builder $query) {
                                        $query->where('semester', 'FIRST')
                                            ->orWhere('semester', 'SECOND');
                                    })->get();
                }else if($posting_date->month > 6 && $posting_date->month <= 12){
                    $currentYear = $posting_date->year;
                    $latestSpms = $user->spms()
                                    ->where(function (Builder $query) use($currentYear) {
                                        $query->where('semester', 'FIRST')
                                                ->where('year', $currentYear);
                                    })
                                    ->orWhere(function (Builder $query) use($currentYear) {
                                        $query->where('year', $currentYear - 1)
                                            ->where('semester', 'SECOND');
                                    })->get();
                }
            }

            $applicant_details = $user->load([
                'personal_information',
                'educational_background',
                'civil_service_eligibility'  => ['files'],
                'work_experience',
                'learning_and_development',
                'other_information',
                'job_application' => fn($query) => $query->with(['document', 'included'])->where('job_posting_id', $request->job_posting),
                'spms',

                // 'reward' => ['reward'],
                'position',
                'college_graduate_studies' => ['files', 'academic_award'],
                'academic_distinction'=> ['files'],
                'non_academic_distinction' => ['files'],
                'pes_rating',
            ]);
        }

        $latest_result = ApplicationResult::with(['application', 'user' => fn($query) => $query->orderBy('surname', 'desc')])->where('result_id', $job_vacancy_status->id)->get();

        return inertia('Admin/Recruitment/Selection/Shortlisting/Index', [
            "job_applications" => $job_applications,
            "job_vacancies" => $job_vacancies,
            "job_vacancy_status" => $job_vacancy_status,
            "posting" => JobPosting::find($request->job_posting)->load(['plantilla']),
            "applicant_details" => $applicant_details,
            "qualified_applicants" => $latest_result,
            'latest_spms' => $latestSpms,
        ]);

}


    // NEDA EXAM
    private static function neda_exam(Request $request){
            $job_vacancies = JobPosting::notArchived()->get();
            $job_applications = [];
            $applicant_details = null;
            

            // dd($job_vacancies);

            if($request->job_posting){
                $job_vacancy = JobPosting::find($request->job_posting);
                $job_vacancy_status = $job_vacancy->results()->orderBy('created_at', 'DESC')->first();
            }

            if($request->applicant){
                $applicant_details = User::find($request->applicant)->load([
                    'personal_information',
                    'educational_background',
                    'college_graduate_studies' => ['files'],
                    'civil_service_eligibility'  => ['files'],
                    'work_experience',
                    'learning_and_development',
                    'other_information',
                    'job_application' => fn($query) => $query->with(['document','included'])->where('job_posting_id', $request->job_posting),
                    'spms',
                    // 'reward' => ['reward'],
                    'position',
                    'college_graduate_studies' => ['files', 'academic_award'],
                    'academic_distinction'=> ['files'],
                    'non_academic_distinction' => ['files'],
                    'pes_rating',
                    
                ]);
            }

            $latest_result = ApplicationResult::with(['application', 'user' => fn($query) => $query->orderBy('surname', 'desc')])->where('result_id', $job_vacancy_status->id)->get();

            return inertia('Admin/Recruitment/Selection/Exam/Index', [
                "job_applications" => $job_applications,
                "job_vacancies" => $job_vacancies,
                "job_vacancy_status" => $job_vacancy_status,
                "posting" => JobPosting::find($request->job_posting)->load(['plantilla']),
                "applicant_details" => $applicant_details,
                "qualified_applicants" => $latest_result,
            ]);

    }

    // INTERVIEW SCHEDULE
    private static function interview_schedule(Request $request){
            $job_vacancies = JobPosting::notArchived()->get();
            $job_applications = [];
            $applicant_details = null;
            

            // dd($job_vacancies);

            if($request->job_posting){
                $job_vacancy = JobPosting::find($request->job_posting);
                $job_vacancy_status = $job_vacancy->results()->orderBy('created_at', 'DESC')->first();
            }

            if($request->applicant){
                $applicant_details = User::find($request->applicant)->load([
                    'personal_information',
                    'educational_background',
                    'college_graduate_studies' => ['files'],
                    'civil_service_eligibility'  => ['files'],
                    'work_experience',
                    'learning_and_development',
                    'other_information',
                    'job_application' => fn($query) => $query->with(['document', 'included'])->where('job_posting_id', $request->job_posting),
                    'spms',
                    // 'reward' => ['reward'],
                    'position',
                    'college_graduate_studies' => ['files', 'academic_award'],
                    'academic_distinction'=> ['files'],
                    'non_academic_distinction' => ['files'],
                    'pes_rating',
                ]);
            }

            $latest_result = ApplicationResult::with(['application', 'user' => fn($query) => $query->orderBy('surname', 'desc')])->where('result_id', $job_vacancy_status->id)->get();
            
            return inertia('Admin/Recruitment/Selection/InterviewSchedule/Index', [
                "job_applications" => $job_applications,
                "job_vacancies" => $job_vacancies,
                "job_vacancy_status" => $job_vacancy_status,
                "posting" => JobPosting::find($request->job_posting)->load(['plantilla']),
                "applicant_details" => $applicant_details,
                "qualified_applicants" => $latest_result,
            ]);

    }

    // INTERVIEW
    private static function interview(Request $request){
        $job_vacancies = JobPosting::notArchived()->get();
        $job_applications = [];
        $applicant_details = null;
        

        // dd($job_vacancies);

        if($request->job_posting){
            $job_vacancy = JobPosting::find($request->job_posting);
            $job_vacancy_status = $job_vacancy->results()->orderBy('created_at', 'DESC')->first();
        }

        if($request->applicant){
            $applicant_details = User::find($request->applicant)->load([
                'personal_information',
                'educational_background',
                'college_graduate_studies' => ['files'],
                'civil_service_eligibility'  => ['files'],
                'work_experience',
                'learning_and_development',
                'other_information',
                'job_application' => fn($query) => $query->with(['document', 'included', 'psb_points'])->where('job_posting_id', $request->job_posting),
                'spms',
                'position',
                'college_graduate_studies' => ['files', 'academic_award'],
                'academic_distinction'=> ['files'],
                'non_academic_distinction' => ['files'],
                'pes_rating',
                
            ]);
        }

        $latest_result = ApplicationResult::with(['application', 'user' => fn($query) => $query->orderBy('surname', 'desc')])->where('result_id', $job_vacancy_status->id)->get();
            
        return inertia('Admin/Recruitment/Selection/Interview/Index', [
            "job_applications" => $job_applications,
            "job_vacancies" => $job_vacancies,
            "job_vacancy_status" => $job_vacancy_status,
            "posting" => JobPosting::find($request->job_posting)->load(['plantilla']),
            "applicant_details" => $applicant_details,
            "qualified_applicants" => $latest_result,
        ]);

    }


    // FINAL
    private static function final(Request $request){
        $job_vacancies = JobPosting::notArchived()->get();
        $job_applications = [];
        $applicant_details = null;
        

        // dd($job_vacancies);

        if($request->job_posting){
            $job_vacancy = JobPosting::find($request->job_posting);
            $job_vacancy_status = $job_vacancy->results()->orderBy('created_at', 'DESC')->first();
        }

        // if($request->applicant){
        //     $applicant_details = User::find($request->applicant)->load([
        //         'personal_information',
        //         'educational_background',
        //         'college_graduate_studies' => ['files'],
        //         'civil_service_eligibility'  => ['files'],
        //         'work_experience',
        //         'learning_and_development',
        //         'other_information',
        //         'job_application' => fn($query) => $query->with(['document', 'included', 'psb_points'])->where('job_posting_id', $request->job_posting),
        //         'spms',
        //         'position',
        //         'college_graduate_studies' => ['files', 'academic_award'],
        //         'academic_distinction'=> ['files'],
        //         'non_academic_distinction' => ['files'],
        //         'pes_rating',
        //     ]);
        // }

        // $latest_result = ApplicationResult::with([
        //     'application',
        //     'user' => fn($query) => $query->orderBy('surname', 'desc')])->where('result_id', $job_vacancy_status->id)->get();

        // $filters = $request->only(['rank_by']);


        // dd($job_vacancy_status->load(['result' => [
        //     'application' => [
        //         'scores',
        //         'user'
        //     ]
        // ]]));


        $posting_with_score =  $job_vacancy_status->load(['job_posting', 'result' => [
            'application' => [
                'scores',
                'user'
            ]
        ]]);

        // dd($posting_with_score);

        return inertia('Admin/Recruitment/Selection/Final/Index', [
            "job_applications" => $job_applications,
            "job_vacancies" => $job_vacancies,
            "job_vacancy_status" => $job_vacancy_status,
            "posting" => $posting_with_score,
            "positions" => PlantillaPosition::doesntHave('user')->with('division')->get()
        ]);

    }

}
