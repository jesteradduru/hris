<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ApplicantExport;
use App\Http\Controllers\Controller;
use App\Models\JobPosting;
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
        
        if($request->report === 'applicants'){
            return $this->excel->download(new ApplicantExport($request->posting), 'applicants.xlsx');
        }

    }

    
}
