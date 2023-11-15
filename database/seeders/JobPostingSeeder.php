<?php

use App\Models\JobPosting;
use Illuminate\Support\Facades\Config;

if(Config::get('app.debug')){
    $jobPosting1 = JobPosting::create([
        "plantilla_id" => 2,
        "posting_date" => now(),
        "closing_date" => now(),
        "by_user_id" => 1,
        'documents' => fake()->sentence()
    ]);

    $jobPosting2 = JobPosting::create([
        "plantilla_id" => 1,
        "posting_date" => now(),
        "closing_date" => now(),
        "by_user_id" => 1,
        'documents' => fake()->sentence()
    ]);

    $jobPosting2->results()->create([
        'phase' => 'INITIAL_SCREENING'
    ]);
    $jobPosting1->results()->create([
        'phase' => 'INITIAL_SCREENING'
    ]);
}

?>

