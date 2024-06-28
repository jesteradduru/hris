<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class JobApplicationResultExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    private $job_posting_id;

    public function __construct($job_posting_id = null)
    {
        $this->job_posting_id = $job_posting_id;

    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new SPBFormA2($this->job_posting_id);
        $sheets[] = new SPBFormB11($this->job_posting_id);
        $sheets[] = new SPBFormB12($this->job_posting_id);
        $sheets[] = new SPBFormB13b($this->job_posting_id);
        $sheets[] = new SPBFormB21($this->job_posting_id);
        $sheets[] = new SPBFormB22($this->job_posting_id);
        $sheets[] = new SPBFormB3($this->job_posting_id);

        return $sheets;
    }
}
