<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\EducationalBackgroundCollegeGraduateStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function create(Request $request)
    {
        if($request->type == 'COLLEGE'){
            return inertia('Profile/PDS/EducationalBackground/College/Create');
        }

        else if($request->type == 'GRADUATE'){
            return inertia('Profile/PDS/EducationalBackground/Graduate/Create');
        }

        else{
            return abort(404);
        }
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

        if($request->scholarship_academic_honors){

            foreach($request->scholarship_academic_honors as $key => $honor){

                $award = $course->academic_award()->create([
                    'title' => $honor['title'],
                    'category' => $honor['category'],
                    'date_awarded' => $honor['date_awarded'],
                ]);

                $path = $honor['attachment'][0]->store('academic_award', 'public');

                $award->files()->save(new Document([
                    'filename' => $honor['attachment'][0]->getClientOriginalName(),
                    'filepath' => $path
                ]));


            }
        }




        foreach ($request->file('documents') as $file){
 
            $path = $file->store('education', 'public');
            

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
    public function edit(EducationalBackgroundCollegeGraduateStudy $college_graduate_study)
    {
        return inertia('Profile/PDS/EducationalBackground/College/Edit', [
            'education' => $college_graduate_study->load([
                'academic_award' => ['files'],
                'files'
            ])
        ]);
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
        ]);

        $course = EducationalBackgroundCollegeGraduateStudy::find($request->college_graduate_study);

        $course->update(
            [
                ...$validate,
            ]
        );


        if($request->scholarship_academic_honors_new){

            foreach($request->scholarship_academic_honors_new as $key => $honor){

                $award = $course->academic_award()->create([
                    'title' => $honor['title'],
                    'category' => $honor['category'],
                    'date_awarded' => $honor['date_awarded'],
                ]);

                $path = $honor['attachment'][0]->store('academic_award', 'public');

                $award->files()->save(new Document([
                    'filename' => $honor['attachment'][0]->getClientOriginalName(),
                    'filepath' => $path
                ]));


            }
        }
        

        if($request->file('documents')){
            if($course->files()->exists()){
                $files = $course->files;
    
                foreach($files as $file){
                    Storage::disk('public')->delete($file->filepath);
                }
                $course->files()->delete();
            }
            
            foreach ($request->file('documents') as $file){
 
                $path = $file->store('education', 'public');
                
    
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
            $files = $course->files;

            foreach($files as $file){
                Storage::disk('public')->delete($file->filepath);
            }
            $course->files()->delete();
        }


        if(count($course->academic_award) > 0){
            foreach($course->academic_award as $award){
                $files = $award->files;

                foreach($files as $file){
                    Storage::disk('public')->delete($file->filepath);
                }
                $award->files()->delete();
            }

            $course->academic_award()->delete();
        }

        
        $course->delete();

        return back()->with('success', 'Sucessfully deleted.');
    }
}
