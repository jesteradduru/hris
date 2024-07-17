<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\PesRating;
use Illuminate\Http\Request;

class PesRatingController extends Controller
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
        $application = JobApplication::where('user_id', $request->user_id)->where('job_posting_id', $request->job_posting_id)->first();


        $validate = $request->validate([
            'first_rating' => 'required_if:second_rating,null|decimal:2,4|nullable',
            'second_rating' => 'required_if:first_rating,null|decimal:2,4|nullable',
        ]);
        
        $application->pes_rating()->create($validate);

        sweetalert()->addSuccess('Record saved!');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(PesRating $pesRating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PesRating $pesRating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PesRating $pesRating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PesRating $pesRating)
    {
        //
    }
}
