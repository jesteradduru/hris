<?php

namespace App\Exports;

use App\Models\JobPosting;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;

class SPBFormB13b implements 
FromCollection, 
ShouldAutoSize, 
WithMapping, 
// WithHeadings, 
WithStyles, 
WithColumnWidths, 
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
            $PEER = 0;
            $personality_rating = 0;

            $PSBPOINTS = $item->application->psb_points;
            // dd($PSBPOINTS);
           

            if($user->hasRole('employee')){//employee
                $applicant = null;
                $posting_date = Carbon::parse($this->job_posting->job_posting->posting_date);
                $latestSpms = null;

                if($PSBPOINTS){
                    $PVEI = $PSBPOINTS->org_competency + $PSBPOINTS->leadership_competency + $PSBPOINTS->technical_competency;
                    $PVEI_PERCENT = $PVEI * .8;
                    $PEER = $PSBPOINTS->personality_peer;
                    $personality_rating = ($PVEI_PERCENT + $PEER) * .15;
                }

                $applicant = [
                    'name' => $user->name,
                    'org_competency' => $PSBPOINTS->org_competency,
                    'leadership_competency' => $PSBPOINTS->leadership_competency,
                    'technical_competency' => $PSBPOINTS->technical_competency,
                    'pvei' => $PVEI,
                    'pvei_percent' => $PVEI_PERCENT,
                    'peer' => $PEER,
                    'personality' => $personality_rating,
                ];

                // dd($applicant);

            }//employee

            else{ // if outsider

                if($PSBPOINTS){
                    $PVEI = $PSBPOINTS->org_competency + $PSBPOINTS->leadership_competency + $PSBPOINTS->technical_competency;
                    $PVEI_PERCENT = $PVEI * 1;
                    $personality_rating = ($PVEI_PERCENT) * .15;
                }

                $applicant = [
                    'name' => $user->name,
                    'org_competency' => $PSBPOINTS->org_competency,
                    'leadership_competency' => $PSBPOINTS->leadership_competency,
                    'technical_competency' => $PSBPOINTS->technical_competency,
                    'pvei' => $PVEI,
                    'pvei_percent' => $PVEI_PERCENT,
                    'peer' => $PEER,
                    'personality' => $personality_rating,
                ];
               
            }//outsider

            if($applicant){
                
                // dd($applicant);
                $applicants->push($applicant);
                
            }
           
        }
        
        
       
        // dd($applicants);


        return  $applicants->sortByDesc('personality');
    }



    public function map($applicant) : array {
        $array = [
            Str::upper($applicant['name']),
            Str::upper($applicant['org_competency']),
            Str::upper($applicant['leadership_competency']),
            Str::upper($applicant['technical_competency']),
            Str::upper($applicant['pvei']),
            Str::upper($applicant['pvei_percent']),
            Str::upper($applicant['peer']),
            Str::upper($applicant['personality']),
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
        $sheet->setCellValue('A4',  'SPB FORM B-1.3b PVE INTERVIEW SCORE SHEET');

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
        $sheet->setCellValue('B6', 'A. ORGANIZATIONAL');
        $sheet->setCellValue('C6', 'B. LEADERSHIP & MANAGERIAL');
        $sheet->setCellValue('D6', 'C. TECHNICAL/FUNCTIONAL');
        $sheet->setCellValue('E6', 'PVEI');
        $sheet->setCellValue('F6', 'PVEI (80-INSIDER, 100-OUTSIDER)');
        $sheet->setCellValue('G6', 'PEER REVIEW (20)');
        $sheet->setCellValue('H6', 'PERSONALITY TRAITS & ATTRIBUTES (15)');
        $sheet->setCellValue('I6', 'RANK');


        $sheet->getStyle('A6:I'. $sheet->getHighestColumn() . $sheet->getHighestRow())->getAlignment()->setWrapText(true);


        $sheet->getStyle("A6:". "I" . $sheet->getHighestRow())->applyFromArray([
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

        $sheet->getStyle("A6:". "I6")
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

    public function columnWidths(): array
    {
        return [
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'F' => 15,
            'H' => 15,
        ];
    }


    public function title() : string {
        return 'SPB FORM B-1.3b';
    }

}
