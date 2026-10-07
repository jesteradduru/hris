<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Models\JobApplication;

class AdminController extends Controller
{
    public function index(Request $request){
        $unfilledPositionsCount = \App\Models\PlantillaPosition::doesntHave('user')->count();
        $totalApplicationsCount = JobApplication::count();
        
        $unfilledPositions = \App\Models\PlantillaPosition::doesntHave('user')
            ->with(['job_posting' => function($q) {
                $q->notArchived()->withCount('job_application');
            }])
            ->get()
            ->map(function ($plantilla) {
                return [
                    'id' => $plantilla->id,
                    'position' => $plantilla->position,
                    'item_no' => $plantilla->plantilla_item_no,
                    'has_posting' => $plantilla->job_posting !== null,
                    'job_posting_id' => $plantilla->job_posting ? $plantilla->job_posting->id : null,
                    'applications_count' => $plantilla->job_posting ? $plantilla->job_posting->job_application_count : 0,
                    'status' => $plantilla->job_posting ? 'Recruiting' : 'Not Posted',
                ];
            });

        return inertia('Admin/Index', [
            'metrics' => [
                'unfilled_positions' => $unfilledPositionsCount,
                'total_applications' => $totalApplicationsCount,
                'recent_unfilled_positions' => $unfilledPositions->take(5)
            ]
        ]);
    }
}
