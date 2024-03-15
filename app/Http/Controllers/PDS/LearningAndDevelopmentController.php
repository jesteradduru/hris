<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\LearningAndDevelopment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LearningAndDevelopmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('Profile/PDS/LearningAndDevelopment/Index', [
            'learning_and_development' => $request->user()->learning_and_development()->with(['files'])->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Profile/PDS/LearningAndDevelopment/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title_of_learning' => 'required|string',
            'inclusive_date_from' => 'date|nullable',
            'inclusive_date_to' => 'date|nullable',
            'number_of_hours' => 'string|nullable',
            'type_of_ld' => 'string|nullable',
            'conducted_sponsored_by' => 'string|nullable',
            'documents' => 'required|array|min:1',
            'documents.*'=> 'required|mimes:pdf|max:15000',
        ], [
            'documents.*.mimes' => 'Only pdf format is accepted.',
            'documents.*.max' => 'Document must not be greater than 15MB.',
            'documents.required' => 'Please upload the required documents.'
        ]);


        $lnd = $request->user()->learning_and_development()->create($validate);

        foreach ($request->file('documents') as $file){
 
            $path = $file->store('lnd', 'public');
            

            $lnd->files()->save(new Document([
                'filename' => $file->getClientOriginalName(),
                'filepath' => $path
            ]));
        }

        sweetalert()->addSuccess('Record saved!');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(LearningAndDevelopment $learningAndDevelopment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LearningAndDevelopment $learningAndDevelopment)
    {
        return inertia('Profile/PDS/LearningAndDevelopment/Edit', [
            'learning_and_development' => $learningAndDevelopment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LearningAndDevelopment $learningAndDevelopment)
    {
        $validate = $request->validate([
            'title_of_learning' => 'string|nullable',
            'inclusive_date_from' => 'date|nullable',
            'inclusive_date_to' => 'date|nullable',
            'number_of_hours' => 'string|nullable',
            'type_of_ld' => 'string|nullable',
            'conducted_sponsored_by' => 'string|nullable',
        ]);

        $learningAndDevelopment->update($validate);

        if($request->file('documents')){
            if($learningAndDevelopment->files()->exists()){
                $files = $learningAndDevelopment->files;
    
                foreach($files as $file){
                    Storage::disk('public')->delete($file->filepath);
                }
                $learningAndDevelopment->files()->delete();
            }
            
            foreach ($request->file('documents') as $file){
 
                $path = $file->store('lnd', 'public');
                
    
                $learningAndDevelopment->files()->save(new Document([
                    'filename' => $file->getClientOriginalName(),
                    'filepath' => $path
                ]));
            }
        }
        

        sweetalert()->addSuccess('Record updated!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LearningAndDevelopment $learningAndDevelopment)
    {
        if($learningAndDevelopment->lnd_training()->exists()){
            sweetalert()->addError('You cannot delete this data.');

            return back();
        }

        if($learningAndDevelopment->files()->exists()){
            $files = $learningAndDevelopment->files;

            foreach($files as $file){
                Storage::disk('public')->delete($file->filepath);
            }
            $learningAndDevelopment->files()->delete();
        }
        
        $learningAndDevelopment->delete();

        sweetalert()->addSuccess('Record deleted!');
        return back();
    }
}
