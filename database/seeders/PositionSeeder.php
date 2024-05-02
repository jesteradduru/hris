<?php
use App\Models\PlantillaPosition;

    $positions = [
        [
            "place_of_assignment" => "NEDA Region 2",
            "plantilla_item_no" => "QWETY123",
            "position" => "Economic Development Specialist I",
            "salary_grade" => "12",
            "monthly_salary" => "3210",
            "eligibility" => "Civil Service Eligibility or equivalent",
            "education" => "Bachelor of Science in Economics",
            "competency" => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Error excepturi eum laudantium.",
            'division_id' => 3,
            
        ],
        [
            "place_of_assignment" => "NEDA Region 2",
            "plantilla_item_no" => "1234124",
            "position" => "Senior Economic Development Specialist",
            "salary_grade" => "18",
            "monthly_salary" => "50000",
            "eligibility" => "Civil Service Eligibility or equivalent",
            "education" => "Bachelor of Science in Economics",
            "competency" => "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Error excepturi eum laudantium.",
            'division_id' => 4,
            
        ],
    ];

    foreach($positions as $position){
        PlantillaPosition::create($position);
    }
?>