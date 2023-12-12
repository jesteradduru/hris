<?php

namespace App\Http\Controllers\Admin\Selection;

use App\Http\Controllers\Controller;
use App\Models\AcademicDistinction;
use Illuminate\Http\Request;

class AcademicAwardController extends Controller
{
    
    public function includeAward(Request $request, AcademicDistinction $academic)
    {
        if( $academic->included()->exists()){
            $academic->included()->delete();

            return back()->with('success', 'Excluded successfully');
        }else{
            $academic->included()->create([
                'job_application_id' => $request->job_application_id
            ]);
        }

        return back()->with('success', 'Included successfully');
    }
}
