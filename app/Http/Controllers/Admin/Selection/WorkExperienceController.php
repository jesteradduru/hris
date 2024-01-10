<?php

namespace App\Http\Controllers\Admin\Selection;

use App\Http\Controllers\Controller;
use App\Models\WorkExperience;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    public function includeWork(Request $request, WorkExperience $work)
    {
        $works = $work->whereHas('included', function (Builder $query) use($request) {
            $query->where('job_application_id',  $request->job_application_id);
        })->get();

        if( count($works) > 0){
            $work->included()->where('job_application_id',  $request->job_application_id)->delete();

            return back()->with('success', 'Excluded successfully');
        }else{
            $work->included()->create([
                'job_application_id' => $request->job_application_id
            ]);
        }

        return back()->with('success', 'Included successfully');
    }
}
