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

class SPBFormB21 implements 
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

                $applicants->push(self::compute_education($item));
               
            }
            
           

            return $applicants->sortByDesc('education')->values();;
    }

    public static function compute_education($currentResult){
        $user = $currentResult->user;
        $doctorate = $user->college_graduate_studies()->where('level', 'DOCTORATE')->whereRaw('year_graduated IS NOT NULL')->get();
        $earned_doctoral = $user->college_graduate_studies()->where('level', 'DOCTORATE')->whereRaw('year_graduated IS NULL')->get();
        $masteral = $user->college_graduate_studies()->where('level', 'MASTERAL')->whereRaw('year_graduated IS NOT NULL')->get();
        $earned_masteral = $user->college_graduate_studies()->where('level', 'MASTERAL')->whereRaw('year_graduated IS NULL')->get();
        $diploma = $user->college_graduate_studies()->where('level', 'DIPLOMA')->whereRaw('year_graduated IS NOT NULL')->get();
        $bachelor = $user->college_graduate_studies()->where('level', 'BACHELOR')->whereRaw('year_graduated IS NOT NULL')->get();
        $two_year = $user->college_graduate_studies()->where('level', 'TWO_YEAR')->whereRaw('year_graduated IS NOT NULL')->get();
        $education = 0;
        $courses = "";


        
        
        


        if(count($two_year) == 1){
            $courses .= self::join_educ($two_year);
            $education = 70;
        }

        if(count($bachelor) == 1){
            $courses .= self::join_educ($bachelor);
            $education = 80;
        }else if(count($bachelor) > 1){
            $courses .= self::join_educ($bachelor);
            $education = 81.5;
        }

        if(count($earned_masteral) > 0){
            $courses .= self::join_educ($earned_masteral);
            foreach($earned_masteral as $earned){
                if($earned->highest_lvl_units_earned >= 18){
                    $education = 82.5;
                }
            }
        }
        
        if(count($diploma) == 1){
            $courses .= self::join_educ($diploma);
            $education = 83.5;
        }

        if(count($masteral) == 1 || count($diploma) >= 2){
            $courses .= self::join_educ($masteral);
            $courses .= self::join_educ($diploma);
            $education = 85;
        }

        if(count($masteral) >= 2){
            $courses .= self::join_educ($masteral);
            $education = 90;
        }

        if(count($earned_doctoral) > 0){
            $courses .= self::join_educ($earned_doctoral);
            foreach($earned_doctoral as $earned){
                if($earned->highest_lvl_units_earned >= 18){
                    $education = 92.5;
                }
            }
        }

        if(count($doctorate) == 1){
            $courses .= self::join_educ($doctorate);
            $education = 95;
        }

        if(count($doctorate) >= 2){
            $courses .= self::join_educ($doctorate);
            $education = 100;
        }


        return [
            'user' => $user->name,
            'courses' => $courses,
            'equivalent'=> $education,
            'education' => $education * .1
        ];
    }

    public static function join_educ($educs) {

        $courses = "";

        foreach($educs as $educ){
            $units = $educ->highest_lvl_units_earned !== null ? "-{$educ->highest_lvl_units_earned} units" : "";
            $courses .= "\n{$educ->basic_ed_degree_course}-{$educ->name_of_school}{$units}";
        }
        
        return $courses;
    }

    public function map($applicant) : array {
        // dd($applicant);
        $array = [
            Str::upper($applicant["user"]),
            Str::upper($applicant["courses"]),
            Str::upper($applicant["equivalent"]),
            Str::upper($applicant["education"]),
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
        $sheet->setCellValue('A4',  'SPB FORM B-2.1 EDUCATION SCORE SHEET');

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
        $sheet->setCellValue('B6', 'EDUCATIONAL ATTAINMENT/S');
        $sheet->setCellValue('C6', 'EQUIVALENT SCORE');
        $sheet->setCellValue('D6', 'EDUCATION (10%)');
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
        return 'SPB FORM B-2.1';
    }

}
