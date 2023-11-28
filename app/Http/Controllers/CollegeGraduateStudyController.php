<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\EducationalBackgroundCollegeGraduateStudy;
use Illuminate\Http\Request;

class CollegeGraduateStudyController extends Controller
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
        $validate = $request->validate([
            "name_of_school" => "required|string|max:255",
            "basic_ed_degree_course" => "required|string|max:255",
            "period_from" => "required|integer",
            "period_to" => "required|integer",
            "highest_lvl_units_earned" => "nullable|integer",
            "year_graduated" => "required|integer",
            "scholarship_academic_honors" => "required|string|max:255",
            'documents' => 'required|array|min:1',
            'documents.*'=> 'required|mimes:pdf|max:15000',
        ], [
            'documents.*.mimes' => 'Only pdf format is accepted.',
            'documents.*.max' => 'Document must not be greater than 15MB.',
            'documents.required' => 'Please upload the required documents.'
        ]);

        

        $course = $request->user()->college_graduate_studies()->create(
            [
                ...$validate,
                'type' => $request->type
            ]
        );

        foreach ($request->file('documents') as $file){
 
            $path = $file->store('documents', 'public');
            

            $course->files()->save(new Document([
                'filename' => $file->getClientOriginalName(),
                'filepath' => $path
            ]));
        }

        return back()->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(EducationalBackgroundCollegeGraduateStudy $educationalBackgroundCollegeGraduateStudy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EducationalBackgroundCollegeGraduateStudy $educationalBackgroundCollegeGraduateStudy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

       
        $validate = $request->validate([
            "name_of_school" => "required|string|max:255",
            "basic_ed_degree_course" => "required|string|max:255",
            "period_from" => "required|integer",
            "period_to" => "required|integer",
            "highest_lvl_units_earned" => "nullable|integer",
            "year_graduated" => "required|integer",
            "scholarship_academic_honors" => "required|string|max:255",
            'documents' => 'required|array|min:1',
            'documents.*'=> 'required|mimes:pdf|max:15000',
        ], [
            'documents.*.mimes' => 'Only pdf format is accepted.',
            'documents.*.max' => 'Document must not be greater than 15MB.',
            'documents.required' => 'Please upload the required documents.'
        ]);

        $course = EducationalBackgroundCollegeGraduateStudy::find($request->college_graduate_study);

        $course->update(
            [
                ...$validate,
            ]
        );

        

        if($request->file('documents')){
            if($course->files()->exists()){
                $course->files()->delete();
            }
            
            foreach ($request->file('documents') as $file){
 
                $path = $file->store('documents', 'public');
                
    
                $course->files()->save(new Document([
                    'filename' => $file->getClientOriginalName(),
                    'filepath' => $path
                ]));
            }
        }
        
        
        return back()->with('success', 'Updated Successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $course = EducationalBackgroundCollegeGraduateStudy::find($request->college_graduate_study);

        if($course->files()->exists()){
            $course->files()->delete();
        }

        $course->delete();

        return back()->with('success', 'Sucessfully deleted.');
    }
}
