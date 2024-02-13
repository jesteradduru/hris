<?php

namespace App\Exports;

use App\Models\JobApplicationResults;
use App\Models\JobPosting;
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

class ShortlistedApplicants implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithStyles, WithColumnWidths, WithDefaultStyles, WithCustomStartCell, WithDrawings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private $job_posting = null, $position;

    protected $index = 0;


    public function __construct($job_posting_id = null)
    {
        if($job_posting_id){
            $job_posting = JobPosting::find($job_posting_id);
            $this->job_posting = $job_posting->id;
            $this->position = $job_posting->plantilla->position;
        }

    }

    public function collection() {
        if($this->job_posting){
            // dd(JobApplicationResults::with('user')->get());
            $job_results = JobApplicationResults::where('job_posting_id', $this->job_posting)->where('phase', 'SHORTLISTING')->with(
                [
                    'result' => [
                        'user' => ['personal_information', 'page_four_questions']
                    ]
                ]
            )->first();

            $applicants = collect();

            foreach($job_results->result as $item) {
                if($item->result === 'SHORTLISTED'){
                    $applicants->push($item->user);
                }
            }

            // dd($applicants);
            return $applicants;
        }else{

            $job_posting_result = JobApplicationResults::where('phase', 'SHORTLISTING')->with(
                [
                    'result' => [
                        'user' => ['personal_information', 'page_four_questions']
                    ],
                    'job_posting' => [ 'plantilla']
                ]
            )->get();

            // dd($job_posting_result);

            $applicants = collect();
            $applicants_array = array();
            
            foreach($job_posting_result as $result){
                foreach($result->result as $application_result){
                    if($application_result->result === 'SHORTLISTED'){
                        $applicant = null;
                        $applicant = $application_result->user;
                        $applicant = $application_result->user;
                        $applicant->position_applied = $result->job_posting->plantilla->position;
                        array_push($applicants_array, clone $applicant);
                    }
                }
            }

            foreach($applicants_array as $applicant){
                $applicants->push($applicant);
            }


            // dd($applicants);

            return $applicants;
        }
    }

    public function map($applicant) : array {
        $array = [
            ++$this->index,
            Str::upper($applicant->personal_information->surname),
            Str::upper($applicant->personal_information->first_name),
            Str::upper($applicant->personal_information->middle_name),
            Str::upper($applicant->personal_information->name_extension),
            Str::upper($applicant->personal_information->address),
            Str::upper($applicant->personal_information->mobile_number),
            $applicant->personal_information->email_address,
            Str::upper($applicant->personal_information->religion),
            Str::upper($applicant->personal_information->ethnicity),
            $applicant->page_four_questions && $applicant->page_four_questions->fourty_b ? 'PWD ID: ' . $applicant->page_four_questions->fourty_b_if_yes : 'NO',
        ];


        if(!$this->job_posting){
            array_splice($array, 1, 0, $applicant->position_applied);
        }


        return $array;
    }

    public function headings(): array
    {
        $array = [
            'NO.',
            'LAST NAME',
            'FIRST NAME',
            'MIDDLE NAME',
            'EXTENSION NAME',
            'ADDRESS',
            'CONTACT',
            'EMAIL ADDRESS',
            'RELIGION',
            'ETHNICITY',
            'PWD',
        ];
        
        if(!$this->job_posting){
            array_splice($array, 1, 0, 'APPLIED POSITION');
        }

        return  $array;


    }
    
    public function styles(Worksheet $sheet)
    {

        $sheet->mergeCells('A2:' . $sheet->getHighestColumn() . '2');
        $sheet->mergeCells('A3:' . $sheet->getHighestColumn() . '3');
        $sheet->mergeCells('A4:' . $sheet->getHighestColumn() . '4');

        $sheet->setCellValue('A2', 'NATIONAL ECONOMIC DEVELOPMENT AUTHORITY REGION 2');

        if($this->job_posting){
            $sheet->setCellValue('A3', $this->position);
            $sheet->getStyle('F6:F'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
        }else{
            $sheet->setCellValue('A3', 'All Vacant Positions');
            $sheet->getStyle('G6:G'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
        }

        $sheet->setCellValue('A4', 'List of Shortlisted Applicants');

        $sheet->getStyle('A1:'.$sheet->getHighestColumn() . '5')->applyFromArray([
            'font' => [
                'bold' => true
            ]
            ]);

        $sheet->getRowDimension(6)->setRowHeight(40);

        $sheet->getStyle("A6:". $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '808080']
                ],
            ],
            'alignment' => [
                'horizontal' =>  \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ]);

        $sheet->getStyle("A6:". $sheet->getHighestColumn() ."6")
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

    public function columnWidths(): array
    {
        if(!$this->job_posting){
            return [
                'G' => 40
            ];
        }

        return [
            'F' => 40
        ];
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
        return 'A6';
    }


    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setOffsetX(80);
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/image/neda-logo.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('E2');

        return $drawing;
    }
}
