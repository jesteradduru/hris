<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\PageFourReferencesId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageFourReferencesIdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('Profile/PDS/PageFourReferencesId/Index', [
            'reference_id' => $request->user()->references_id ? $request->user()->references_id->load(['files']) : null
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return inertia('Profile/PDS/PageFourReferencesId/Edit', [
            'references_and_id' => $request->user()->references_id
        ]);
    }


    public function store_or_update(Request $request) {

        $user = $request->user();

        $validate = $request->validate([
            "references_name_one" => "string|nullable",
            "references_address_one" => "string|nullable",
            "references_telephone_one" => "string|nullable",
            "references_name_two" => "string|nullable",
            "references_address_two" => "string|nullable",
            "references_telephone_two" => "string|nullable",
            "references_name_three" => "string|nullable",
            "references_address_three" => "string|nullable",
            "references_telephone_three" => "string|nullable",
            "government_issued_id" => "string|nullable",
            "id_license_passport_number" => "string|nullable",
            "date_place_of_issuance" => "string|nullable",
            "co_government_issued_id" => "string|nullable",
            "co_id_license_passport_number" => "string|nullable",
            "co_date_place_of_issuance" => "string|nullable",
            "photo" => "string|nullable",
        ]);

        if(!$user->references_id()->exists()){
            $validate_scanned = $request->validate([
                'documents' => 'required|array|min:1',
                'documents.*'=> 'required|mimes:pdf|max:15000',
            ], [
                'documents.*.mimes' => 'Only pdf format is accepted.',
                'documents.*.max' => 'Document must not be greater than 15MB.',
                'documents.required' => 'Please upload the required documents.'
            ]);

            
            $referenceid = $user->references_id()->create($validate);

            foreach ($request->file('documents') as $file){
 
                $path = $file->store('ids', 'public');
                
    
                $referenceid->files()->save(new Document([
                    'filename' => $file->getClientOriginalName(),
                    'filepath' => $path
                ]));
            }

        }else{
            $user->references_id()->update($validate);

            if($request->file('documents')){
                if($user->references_id->files()->exists()){
                    $files = $user->references_id->files;
        
                    foreach($files as $file){
                        Storage::disk('public')->delete($file->filepath);
                    }
                    $user->references_id->files()->delete();
                }
                
                foreach ($request->file('documents') as $file){
     
                    $path = $file->store('ids', 'public');
                    
        
                    $user->references_id->files()->save(new Document([
                        'filename' => $file->getClientOriginalName(),
                        'filepath' => $path
                    ]));
                }
            }
        }

        sweetalert()->addSuccess('Record saved!');
        
        return back();
    }

}
