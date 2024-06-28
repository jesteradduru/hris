<?php

namespace App\Http\Controllers\Admin;

use App\Exports\JobApplicationResultExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class ExportJobApplicationReportsController extends Controller
{
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }
    
    public function export(Request $request){
        $posting = $request->job_posting;

        return $this->excel->download(new JobApplicationResultExport($posting), 'result.xlsx');
    }
}
