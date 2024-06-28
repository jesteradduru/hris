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

class SPBFormB11 implements 
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

                $user = $item->application->user;
               

                if($user->hasRole('employee')){//employee
                    $posting_date = Carbon::parse($this->job_posting->job_posting->posting_date);
                    $latestSpms = null;

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
                        'first' => count($latestSpms) >= 1 ? $latestSpms[0]->rating : null,
                        'second' => count($latestSpms) === 2 ? $latestSpms[1]->rating : null,
                        'equivalent' => $performance_rating
                    ];

                    // dd($applicant);
    
                    $applicants->push($applicant);

                }//employee

                else if($item->application->pes_rating()->exists()){ // if outsider
                    $applicant = null;
                    $pesRatingOutsider = $item->application->pes_rating;
        
                    if(($pesRatingOutsider->first_rating && $pesRatingOutsider->second_rating)){
                        $performance_rating = ((($pesRatingOutsider->first_rating + $pesRatingOutsider->second_rating) / 2) / 5) * 70;
                        $applicant = [
                            'name' => $user->name,
                            'first' => $pesRatingOutsider->first_rating,
                            'second' =>  $pesRatingOutsider->second_rating,
                            'equivalent' => $performance_rating
                        ];
                    }else if($pesRatingOutsider->first_rating){
                        $performance_rating = ($pesRatingOutsider->first_rating / 5) * 70;
                        $applicant = [
                            'name' => $user->name,
                            'first' => $pesRatingOutsider->first_rating,
                            'equivalent' => $performance_rating
                        ];
                    }else if($pesRatingOutsider->second_rating){
                        $performance_rating = ($pesRatingOutsider->second_rating / 5) * 70;
                        $applicant = [
                            'name' => $user->name,
                            'second' =>  $pesRatingOutsider->second_rating,
                            'equivalent' => $performance_rating
                        ];
                    }

                    if($applicant){
                        $applicants->push($applicant);
                    }
                }//outsider
               
            }
            
            
            // dd($applicants);


            return $applicants->sortByDesc('equivalent');
    }

    public function map($applicant) : array {
        $array = [
            Str::upper($applicant['name']),
            Str::upper($applicant['first']),
            Str::upper($applicant['second']),
            Str::upper($applicant['equivalent']),
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
        $sheet->setCellValue('A4',  'SPB FORM B-1.1 INDIVIDUAL PES RATING');

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
        $sheet->setCellValue('B6', '1ST');
        $sheet->setCellValue('C6', '2ND');
        $sheet->setCellValue('D6', 'EQUIVALENT RATING (70)');
        $sheet->setCellValue('E6', 'RANK');


        $sheet->getStyle('A6:F'. $sheet->getHighestColumn() . $sheet->getHighestRow())->getAlignment()->setWrapText(true);


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
        return 'SPB FORM B-1.1';
    }

}
