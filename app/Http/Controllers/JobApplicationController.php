<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobApplicationAttachment;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(JobApplication::class, 'job_application');
    }

    public function create(Request $request)
    {
        $job_posting = JobPosting::find($request->input('job_posting'));

        // $user_application = JobApplication::with([
        //     'job_posting' => fn($query) => $query->where('id', $request->input('job_posting')),
        //     'user' => fn($query) => $query->where('id', $request->user()->id),
        // ]);
        $user_application = $request->user()->job_application()
        ->with('document')
        ->where('job_posting_id', $request->input('job_posting'))->get();


        return inertia('JobApplication/Create', [
            "job_posting" => $job_posting,
            "application" => $user_application
        ]);
    }

    public function store(Request $request) {
        $user = $request->user();

        if(
            !$user->personal_information()->exists()
            || !$user->family_background()->exists()
            || !$user->college_graduate_studies()->exists()
            || !$user->page_four_questions()->exists()
        ){
            sweetalert()->addError('Please update your PDS. You must atleast fill Personal Information, Family Background, Educational Background and Questions form.');
            return back();
        }


        $job_posting = JobPosting::find($request->input('job_posting'));

        $request->validate([
            'documents' => 'required|array|min:1',
            'documents.*'=> 'required|mimes:pdf|max:15000' 
        ], [
            'documents.*.mimes' => 'Only pdf format is accepted.',
            'documents.*.max' => 'Document must not be greater than 15MB.',
            'documents.required' => 'Please upload the required documents.'
        ]);

        
        if($request->hasFile('documents')){
            $job_application = $request->user()->job_application()->create(
                [
                    'job_posting_id' => $job_posting->id,
                ]
            );

            foreach ($request->file('documents') as $file){
                $path = $file->store('documents', 'public');

                $job_application->document()->save(new JobApplicationAttachment([
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path
                ]));
            }

            sweetalert()->addSuccess('Application has been submitted!');
            
            return back();
        }

    }

    public function index(Request $request) {
        return inertia('Profile/JobApplications/Index', [
            'job_applications' => $request->user()->job_application()->with(['document', 'job_posting'])->get()
        ]);
    }


    public function show(JobApplication $job_application) {
        return inertia('Profile/JobApplications/Show', [
            'job_application' => $job_application->load([
                'document',
                'result' => fn($query) => $query->with('results')->published()->latest(),
                'job_posting'
            ])
        ]);
    }


    public function destroy(JobApplication $job_application){
        $documents = $job_application->document;

        foreach($documents as $document){
            Storage::disk('public')->delete($document->path);
        }
        $job_application->document()->delete();
        $job_application->delete();

        sweetalert()->addSuccess('Application has been canceled.');

        return back();
    }

}
