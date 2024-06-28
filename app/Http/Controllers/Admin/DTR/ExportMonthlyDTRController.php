<?php

namespace App\Http\Controllers\Admin\DTR;

use App\Exports\DTRIndividualMonthlyExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class ExportMonthlyDTRController extends Controller
{
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }
    


    public function index(){
        return inertia('Admin/DailyTimeRecord/Export/Index');
    }

    public function export(Request $request){
       
        $month = $request->month;
        $year = $request->year;

        return $this->excel->download(new DTRIndividualMonthlyExport($year, $month, 3), 'dtr.xlsx');
    }
}
