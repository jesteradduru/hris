<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Eligibility;
use App\Models\PlantillaPosition;
use Illuminate\Http\Request;

class PlantillaPositionController extends Controller
{
    public function index() {
        return inertia('Admin/Recruitment/PlantillaPositions/Index');
    }

    public function create() {
        return inertia('Admin/Recruitment/PlantillaPositions/Create', [
            'eligibilities' => Eligibility::all(),
            'divisions' => Division::all()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'item' => 'required|string',
            'division_id' => 'required|integer',
        ]);
    }

    public function edit() {
        return inertia('Admin/Recruitment/PlantillaPositions/Show');
    }
}
