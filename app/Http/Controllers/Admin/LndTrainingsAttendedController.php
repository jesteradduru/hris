<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningAndDevelopment;
use App\Models\LndForm;
use App\Models\LndTrainingsAttended;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LndTrainingsAttendedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        $lndForm = LndForm::find($request->lnd_form);

        $filters = $request->only(['from', 'to']);

        return inertia('Admin/L&D/CompetencyGap/TrainingsAttended/Create', [
            'report_id' => $request->report_id,
            'lnd_form' => $lndForm->load(['lnd_training']),
            'trainings' => LearningAndDevelopment::filter($filters)
            ->where('user_id', $request->user_id)
            ->whereDoesntHave('lnd_training', fn (Builder $query)
                => $query->where('lnd_form_id', $request->lnd_form)
            )
            ->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        LndTrainingsAttended::create([
            'lnd_form_id' => $request->lnd_form_id,
            'training_id' => $request->training_id
        ]);

        return back()->with('success', 'Training Added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy(LndTrainingsAttended $competency_training)
    {
        $competency_training->delete();

        return back()->with('success', 'Removed Successfully.');
    }
}
