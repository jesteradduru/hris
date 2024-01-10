<?php

namespace App\Http\Controllers\Admin\Selection;

use App\Http\Controllers\Controller;
use App\Models\AcademicDistinction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AcademicAwardController extends Controller
{
    
    public function includeAward(Request $request, AcademicDistinction $academic)
    {
        $award = $academic->whereHas('included', function (Builder $query) use($request) {
            $query->where('job_application_id',  $request->job_application_id);
        })->get();

        if(count($award) > 0){
            $academic->included()->where('job_application_id',  $request->job_application_id)->delete();

            return back()->with('success', 'Excluded successfully');
        }else{
            $academic->included()->create([
                'job_application_id' => $request->job_application_id
            ]);
        }

        return back()->with('success', 'Included successfully');
    }
}
