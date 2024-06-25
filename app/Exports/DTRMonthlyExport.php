<?php

namespace App\Exports;

use App\Models\DailyTimeRecord;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DTRMonthlyExport implements FromCollection, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $year, $month, $user_id;

    public function __construct(int $year, int $month, $user_id)
    {
        $this->year = $year;
        $this->month = $month;
        $this->user_id = $user_id;
    }

    public function collection()
    {
        $dateTimeRecord = DB::table('daily_time_record')
            ->select(['date_time', 'remark'])
            ->where('user_id', '=', $this->user_id)
            ->where(DB::raw("DATE_FORMAT(date_time, '%Y-%m')"), "{$this->year}-{$this->month}")
            ->get();

            dd($dateTimeRecord);
        return $dateTimeRecord;
    }

    public function styles(Worksheet $sheet)
    {
        $pdsfile='./pds/DTR.xlsx';
        /** Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($pdsfile);

        $activeSheet = $spreadsheet->getActiveSheet();
        $user = User::where('dtr_user_id', $this->user_id)->first();

        $activeSheet->setCellValue('A4', $user->name);
        
    }
}
