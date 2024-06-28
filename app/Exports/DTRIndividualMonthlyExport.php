<?php

namespace App\Exports;

use App\Models\DailyTimeRecord;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

    public function populateSheet($sheet){
        $user = User::where("dtr_user_id", $this->user_id)->first();
        if($user){

            $sheet->setCellValue('A4', $user->name);
            $sheet->setCellValue('D6', date('F', mktime(0, 0, 0, $this->month, 10)) . ' ' . $this->year);

            $filter = [
                'month' => $this->year . '-' . $this->month
            ];

            $dtr =    DailyTimeRecord::getRecordByMonth($this->user_id, $filter);
            
            // add rows
            for($i = 0; $i < count($dtr['dtr']) - 1; $i++){
                $row = 12+$i;
                $sheet->insertNewRowBefore(12 + $i);

                $sheet->setCellValue('A'. $row, $dtr['dtr'][$i]['date']);
                $sheet->setCellValue('B'. $row, $dtr['dtr'][$i]['day']);
                $sheet->setCellValue('C'. $row, $dtr['dtr'][$i]['inAM']);
                $sheet->setCellValue('D'. $row, $dtr['dtr'][$i]['outAM']);
                $sheet->setCellValue('E'. $row, $dtr['dtr'][$i]['inPM']);
                $sheet->setCellValue('F'. $row, $dtr['dtr'][$i]['outPM']);
                $sheet->setCellValue('G'. $row, $dtr['dtr'][$i]['totalHours']);
                $sheet->setCellValue('I'. $row, $dtr['dtr'][$i]['totalMinutes']);
                $sheet->setCellValue('J'. $row, $dtr['dtr'][$i]['remarks']);
            }

        }

        
    }

}
