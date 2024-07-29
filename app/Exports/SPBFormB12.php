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
                $PEER = 0;
                $personality_rating = 0;

                $outstanding = self::outstanding_accoplishment($item);
                $PSBPOINTS = $item->application->psb_points;
                // dd($PSBPOINTS);
               

                if($user->hasRole('employee')){//employee
                    $applicant = null;
                    $posting_date = Carbon::parse($this->job_posting->job_posting->posting_date);
                    $latestSpms = null;

                    if($PSBPOINTS){
                        $PVEI = $PSBPOINTS->org_competency + $PSBPOINTS->leadership_competency + $PSBPOINTS->technical_competency;
                        $PVEI_PERCENT = $PVEI * .15;
                        // $PEER = $PSBPOINTS->personality_peer;
                        // $personality_rating = ($PVEI_PERCENT + $PEER) * .15;
                    }

                    if($posting_date->month <= 6){
                        $previousYear = $posting_date->year - 1;
                        $latestSpms = $user->spms()
                                         ->where('user_id', $user->id)
                                        ->where('year', $previousYear)
                                        ->where(function (Builder $query) {
                                            $query->where('semester', 'FIRST')
                                                ->orWhere('semester', 'SECOND');
                                        })->get();
                    }else if($posting_date->month > 6 && $posting_date->month <= 12){
                        $currentYear = $posting_date->year;
                        $latestSpms = $user->spms()
                                        ->where(function (Builder $query) use($currentYear, $user) {
                                            $query->where('semester', 'FIRST')
                                                    ->where('user_id', $user->id)
                                                    ->where('year', $currentYear);
                                        })
                                        ->orWhere(function (Builder $query) use($currentYear, $user)  {
                                            $query->where('year', $currentYear - 1)
                                                 ->where('user_id', $user->id)
                                                ->where('semester', 'SECOND');
                                        })->get();
                    }

                    // dd($latestSpms->toArray());
                    if($latestSpms){
                        $performance_rating = $latestSpms->avg('rating') / 5 * 70;
                    }

                    $applicant = [
                        'name' => $user->name,
                        'spms' => $performance_rating,
                        'pvei' => $PVEI_PERCENT,
                    ];

                    // dd($applicant);

                }//employee

                else{ // if outsider
                    $applicant = null;

                    if(($item->application->pes_rating()->exists())){
                        $pesRatingOutsider = $item->application->pes_rating;
    
                        if($PSBPOINTS){
                            $PVEI = $PSBPOINTS->org_competency + $PSBPOINTS->leadership_competency + $PSBPOINTS->technical_competency;
                            $PVEI_PERCENT = $PVEI * .15;
                            // $personality_rating = ($PVEI_PERCENT) * .15;
                        }
            
                        if(($pesRatingOutsider->first_rating && $pesRatingOutsider->second_rating)){
                            $performance_rating = ((($pesRatingOutsider->first_rating + $pesRatingOutsider->second_rating) / 2) / 5) * 70;
                            $applicant = [
                                'name' => $user->name,
                                'spms' => $performance_rating,
                                'pvei' => $PVEI_PERCENT,
                            ];
                        }else if($pesRatingOutsider->first_rating){
                            $performance_rating = ($pesRatingOutsider->first_rating / 5) * 70;
                            $applicant = [
                                'name' => $user->name,
                                'spms' => $performance_rating,
                                'pvei' => $PVEI_PERCENT,
                            ];
                        }else if($pesRatingOutsider->second_rating){
                            $performance_rating = ($pesRatingOutsider->second_rating / 5) * 70;
                            $applicant = [
                                'name' => $user->name,
                                'spms' => $performance_rating,
                                'pvei' => $PVEI_PERCENT,
                            ];
                        }
                    }else{
                        $performance_rating = 50;
                            $applicant = [
                                'name' => $user->name,
                                'spms' => $performance_rating,
                                'pvei' => $PVEI_PERCENT,
                            ];
                    }

                   
                }//outsider

                if($applicant){
                    
                    $applicant['outstanding'] = $outstanding;
                    $applicant['performance'] = round(($applicant['spms'] + $applicant['outstanding'] + $applicant['pvei'] ) * .25, 2);
                    // dd($applicant);
                    $applicants->push($applicant);
                    
                }
               
            }
            
            
            
            // dd($applicants);


            return $applicants->sortByDesc('performance');
    }


    private static function outstanding_accoplishment($currentResult) {
        $application = $currentResult->application;
        $computable = $application->included;
        $outstanding = 0;
        
        $non_acad_award = $computable->filter(function ($value, int $key) {
            return $value->computable_type == 'App\Models\NonAcademicDistinction';
        });

        $acad_award = $computable->filter(function ($value, int $key) {
            return $value->computable_type == 'App\Models\AcademicDistinction';
        });

        $non_acad_award_major_national = $non_acad_award->filter(function ($value, int $key) {
            $award = $value->computable;
            return $award->category == 'MAJOR_NATIONAL';
        });

        $non_acad_award_major_local = $non_acad_award->filter(function ($value, int $key) {
            $award = $value->computable;
            return $award->category == 'MAJOR_LOCAL';
        });

        $non_acad_award_minor = $non_acad_award->filter(function ($value, int $key) {
            $award = $value->computable;
            return $award->category == 'MINOR';
        });

        $non_acad_award_special = $non_acad_award->filter(function ($value, int $key) {
            $award = $value->computable;
            return $award->category == 'SPECIAL';
        });


        $acad_award_special = $acad_award->filter(function ($value, int $key) {
            $award = $value->computable;
            return $award->category == 'SPECIAL';
        });
        $acad_award_latin = $acad_award->filter(function ($value, int $key) {
            $award = $value->computable;
            return $award->category == 'LATIN';
        });

        // 1 major award national or 3 major local award
        if(count($non_acad_award_major_national) >= 1 || count($non_acad_award_major_local) == 3 ){
            $outstanding = 100;
         }

         // 2 major or 1 major + 2 or more minor
         if(count($non_acad_award_major_local) == 2 || (count($non_acad_award_major_local) == 1) && count($non_acad_award_minor) >= 2){
            $outstanding = $outstanding + 80;
         }

         if(count($non_acad_award_major_local) == 1){
            $outstanding = $outstanding + 60;
         }

        //  special awards more than 2
         if(count($non_acad_award_special) >= 2){
            $outstanding = $outstanding + 30;
         }

         // special awards only 1
         if(count($non_acad_award_special) == 1){
            $outstanding = $outstanding + 20;
         }

         // ACADEMIC AWARDS
         if(count($acad_award_latin) == 1){
            $outstanding = $outstanding + 20;
        }
         // ACADEMIC AWARDS
        if(count($acad_award_special) == 1){
            $outstanding = $outstanding + 10;
        }

        if($outstanding > 100){
            $outstanding = 100;
        }

        $outstanding = $outstanding * .15;

        return $outstanding;
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
