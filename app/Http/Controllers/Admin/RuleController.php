<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function create() {
        return inertia('Admin/Recruitment/PlantillaPositions/Rule/Create');
    }
}
