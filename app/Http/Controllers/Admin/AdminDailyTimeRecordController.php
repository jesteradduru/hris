<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyTimeRecord;
use App\Models\DTR\Timesheet;
use Illuminate\Http\Request;

class AdminDailyTimeRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['user_id']);
        return inertia('Admin/DailyTimeRecord/Index', [
            'dtrs' => DailyTimeRecord::with('user')->filter($filters)->paginate()->withQueryString(),
            'filters' => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return inertia('Admin/DailyTimeRecord/Create', [
            'timesheets' => Timesheet::with('user')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyTimeRecord $dailyTimeRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyTimeRecord $dailyTimeRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyTimeRecord $dailyTimeRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyTimeRecord $dailyTimeRecord)
    {
        //
    }

    public function getDtr(){

        DailyTimeRecord::getDtr();

        sweetalert()->addSuccess('Loaded successfully!');

        return back();

    }

    public function export_monthly_dtr(){
        
    }
}
