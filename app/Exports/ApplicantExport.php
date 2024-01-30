<?php

namespace App\Exports;

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

class ApplicantExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithStyles, WithColumnWidths, WithDefaultStyles, WithCustomStartCell, WithDrawings
{
    use Exportable;

    private $job_posting, $position;

    protected $index = 0;

    

    public function __construct(int $job_posting_id)
    {
        $job_posting = JobPosting::find($job_posting_id);

        $this->job_posting = $job_posting->id;
        $this->position = $job_posting->plantilla->position;
    }

    public function collection() {
        $job_posting = JobPosting::find($this->job_posting)->load(
            [
                'applicants' => ['personal_information']
            ]
        );
        // dd($job_posting->applicants);
        return $job_posting->applicants;
    }

    public function map($applicant) : array {
        return [
            ++$this->index,
            $applicant->personal_information->surname,
            $applicant->personal_information->first_name,
            $applicant->personal_information->middle_name,
            $applicant->personal_information->name_extension,
            $applicant->personal_information->address,
            $applicant->personal_information->mobile_number,
            $applicant->personal_information->email_address,
        ];
    }

    public function headings(): array
    {
        return [
            'NO.',
            'LAST NAME',
            'FIRST NAME',
            'MIDDLE NAME',
            'EXTENSION NAME',
            'ADDRESS',
            'CONTACT',
            'EMAIL ADDRESS',
        ];
    }
    
    public function styles(Worksheet $sheet)
    {

        $sheet->mergeCells('B2:' . $sheet->getHighestColumn() . '2');
        $sheet->mergeCells('B3:' . $sheet->getHighestColumn() . '3');
        $sheet->mergeCells('B4:' . $sheet->getHighestColumn() . '4');

        $sheet->setCellValue('B2', 'NATIONAL ECONOMIC DEVELOPMENT AUTHORITY REGION 2');
        $sheet->setCellValue('B3', $this->position);
        $sheet->setCellValue('B4', 'List of Applicants');

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
        $sheet->getStyle('F6:F'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
    }

    public function columnWidths(): array
    {
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
        $drawing->setOffsetX(10);
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/image/neda-logo.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('D2');

        return $drawing;
    }
}
