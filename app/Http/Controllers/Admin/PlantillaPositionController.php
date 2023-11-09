<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlantillaPosition;
use Illuminate\Http\Request;

class PlantillaPositionController extends Controller
{
    public function index() {
        return inertia('Admin/Recruitment/PlantillaPositions/Index');
    }

    public function create() {
        return inertia('Admin/Recruitment/PlantillaPositions/Create');
    }

    public function edit() {
        return inertia('Admin/Recruitment/PlantillaPositions/Show');
    }
}
