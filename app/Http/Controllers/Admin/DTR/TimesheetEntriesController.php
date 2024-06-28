<?php

namespace App\Http\Controllers\Admin\DTR;

use App\Http\Controllers\Controller;
use App\Models\DTR\Timesheet;
use Illuminate\Http\Request;

class TimesheetEntriesController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $request->user()->timesheet_draft()->create([
            'name' => $request->name
        ]);

        sweetalert()->addSuccess('Timesheet Created');

        return back();
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
    public function destroy(Timesheet $timesheet_draft)
    {
        if($timesheet_draft->entries()->exists()){
            $timesheet_draft->entries()->delete();
        }

        $timesheet_draft->delete();

        sweetalert()->addSuccess('Draft successfully deleted!');

        return back();
    }
}
