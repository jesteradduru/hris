<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use App\Models\CivilServiceEligibility;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CivilServiceEligibilityController extends Controller
{
    //show civil service eligibility page
    public function index(Request $request) {
        return inertia('Profile/PDS/CivilServiceEligibility/Index', [
            "eligibilities" => $request->user()->civil_service_eligibility()->with(['files'])->paginate(10)
        ]);
    }

    public function create(Request $request) {
        return inertia('Profile/PDS/CivilServiceEligibility/Create');
    }

    //  function to add eligibility
    public function store(Request $request) {
        $validate = $request->validate([
            "cs_board_bar_ces_csee_barangay_drivers" => "required|string",
            "rating" => "string|nullable",
            "date_of_exam_conferment" => "date|nullable",
            "place_of_exam_conferment" => "string|nullable",
            "license_number" => "string|nullable",
            "license_date_of_validity" => "date|nullable",
            'documents' => 'required|array|min:1',
            'documents.*'=> 'required|mimes:pdf|max:15000',
        ], [
            'documents.*.mimes' => 'Only pdf format is accepted.',
            'documents.*.max' => 'Document must not be greater than 15MB.',
            'documents.required' => 'Please upload the required documents.'
        ]);

        $eligibility = $request->user()->civil_service_eligibility()->create($validate);

        foreach ($request->file('documents') as $file){
 
            $path = $file->store('eligibilities', 'public');
            

            $eligibility->files()->save(new Document([
                'filename' => $file->getClientOriginalName(),
                'filepath' => $path
            ]));
        }


        return back()->with('success', 'Record saved.');
    }

    public function edit(CivilServiceEligibility $civil_service_eligibility) {
        return inertia('Profile/PDS/CivilServiceEligibility/Edit', [
            'civil_service_eligibility' => $civil_service_eligibility
        ]);
    }

    public function update(Request $request, CivilServiceEligibility $civil_service_eligibility) {
        $validate = $request->validate([
            "cs_board_bar_ces_csee_barangay_drivers" => "required|string",
            "rating" => "string|nullable",
            "date_of_exam_conferment" => "date|nullable",
            "place_of_exam_conferment" => "string|nullable",
            "license_number" => "string|nullable",
            "license_date_of_validity" => "date|nullable",
        ]);

        if($request->file('documents')){
            if($civil_service_eligibility->files()->exists()){
                $files = $civil_service_eligibility->files;
    
                foreach($files as $file){
                    Storage::disk('public')->delete($file->filepath);
                }
                $civil_service_eligibility->files()->delete();
            }
            
            foreach ($request->file('documents') as $file){
 
                $path = $file->store('education', 'public');
                
    
                $civil_service_eligibility->files()->save(new Document([
                    'filename' => $file->getClientOriginalName(),
                    'filepath' => $path
                ]));
            }
        }
        
        $civil_service_eligibility->update($validate);


        return back()->with('success', 'Record updated.');
    }

    //  function to delete eligibility
    public function destroy(CivilServiceEligibility $civil_service_eligibility) {
        

        if($civil_service_eligibility->files()->exists()){
            $files = $civil_service_eligibility->files;

            foreach($files as $file){
                Storage::disk('public')->delete($file->filepath);
            }
            $civil_service_eligibility->files()->delete();
        }

        $civil_service_eligibility->delete();

        return back()->with('success', 'Record Deleted.');
    }

}
