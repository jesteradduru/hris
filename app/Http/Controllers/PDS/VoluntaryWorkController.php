<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use App\Models\VoluntaryWork;
use Illuminate\Http\Request;

class VoluntaryWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('Profile/PDS/VoluntaryWork/Index', [
            'voluntary_works' => $request->user()->voluntary_work()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Profile/PDS/VoluntaryWork/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            "name_address_of_org" => "required|string",
            "inclusive_date_from"=> "required|date",
            "inclusive_date_to"=> "required|date",
            "number_of_hours"=> "string|nullable",
            "position_work"=> "string|nullable",
        ]);

        $request->user()->voluntary_work()->create($validate);

        sweetalert()->addSuccess('Voluntary work has been saved.');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(VoluntaryWork $voluntaryWork)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VoluntaryWork $voluntaryWork)
    {
        return inertia('Profile/PDS/VoluntaryWork/Edit', [
            'voluntary_work' => $voluntaryWork
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VoluntaryWork $voluntaryWork)
    {
        $validate = $request->validate([
            "name_address_of_org" => "required|string",
            "inclusive_date_from"=> "required|date",
            "inclusive_date_to"=> "required|date",
            "number_of_hours"=> "string|nullable",
            "position_work"=> "string|nullable",
        ]);

        $voluntaryWork->update($validate);

        sweetalert()->addSuccess('Record updated!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VoluntaryWork $voluntaryWork)
    {
        $voluntaryWork->delete();

        sweetalert()->addSuccess('Record deleted!');

        return back();
    }
}
