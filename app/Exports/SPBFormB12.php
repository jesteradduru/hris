<?php

namespace App\Exports;

use App\Models\JobPosting;
use App\Models\RewardAndRecognition;
use App\Models\SpmsForm;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;

class SPBFormB12 implements 
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
            $applicant = null;


            foreach($this->job_posting->result as $item) {

                $user = $item->application->user;
                $PVEI = 0;
                $PVEI_PERCENT = 0;

                $outstanding = RewardAndRecognition::outstanding_accoplishment($item->application->id);
                $PSBPOINTS = $item->application->psb_points;
                $performance_rating = SpmsForm::compute_performance($user->id,  $this->job_posting->job_posting_id, $item->application_id);


                if($PSBPOINTS){
                    $PVEI = $PSBPOINTS->org_competency + $PSBPOINTS->leadership_competency + $PSBPOINTS->technical_competency;
                    $PVEI_PERCENT = $PVEI * .15;
                }
               

                $applicant = [
                    'name' => $user->name,
                    'spms' => $performance_rating['equivalent'],
                    'outstanding' => $outstanding,
                    'pvei' => $PVEI_PERCENT,
                ];
                

                if($applicant){

                    $applicant['performance'] = round(($performance_rating['equivalent'] + $outstanding + $PVEI_PERCENT ) * .25, 2);
                    // dd($applicant);
                    $applicants->push($applicant);
                    
                }
               
            }

            return $applicants->sortByDesc('performance');
    }


    public function map($applicant) : array {
        $array = [
            Str::upper($applicant['name']),
            Str::upper($applicant['spms']),
            Str::upper($applicant['outstanding']),
            Str::upper($applicant['pvei']),
            Str::upper($applicant['performance']),
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
        $sheet->setCellValue('A4',  'SPB FORM B-1.2 PERFORMANCE SUMMARY SCORE SHEET');

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
        $sheet->setCellValue('B6', 'SPMS RATING (70)');
        $sheet->setCellValue('C6', 'OUTSTANDING ACCOMPLISHMENT (15)');
        $sheet->setCellValue('D6', 'PVEI (15)');
        $sheet->setCellValue('E6', 'PERFORMANCE (25)');
        $sheet->setCellValue('F6', 'RANK');


        $sheet->getStyle('A6:F'. $sheet->getHighestColumn() . $sheet->getHighestRow())->getAlignment()->setWrapText(true);


        $sheet->getStyle("A6:". "F" . $sheet->getHighestRow())->applyFromArray([
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

        $sheet->getStyle("A6:". "F6")
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
        return 'SPB FORM B-1.2';
    }

}
