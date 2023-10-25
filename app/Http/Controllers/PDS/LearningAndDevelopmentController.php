<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use App\Models\LearningAndDevelopment;
use Illuminate\Http\Request;

class LearningAndDevelopmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('Profile/PDS/LearningAndDevelopment/Index', [
            'learning_and_development' => $request->user()->learning_and_development()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Profile/PDS/LearningAndDevelopment/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title_of_learning' => 'string|nullable',
            'inclusive_date_from' => 'date|nullable',
            'inclusive_date_to' => 'date|nullable',
            'number_of_hours' => 'string|nullable',
            'type_of_ld' => 'string|nullable',
            'conducted_sponsored_by' => 'string|nullable',
        ]);

        $request->user()->learning_and_development()->create($validate);

        return back()->with('success', 'Record has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LearningAndDevelopment $learningAndDevelopment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LearningAndDevelopment $learningAndDevelopment)
    {
        return inertia('Profile/PDS/LearningAndDevelopment/Edit', [
            'learning_and_development' => $learningAndDevelopment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LearningAndDevelopment $learningAndDevelopment)
    {
        $validate = $request->validate([
            'title_of_learning' => 'string|nullable',
            'inclusive_date_from' => 'date|nullable',
            'inclusive_date_to' => 'date|nullable',
            'number_of_hours' => 'string|nullable',
            'type_of_ld' => 'string|nullable',
            'conducted_sponsored_by' => 'string|nullable',
        ]);

        $learningAndDevelopment->update($validate);

        return back()->with('success', 'Record has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LearningAndDevelopment $learningAndDevelopment)
    {
        if($learningAndDevelopment->lnd_training()->exists()){
            return abort(403, 'You cannot delete this data.');
        }
        $learningAndDevelopment->delete();

        return back()->with('success', 'Record has been deleted.');
    }
}
