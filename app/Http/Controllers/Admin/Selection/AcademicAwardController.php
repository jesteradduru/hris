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
        $award = $academic->whereHas('included', function (Builder $query) use($request, $academic) {
            $query->where('job_application_id',  $request->job_application_id)->where('computable_id', $academic->id);
        })->get();

        // dd($academic->included);

        if(count($award) > 0){
            $academic->included()->where('job_application_id',  $request->job_application_id)->delete();

            sweetalert()->addSuccess('Removed successfully!');
            
            return back();
        }else{
            $academic->included()->create([
                'job_application_id' => $request->job_application_id
            ]);

            sweetalert()->addSuccess('Added successfully!');
        }


        return back();
    }
}
