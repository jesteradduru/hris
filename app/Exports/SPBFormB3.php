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

class SPBFormB3 implements 
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

                // dd(self::compute_experience($item));
                $applicants->push(self::compute_experience($item));
               
            }
            
            return $applicants->sortByDesc('score')->values();;
    }

    public static function compute_experience($currentResult){
        $application = $currentResult->application;
        $computable = $application->included;
        $posting = $application->job_posting;
        $plantilla = $posting->plantilla;
        $work_points = 0;
        $total_year_excess_count = 0;

        $included_work = $computable->filter(function ($value, int $key) {
            return $value->computable_type == 'App\Models\WorkExperience';
        });

        $works = $included_work->map(function ($value, int $key) {
            return $value->computable;
        });

       

        $total_years = 0;

        foreach($works as $work){
            $years = 0;

            if($work->to_present){
                $years = self::calculateTotalYears($work->inclusive_date_from, $posting->closing_date);
            }else{
                $years = self::calculateTotalYears($work->inclusive_date_from, $work->inclusive_date_to);
            }

            $total_years += $years;
        }

        
        
        if($plantilla->work_experience) { // if work experience is required
            if($total_years >= $plantilla->work_experience){
                $work_points = 50;
                $total_year_excess_count = $total_years - $plantilla->work_experience;
            }
        }

        $excess_points = $total_year_excess_count *  3.5;

        if($excess_points >= 35){
            $excess_points = 35;
        }

        return [
            'user' => $application->user->name,
            'equivalent'=> $work_points + $excess_points,
            'years' => $total_years,
            'psb' => $application->psb_points->experience,
            'score' =>  round(($work_points + $excess_points + $application->psb_points->experience) * .25, 2)
        ];
    }

    private static function calculateTotalYears($startDate, $endDate)
    {
        // Parse the input dates using Carbon
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Calculate the difference in years and months
        $diffInDays = $start->diffInDays($end);

        // Convert the difference to decimal years
        $totalYears = $diffInDays / 365.25;

        return round($totalYears, 2);
    }

    public function map($applicant) : array {
        // dd($applicant);
        $array = [
            Str::upper($applicant["user"]),
            Str::upper($applicant["years"]),
            Str::upper($applicant["equivalent"]),
            Str::upper($applicant["psb"]),
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
        $sheet->setCellValue('A4',  'SPB FORM B-3 EXPERIENCE SCORE SHEET');

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
        $sheet->setCellValue('B6', "TOTAL NO. OF YEARS\n(RELEVANT EXPERIENCE)");
        $sheet->setCellValue('C6', "EQUIVALENT SCORE\n(85)");
        $sheet->setCellValue('D6', "HRMPSB VALIDATION\nRating(15)");
        $sheet->setCellValue('E6', "RELEVANT EXPERIENCE\n(25%)");
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
        return 'SPB FORM B-3';
    }

}
