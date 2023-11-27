<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationScore;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class ApplicationScoreController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validate = $request->validate([
            "performance" => 'required|decimal:0,2',
            "education" => 'required|decimal:0,2',
            "experience" => 'required|decimal:0,2',
            "personality" => 'required|decimal:0,2',
            "potential" => 'required|decimal:0,2',
        ]);

        $job_application = JobApplication::find($request->application_id);

        if($job_application->score()->exists()){
            $job_application->score()->update([
                ...$validate,
                'job_application_id' => $request->application_id,
                'total' => $validate['performance'] + $validate['education'] + $validate['experience'] + $validate['personality'] + $validate['potential']
            ]);
        }else{
            ApplicationScore::create([
                ...$validate,
                'job_application_id' => $request->application_id,
                'total' => $validate['performance'] + $validate['education'] + $validate['experience'] + $validate['personality'] + $validate['potential']
            ]);
        }

        

        return back()->with('success', 'Score has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ApplicationScore $applicationScore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApplicationScore $applicationScore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApplicationScore $applicationScore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApplicationScore $applicationScore)
    {
        //
    }
}
