<?php

namespace App\Exports;

use App\Models\JobPosting;
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

class SPBFormA2 implements 
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
            $this->job_posting = $job_vacancy_status->load(['result' => [
                    'application' => [
                        'scores',
                        'user'
                    ]
                ]]);
                    
        }

    }

    public function collection() {

            $applicants = collect();


            foreach($this->job_posting->result as $item) {
                $applicant = [
                    'name' => $item->application->user->name,
                    ...$item->application->scores->toArray()
                ];

                $applicants->push($applicant);
            }

            // dd($applicants);

            return $applicants->sortByDesc('total');
    }

    public function map($applicant) : array {
        $array = [
            Str::upper($applicant['name']),
            Str::upper($applicant['performance']),
            Str::upper($applicant['performance_rank']),
            Str::upper($applicant['education']),
            Str::upper($applicant['education_rank']),
            Str::upper($applicant['experience']),
            Str::upper($applicant['experience_rank']),
            Str::upper($applicant['personality']),
            Str::upper($applicant['personality_rank']),
            Str::upper($applicant['potential']),
            Str::upper($applicant['potential_rank']),
            Str::upper($applicant['total']),
            Str::upper($applicant['total_rank'])
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
        $sheet->setCellValue('A4',  'SPB FORM A-2 SUMMARY SCORE SHEET');

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
        $sheet->mergeCells('A6:A7');
        $sheet->mergeCells('B6:C6');
        $sheet->mergeCells('D6:E6');
        $sheet->mergeCells('F6:G6');
        $sheet->mergeCells('H6:I6');
        $sheet->mergeCells('J6:K6');
        $sheet->mergeCells('L6:M6');

        $sheet->setCellValue('A6', 'CANDIDATES');
        $sheet->setCellValue('B6', 'PERFORMANCE');
        $sheet->setCellValue('D6', 'EDUCATION & TRAINING');
        $sheet->setCellValue('F6', 'EXPERIENCE');
        $sheet->setCellValue('H6', 'PERSONALITY TRAIT & ATTRIBUTES');
        $sheet->setCellValue('J6', 'POTENTIAL');
        $sheet->setCellValue('L6', 'TOTAL');


        $sheet->setCellValue('B7', '%SCORE (25%)');
        $sheet->setCellValue('D7', '%SCORE (20%)');
        $sheet->setCellValue('F7', '%SCORE (25%)');
        $sheet->setCellValue('H7', '%SCORE (15%)');
        $sheet->setCellValue('J7', '%SCORE (15%)');
        $sheet->setCellValue('L7', 'TOTAL (100%)');

        $sheet->setCellValue('C7', 'RANK');
        $sheet->setCellValue('E7', 'RANK');
        $sheet->setCellValue('G7', 'RANK');
        $sheet->setCellValue('I7', 'RANK');
        $sheet->setCellValue('K7', 'RANK');
        $sheet->setCellValue('M7', 'RANK');


        $sheet->getStyle('A6:F'. $sheet->getHighestColumn() . $sheet->getHighestRow())->getAlignment()->setWrapText(true);


        $sheet->getStyle("A6:". "M" . $sheet->getHighestRow())->applyFromArray([
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

        $sheet->getStyle("A6:". "M7")
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
        return 'A8';
    }

    public function title() : string {
        return 'SPB FORM A-2';
    }

}
