<?php

namespace App\Exports;

use App\Models\JobApplicationResults;
use App\Models\JobPosting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;

class SPBFormB22 implements 
FromCollection, 
ShouldAutoSize, 
WithMapping, 
// WithHeadings, 
WithStyles, 
// WithColumnWidths, 
WithDefaultStyles, 
WithCustomStartCell,
// WithDrawings,
WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private $job_posting = null, $position, $exam_date;

    protected $index = 0;


    public function __construct($job_posting_id = null)
    {
        if($job_posting_id){
            $job_posting = JobPosting::find($job_posting_id);
            $job_vacancy_status = $job_posting->results()->orderBy('created_at', 'DESC')->first();
            $this->position = $job_posting->plantilla->position;
            $this->job_posting = $job_vacancy_status->load(['job_posting', 'result' => [
                    'application' => [
                        'user'
                    ]
                ]]);
                    
        }

    }

    public function collection() {

            $applicants = collect();

            foreach($this->job_posting->result as $item) {

                // dd(self::compute_training($item));
                $applicants->push(self::compute_training($item));
               
            }
            
            return $applicants->sortByDesc('score')->values();;
    }

    public static function compute_training($currentResult){
        $application = $currentResult->application;
        $computable = $application->included;
        $plantilla = $application->job_posting->plantilla;
        $training = 0;

        $included_trainings = $computable->filter(function ($value, int $key) {
            return $value->computable_type == 'App\Models\LearningAndDevelopment';
        });

        $trainings = $included_trainings->map(function ($value, int $key) {
            return $value->computable;
        });
        
        $no_of_hours1 = $trainings->sum('number_of_hours');
        $no_of_hours = $trainings->sum('number_of_hours');
        
        if($plantilla->training){ // if training is required
            if($plantilla->training <= $no_of_hours){
                $training = 50;
                $no_of_hours = $no_of_hours - $plantilla->training;
            }
        }
        

        while($no_of_hours >= 12 && $training < 100) {
            if($no_of_hours >= 12){
                $training += 1;
            }
            $no_of_hours -= 12;
        }
    

        return [
            'user' => $application->user->name,
            'hours' => $no_of_hours1,
            'equivalent' => $training,
            'score' => $training * .1
        ];
    }

    public function map($applicant) : array {
        // dd($applicant);
        $array = [
            Str::upper($applicant["user"]),
            Str::upper($applicant["hours"]),
            Str::upper($applicant["equivalent"]),
            Str::upper($applicant["score"]),
            ++$this->index,
        ];
        
        return $array;
    }

    
    public function styles(Worksheet $sheet)
    {

        // HEADERS
        $sheet->mergeCells('A2:' . $sheet->getHighestColumn() . '2');
        $sheet->mergeCells('A3:' . $sheet->getHighestColumn() . '3');
        $sheet->mergeCells('A4:' . $sheet->getHighestColumn() . '4');

        $sheet->setCellValue('A2', 'NATIONAL ECONOMIC DEVELOPMENT AUTHORITY REGION 2');
        $sheet->setCellValue('A3',  $this->position);
        $sheet->setCellValue('A4',  'SPB FORM B-2.2 TRAINING SCORE SHEET');

        $sheet->getStyle('A1:'.$sheet->getHighestColumn() . '5')->applyFromArray([
            'font' => [
                'bold' => true
            ],
            'alignment' => [
                'horizontal' =>  \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' =>  \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ]);

        $sheet->getRowDimension(6)->setRowHeight(40);

        // PREPARE COLUMN HEADERS
        $sheet->setCellValue('A6', 'CANDIDATES');
        $sheet->setCellValue('B6', 'TOTAL NO. OF HOURS');
        $sheet->setCellValue('C6', 'EQUIVALENT SCORE');
        $sheet->setCellValue('D6', 'RELEVANT TRAININGS (10%)');
        $sheet->setCellValue('E6', 'RANK');


        $sheet->getStyle('A6:E'. $sheet->getHighestColumn() . $sheet->getHighestRow())->getAlignment()->setWrapText(true);


        $sheet->getStyle("A6:". "E" . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '808080']
                ],
            ],
            'alignment' => [
                'horizontal' =>  \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' =>  \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ]);

        $sheet->getStyle("A6:". "E6")
        ->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'argb' => 'ffffffff'
                ]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => [
                    'argb' => 'ff3b71ca'
                ]
            ],
            'border',
        ]);

        
    }

    public function defaultStyles(Style $defaultStyle)
    {
        return [
            'alignment' => [
                'horizontal' =>  \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' =>  \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ];
    }

    public function startCell(): string
    {
        return 'A7';
    }

    public function title() : string {
        return 'SPB FORM B-2.2';
    }

}
