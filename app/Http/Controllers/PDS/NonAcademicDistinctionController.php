<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\NonAcademicDistinction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NonAcademicDistinctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('Profile/PDS/NonAcademicDistinction/Index', [
            'distinctions' => $request->user()->non_academic_distinction()->with(['files'])->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Profile/PDS/NonAcademicDistinction/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            "title" => "required|string",
            "office" => "string|nullable",
            "date_awarded" => "date|nullable",
            'documents' => 'required|array|min:1',
            'documents.*'=> 'required|mimes:pdf|max:15000',
        ], [
            'documents.*.mimes' => 'Only pdf format is accepted.',
            'documents.*.max' => 'Document must not be greater than 15MB.',
            'documents.required' => 'Please upload the required documents.',
            'title.required' => 'This field is required.'
        ]);

        $distinction = $request->user()->non_academic_distinction()->create($validate);

        foreach ($request->file('documents') as $file){
 
            $path = $file->store('non_academic_distinctions', 'public');
            

            $distinction->files()->save(new Document([
                'filename' => $file->getClientOriginalName(),
                'filepath' => $path
            ]));
        }


        return back()->with('success', 'Record saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NonAcademicDistinction $nonAcademicDistinction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NonAcademicDistinction $nonAcademicDistinction)
    {
        return inertia('Profile/PDS/NonAcademicDistinction/Edit', [
            'distinction' => $nonAcademicDistinction->load('files')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NonAcademicDistinction $nonAcademicDistinction)
    {
        $validate = $request->validate([
            "title" => "required|string",
            "office" => "string|nullable",
            "date_awarded" => "date|nullable",
            'documents' => 'array',
            'documents.*'=> 'mimes:pdf|max:15000',
        ], [
            'documents.*.mimes' => 'Only pdf format is accepted.',
            'documents.*.max' => 'Document must not be greater than 15MB.',
            'documents.required' => 'Please upload the required documents.',
            'title.required' => 'This field is required.'
        ]);

        if($request->file('documents')){
            if($nonAcademicDistinction->files()->exists()){
                $files = $nonAcademicDistinction->files;
    
                foreach($files as $file){
                    Storage::disk('public')->delete($file->filepath);
                }
                $nonAcademicDistinction->files()->delete();
            }
            
            foreach ($request->file('documents') as $file){
 
                $path = $file->store('non_academic_distinctions', 'public');
                
    
                $nonAcademicDistinction->files()->save(new Document([
                    'filename' => $file->getClientOriginalName(),
                    'filepath' => $path
                ]));
            }
        }
        
        $nonAcademicDistinction->update($validate);

        return back()->with('success', 'Record updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NonAcademicDistinction $nonAcademicDistinction)
    {
        if($nonAcademicDistinction->files()->exists()){
            $files = $nonAcademicDistinction->files;

            foreach($files as $file){
                Storage::disk('public')->delete($file->filepath);
            }
            $nonAcademicDistinction->files()->delete();
        }

        $nonAcademicDistinction->delete();

        return back()->with('success', 'Record Deleted.');
    }
}
