<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;

class JobPostingController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'order_by', 'order']);

        return inertia('Recruitment/JobPosting/Index', [
            'job_vacancies' => JobPosting::filter($filters)->paginate(15)->withQueryString(),
            'filters' => $filters
        ]);
    }

    
    /**
     * Display the specified resource.
     */
    public function show(JobPosting $job_posting)
    {
        return inertia('Recruitment/JobPosting/Show', [
            'job_posting' => $job_posting
        ]);
    }
}
