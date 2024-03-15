<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LndMonitoringReport;
use App\Models\LndTargettedStaff;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CompetencyGapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Admin/L&D/CompetencyGap/Index', [
            'reports' => LndMonitoringReport::with(['target_staff' => fn($query) => $query->withCount('target_staff_training')])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return inertia('Admin/L&D/CompetencyGap/Create', [
            'employees' => User::role('employee')->whereHas('lnd_form', function (Builder $query) {
                $query->where('type', 'COMPETENCY GAP ASSESSMENT');
            })->get()
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
                'user_id' => $employee['id'],
            ]);
        }

        sweetalert()->addSuccess('Report created!');

        return back();
        
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

        $users = User::role('employee');

        return inertia('Admin/L&D/CompetencyGap/Edit', [
                    'report' => $report,
                    'employees' => $users
                                    ->whereHas('lnd_form', function (Builder $query) {
                                        $query->where('type', 'COMPETENCY GAP ASSESSMENT');
                                    })
                                    ->with([
                                            'learning_and_development', 
                                            'lnd_form' => fn($query) => $query->with(['lnd_training'])
                                        ])->get()
                ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $competencyGap)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LndMonitoringReport $competencyGap)
    {
        
        $competencyGap->target_staff()->delete();
        $competencyGap->delete();
    }

    public function addPriority(Request $request){
        LndTargettedStaff::create([
            'report_id' => $request->report_id,
            'user_id' => $request->user_id
        ]);

        sweetalert()->addSuccess('Employee has been added to priority!');

        return back();
    }
    public function removePriority(LndTargettedStaff $targetStaff){
        $targetStaff->delete();

        sweetalert()->addSuccess('Employee has been removed to priority!');

        return back();
    }
}
