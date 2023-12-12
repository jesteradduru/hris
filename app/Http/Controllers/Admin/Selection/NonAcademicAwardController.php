<?php

namespace App\Http\Controllers\Admin\Selection;

use App\Http\Controllers\Controller;
use App\Models\NonAcademicDistinction;
use Illuminate\Http\Request;

class NonAcademicAwardController extends Controller
{
    public function updateCategory(Request $request, NonAcademicDistinction $non_academic)
    {
        $non_academic->update([
            'category'=> $request->category
        ]);

        return back()->with('success', 'Update successfully');
    }

    public function includeAward(Request $request, NonAcademicDistinction $non_academic)
    {
        if( $non_academic->included()->exists()){
            $non_academic->included()->delete();

            return back()->with('success', 'Excluded successfully');
        }else{
            $non_academic->included()->create([
                'job_application_id' => $request->job_application_id
            ]);
        }

        return back()->with('success', 'Included successfully');
    }


}
