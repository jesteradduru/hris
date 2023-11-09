<?php
use App\Models\PlantillaPosition;

    $positions = [
        [
            'Senior Economic Development Specialist',
            'ODGB-SREDS-173-1998',
            '5'
        ],
        [
            'Economic Development Specialist I',
            'ODGB-EDS1-27-2018',
            '3'
        ],
        [
            'Economic Development Specialist II',
            'ODGB-EDS2-5-1998',
            '4'
        ],
    ];

    foreach($positions as $position){
        PlantillaPosition::create([
            'title' => $position[0],
            'item' => $position[1],
            'division_id' => $position[2]
        ]);
    }
?>