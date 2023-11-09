<?php

use App\Models\Division;

    $divisions = [
        ['ORD', 'OFFICE OF THE REGIONAL DIRECTOR'],
        ['OARD', 'OFFICE OF THE ASSISTANT REGIONAL DIRECTOR'],
        ['PDIPBD', 'PROJECT DEVELOPMENT, INVESTMENT PROGRAMMING AND BUDGETING DIVISION'],
        ['DRD', 'DEVELOPMENT RESEARCH DIVISION'],
        ['FAD', 'FINANCE AND ADMINISTRATIVE DIVISION'],
        ['PMED', 'PROJECT MONITORING AND EVELUATION DIVISION'],
        ['PFPD', 'POLICY FORMULATION AND PLANNING DIVISION'],
    ];

    foreach($divisions as $division){
        Division::create([
            'abbreviation' => $division[0],
            'name' => $division[1]
        ]);
    }
?>