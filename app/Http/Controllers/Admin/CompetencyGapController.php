<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LndMonitoringReport;
use App\Models\LndTargettedStaff;
use App\Models\User;
use Illuminate\Http\Request;

class CompetencyGapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Admin/L&D/CompetencyGap/Index', [
            'reports' => LndMonitoringReport::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return inertia('Admin/L&D/CompetencyGap/Create', [
            'employees' => User::role('employee')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'year' => 'required|integer|max:2099|min:2000',
            'targettedEmployees' => 'required|array',
            'targettedEmployees.*.id' => 'required|integer',
            'targettedEmployees.*.name' => 'required|string',
        ]);

        $report = LndMonitoringReport::create([
            'year' => $validate['year']
        ]);

        foreach($validate['targettedEmployees'] as $employee){
            LndTargettedStaff::create([
                'report_id' => $report->id,
                'user_id' => $employee['id']
            ]);
        }

        return back()->with('success', 'Report Created');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(LndMonitoringReport $competencyGap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LndMonitoringReport $competencyGap)
    {
        $report = $competencyGap->load([
            'target_staff' => fn($query) => $query->with(
                    [
                        'user' => fn($query) => $query->with(
                            [
                                'learning_and_development', 
                                'lnd_form' => fn($query) => $query->with(['lnd_training'])->where('type', 'COMPETENCY GAP ASSESSMENT')->where('year', $competencyGap->year)
                            ]
                        )
                    ]
                )
        ]);

        return inertia('Admin/L&D/CompetencyGap/Edit', [
            'report' => $report,
            'employees' => User::role('employee')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
