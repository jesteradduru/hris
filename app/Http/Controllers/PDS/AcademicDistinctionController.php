<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use App\Models\AcademicDistinction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AcademicDistinctionController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicDistinction $academicDistinction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicDistinction $academicDistinction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicDistinction $academicDistinction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicDistinction $academicDistinction)
    {

        if($academicDistinction->files()->exists()){
            $files = $academicDistinction->files;
            
            foreach($files as $file){
                Storage::disk('public')->delete($file->filepath);
            }

            $academicDistinction->files()->delete();
        }

        $academicDistinction->delete();

        sweetalert()->addSuccess('Removed successfully!');

        return back();
    }
}
