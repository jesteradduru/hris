<?php

namespace App\Http\Controllers\Admin\Selection;

use App\Http\Controllers\Controller;
use App\Models\LearningAndDevelopment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LearningAndDevelopmentController extends Controller
{
    public function includeLnd(Request $request, LearningAndDevelopment $lnd)
    {
        $training = $lnd->whereHas('included', function (Builder $query) use($request) {
            $query->where('job_application_id',  $request->job_application_id);
        })->get();

        if( count($training) > 0){
            $lnd->included()->where('job_application_id',  $request->job_application_id)->delete();

            return back()->with('success', 'Excluded successfully');
        }else{
            $lnd->included()->create([
                'job_application_id' => $request->job_application_id
            ]);
        }

        return back()->with('success', 'Included successfully');
    }
}
