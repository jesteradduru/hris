<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Models\PlantillaPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminJobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->authorizeResource(JobPosting::class, 'job_posting');
    }
    
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'order_by', 'order', 'show']);

        // dd($filters);

        return inertia('Admin/Recruitment/JobPosting/Index', [
            'job_vacancies' => JobPosting::withCount(['job_application'])->with(['plantilla'])->filter($filters)->paginate(15)->withQueryString(),
            'filters' => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $plantilla = null;
        
        if($request->plantilla){
            $plantilla = PlantillaPosition::find($request->plantilla);
        }

        return inertia('Admin/Recruitment/JobPosting/Create', [
            'plantilla' => $plantilla,
            'positions' => PlantillaPosition::doesntHave('user')->with('division')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            "documents" => "required|string|max:500|nullable",
            "posting_date" => "required|date",
            "closing_date" => "required|date"
        ], [
            'documents.required' => 'The requirements field is required.'
        ]);

        $job_posting = $request->user()->job_posting()->create([
            "documents" => $validateData['documents'],
            "posting_date" => $validateData['posting_date'],
            "closing_date" => $validateData['closing_date'],
            "plantilla_id" => $request->plantilla
        ]);
        
        $job_posting->results()->create([
            'phase' => 'INITIAL_SCREENING'
        ]);

        return back()->with('success', 'Record added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPosting $job_posting)
    {
        return inertia('Admin/Recruitment/JobPosting/Show', [
            'job_posting' => $job_posting->load(['plantilla'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, JobPosting $job_posting)
    {
        $plantilla = null;
        
        if($request->plantilla){
            $plantilla = PlantillaPosition::find($request->plantilla);
        }

        return inertia('Admin/Recruitment/JobPosting/Edit', [
            'plantilla' => $plantilla,
            'job_posting' => $job_posting->load(['plantilla']),
            'positions' => PlantillaPosition::doesntHave('user')->with('division')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobPosting $job_posting)
    {
        $messages = [
            'plantilla_item_no.unique' => 'The Plantilla Item already exists in the database.'
        ];

        $validated = Validator::make($request->all(), [
            "documents" => "string|max:500|nullable",
            "posting_date" => "required|date",
            "closing_date" => "required|date",
            "plantilla_id" => "required|integer"
        ], $messages)->validate();
        
        $job_posting->update($validated);

        return back()->with('success', 'Record updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPosting $job_posting)
    {
        $job_posting->deleteOrFail();

        return redirect(route('admin.recruitment.job_posting.index'))->with('success', 'Record successfully deleted!');
    }

    public function archived(JobPosting $job_posting){
        $job_posting->update([
            'archived_at' => now()
        ]);

        return redirect(route('admin.recruitment.selection.index'))->with('success', 'Job vacancy has been archived.');
    }
}
