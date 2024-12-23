<?php

namespace App\Http\Controllers\Admin\Selection;

use App\Http\Controllers\Controller;
use App\Models\SpmsForm;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class IncludeIPCRController extends Controller
{
    public function includeIPCR(Request $request, SpmsForm $spms)
    {
        $works = $spms->whereHas('included', function (Builder $query) use($request, $spms) {
            $query->where('job_application_id',  $request->job_application_id)->where('computable_id', $spms->id);
        })->get();

        if( count($works) > 0){
            $spms->included()->where('job_application_id',  $request->job_application_id)->delete();

            flash('Removed successfully!');

            return back();
        }else{
            $spms->included()->create([
                'job_application_id' => $request->job_application_id
            ]);

            flash('Included successfully!');
        }


        return back();
    }
}
