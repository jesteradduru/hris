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
        $works = $work->whereHas('included', function (Builder $query) use($request, $work) {
            $query->where('job_application_id',  $request->job_application_id)->where('computable_id', $work->id);
        })->get();

        if( count($works) > 0){
            $work->included()->where('job_application_id',  $request->job_application_id)->delete();

            sweetalert()->addSuccess('Removed successfully!');

            return back();
        }else{
            $work->included()->create([
                'job_application_id' => $request->job_application_id
            ]);
        }

        sweetalert()->addSuccess('Included successfully!');

        return back();
    }
}
