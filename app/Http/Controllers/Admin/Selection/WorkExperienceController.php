<?php

namespace App\Http\Controllers\Admin\Selection;

use App\Http\Controllers\Controller;
use App\Models\WorkExperience;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    public function includeWork(Request $request, WorkExperience $work)
    {
        if( $work->included()->exists()){
            $work->included()->delete();

            return back()->with('success', 'Excluded successfully');
        }else{
            $work->included()->create([
                'job_application_id' => $request->job_application_id
            ]);
        }

        return back()->with('success', 'Included successfully');
    }
}
