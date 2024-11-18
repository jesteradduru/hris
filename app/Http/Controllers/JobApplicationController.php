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
            'pds' => 'required|array|min:1',
            'pds.*'=> 'required|mimes:pdf|max:15000', 
            'rating' => 'nullable|array',
            'rating.*' => 'nullable|mimes:pdf|max:15000',
            'eligibility' => 'required|array|min:1',
            'eligibility.*'=> 'required|mimes:pdf|max:15000', 
            'tor' => 'required|array|min:1',
            'tor.*'=> 'required|mimes:pdf|max:15000', 
            // 'training' => 'nullable|array',
            // 'training.*'=> 'nullable|mimes:pdf|max:15000', 
            'documents' => 'nullable|array',
            'documents.*'=> 'nullable|mimes:pdf|max:15000' 
        ], [
            'pds.*.mimes' => 'Only pdf format is accepted.',
            'pds.*.max' => 'Document must not be greater than 15MB.',
            'pds.required' => 'Please upload signed photocopy of PDS.',
            'rating.*.mimes' => 'Only pdf format is accepted.',
            'rating.*.max' => 'Document must not be greater than 15MB.',
            'eligibility.*.mimes' => 'Only pdf format is accepted.',
            'eligibility.*.max' => 'Document must not be greater than 15MB.',
            'eligibility.required' => 'Please upload a photocopy of certificate of eligibility/rating/license.',
            'tor.*.mimes' => 'Only pdf format is accepted.',
            'tor.*.max' => 'Document must not be greater than 15MB.',
            'tor.required' => 'Please upload a photocopy of Transcript of Records.',
            // 'training.*.mimes' => 'Only pdf format is accepted.',
            // 'training.*.max' => 'Document must not be greater than 15MB.',
            'documents.*.mimes' => 'Only pdf format is accepted.',
            'documents.*.max' => 'Document must not be greater than 15MB.',
            'documents.required' => 'Please upload the required documents.'
        ]);
        

            $job_application = $request->user()->job_application()->create(
                [
                    'job_posting_id' => $job_posting->id,
                ]
            );
            

            $documents = array('pds', 'eligibility', 'tor', 'rating', 'documents');


            foreach($documents as $document){
                if($request->hasFile($document)){
                    foreach ($request->file($document) as $key=>$file){
                        $key += 1;
                        $path = $file->store('documents', 'public');

                        $filename = $file->getClientOriginalName();
                        $filename_explode = explode(".", $filename);

                        $upload_name = strtoupper($document . '_' . $request->user()->surname) . "_{$key}." . end($filename_explode);

                        // if($document === 'training') $upload_name = $filename_explode[0];

                        $job_application->document()->save(new JobApplicationAttachment([
                            'filename' => $upload_name,
                            'path' => $path
                        ]));
                    }
                }
            }


            sweetalert()->addSuccess('Application has been submitted!');
            
            return back();

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
        $job_vacancy = $job_application->job_posting;
        $job_vacancy_status = $job_vacancy->results()->orderBy('created_at', 'DESC')->first();

        // dd($job_vacancy_status);

       

        // dd($job_vacancy_status->phase);
        
        if($job_vacancy_status->phase !== 'INITIAL_SCREENING'){

            sweetalert()->addError('Application can not be recalled.');
            
            return back();

        }else{
            foreach($documents as $document){
                Storage::disk('public')->delete($document->path);
            }
            $job_application->document()->delete();
            $job_application->delete();
            
            sweetalert()->addSuccess('Application has been recalled.');
    
            return back();

        }



    }

}
