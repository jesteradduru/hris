<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ApplicantExport;
use App\Exports\NedaExamResultsExport;
use App\Exports\ShortlistedApplicants;
use App\Http\Controllers\Controller;
use App\Models\JobApplicationResults;
use App\Models\JobPosting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class ReportController extends Controller
{

    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function index() {

        return inertia('Admin/Reports/Index', [
            'job_posting' => JobPosting::with(['plantilla'])->get()
        ]);
    }

    public function export(Request $request, ) {
        $posting = $request->posting;

        
        if($request->report === 'applicants' && !$posting){
            return $this->excel->download(new ApplicantExport, 'applicants.xlsx');
        }

        if($request->report === 'applicants' && $posting){
            return $this->excel->download(new ApplicantExport($request->posting), 'applicants.xlsx');
        }

        if($request->report === 'shortlisted' && $posting){
            if(!JobPosting::find($posting)->has('results')->get()){
                abort(403, 'Shortlist not yet created.');
            }
            return $this->excel->download(new ShortlistedApplicants($request->posting), 'shortlist.xlsx');
        }

        if($request->report === 'shortlisted' && !$posting){
            return $this->excel->download(new ShortlistedApplicants(), 'shortlist.xlsx');
        }


        if($request->report === 'exam' && $posting){
            if(!JobApplicationResults::where('job_posting_id', $posting)->where('phase', '=', 'NEDA_EXAM')->exists()){
                abort(403, 'Exam results not yet created.');
            }
            return $this->excel->download(new NedaExamResultsExport($request->posting), 'exam.xlsx');
        }

        if($request->report === 'exam' && !$posting){
            return $this->excel->download(new NedaExamResultsExport(), 'exam.xlsx');
        }

    }

    
}
