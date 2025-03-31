<?php

namespace App\Exports;

use App\Models\DailyTimeRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Sheet;

class DTRIndividualMonthlyExport implements  WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable, RegistersEventListeners;

    private $year, $month, $user_id, $calledByEvent;

    public function __construct(string $year, string $month, string $user_id)
    {
        $this->year = $year;
        $this->month = $month;
        $this->user_id = $user_id;
        $this->calledByEvent = false;
    }

    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function(BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile('./dtr/DTR.xlsx');
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                $this->populateSheet($sheet);
                
                $event->writer->getSheetByIndex(0)->export($event->getConcernable()); // call the export on the first sheet

                return $event->getWriter()->getSheetByIndex(0);
            },
        ];
    }

    public function populateSheet($sheet)
{
    $user = User::where("dtr_user_id", $this->user_id)->first();
    if ($user) {
        $sheet->setCellValue('A4', $user->name);
        $sheet->setCellValue('D6', date('F', mktime(0, 0, 0, $this->month, 10)) . ' ' . $this->year);

        $filter = [
            'month' => $this->year . '-' . $this->month
        ];

        $dtr = DailyTimeRecord::getRecordByMonth($this->user_id, $filter);

        // Weekly data initialization
        $weeklyData = [];
        $totalUT = collect();
        $totalPPS = collect();
        $totalFL = collect();
        $totalSL = collect();
        $totalVL = collect();
        
        // Add rows and calculate weekly totals
        for ($i = 0; $i < count($dtr['dtr']); $i++) {
            $record = $dtr['dtr'][$i];
            $row = 12 + $i;
            $sheet->insertNewRowBefore($row);
            // Use Carbon to calculate total UT + Late for the day
            $totalPersonalPassSlip = $record['totalPersonalPassSlip'];
            $totalUTLate = $record['utAM'] + $record['utPM'] + $record['lateAM'] + $record['latePM'];
            $absent = 0;
            $absentWithUnderTime = round($totalUTLate + $record['absent'], 3);

            // Populate individual DTR data
            $sheet->setCellValue('A' . $row, $record['date']);
            $sheet->setCellValue('B' . $row, $record['day']);
            $sheet->setCellValue('C' . $row, $record['inAM']);
            $sheet->setCellValue('D' . $row, $record['outAM']);
            $sheet->setCellValue('E' . $row, $record['inPM']);
            $sheet->setCellValue('F' . $row, $record['outPM']);
            $sheet->setCellValue('G' . $row, $record['totalHours']);
            if($record['absent']){
                $absent = $record['absent'] ? $record['absent'] * 480 * 60 : 0;
                $sheet->setCellValue('G' . $row, gmdate("H:i:s", $record['totalHoursInSeconds'] + $absent));
            }
            if ($record['day'] !== 'Sat' && $record['day'] !== 'Sun'){
                $totalUT->push($absentWithUnderTime);
                $sheet->setCellValue('H' . $row,  $absentWithUnderTime);
            }
            if ($record['day'] !== 'Sat' && $record['day'] !== 'Sun') {
                $absent = $record['absent'] ? $record['absent'] * 480 : 0;
                $sheet->setCellValue('I' . $row, $record['totalMinutes'] + $absent);
                // $sheet->setCellValue('I' . $row, ($totalUTLate + $record['absent']) * 480);
            }
            $sheet->setCellValue('J' . $row, $record['remarks']);
            $sheet->setCellValue('K' . $row, $record['lateAM']);
            $sheet->setCellValue('L' . $row, $record['latePM']);
            $sheet->setCellValue('M' . $row, $record['utAM']);
            $sheet->setCellValue('N' . $row, $record['utPM']);
            $sheet->setCellValue('O' . $row, $record['totalPersonalPassSlip']);
            $sheet->setCellValue('P' . $row, $record['absent']);

            // Calculate weekly totals
            $week = Carbon::parse($this->month . '/' . $record['date'] . '/' . $this->year)->week; // Get week number


            if (!isset($weeklyData[$week])) {
                $weeklyData[$week] = [
                    'equivalentDays' => 0,
                    'equivalentMinutes' => 0,
                    'totalHours' => 0,
                    'totalUTLate' => 0,
                    'totalPPS' => 0,
                ];
            }

            

            $weeklyData[$week]['totalHours'] += $record['totalHoursInSeconds'];
            $weeklyData[$week]['equivalentDays'] += $absentWithUnderTime;
            $weeklyData[$week]['equivalentMinutes'] += $record['totalMinutes'] + $absent;
            $weeklyData[$week]['totalUTLate'] += $totalUTLate;
            $weeklyData[$week]['totalPPS'] += $totalPersonalPassSlip;


            $lastDay = Carbon::create($this->year, $this->month)->lastOfMonth();

            $equivalentDays = $weeklyData[$week]['equivalentMinutes'] < 0 ? round($weeklyData[$week]['equivalentMinutes'] / 480, 3) : 0;
            $equivalentMinutes = $weeklyData[$week]['equivalentMinutes'] < 0 ? $weeklyData[$week]['equivalentMinutes'] : 0;

            if (str_contains($record['day'], 'Sat') || $lastDay->day == $record['date'])  {
                $rowX = $row;
                
                if($lastDay->day == $record['date']){
                    $rowX = $row + 1;
                }

                $totalPersonalPassSlipMins = $weeklyData[$week]['totalPPS']/60;
                
                if($equivalentMinutes < 0 && $totalPersonalPassSlipMins > 0){
                    if(abs($equivalentMinutes) < $totalPersonalPassSlipMins){
                        $totalPPS->push($equivalentMinutes/480);
                    }else if(abs($equivalentMinutes) >= $totalPersonalPassSlipMins){
                        $totalPPS->push($totalPersonalPassSlipMins/480);
                        $totalUT->push(abs($equivalentMinutes) - $totalPersonalPassSlipMins / 480);
                    }
                }

                $totalUT->push(abs($equivalentDays));
                $sheet->setCellValue('H' . $rowX, $equivalentDays < 0 ? abs($equivalentDays) : '');
                $sheet->setCellValue('I' . $rowX, $equivalentMinutes >= 0 ? '' : $equivalentMinutes);


            }

            // add into REG_FL
            switch ($record['remarks']){
                case 'REG_FL':
                    $totalFL->push(1);
                    break;
                case 'REG_SL':
                    $totalSL->push(1);
                    break;
                case 'REG_VL':
                    $totalVL->push(1);
                default:
                    break;
                }
            
        }

        $sheet->setCellValue('F' . 21 + count($dtr['dtr']), round($totalUT->sum() - abs($totalPPS->sum()), 3));
        $sheet->setCellValue('F' . 24 + count($dtr['dtr']), $totalFL->sum());
        $sheet->setCellValue('F' . 25 + count($dtr['dtr']), round(abs($totalPPS->sum()), 3));
    }
}


}
