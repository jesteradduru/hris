<?php

namespace App\Http\Controllers\Admin\Selection;

use App\Http\Controllers\Controller;
use App\Models\NonAcademicDistinction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class NonAcademicAwardController extends Controller
{
    public function updateCategory(Request $request, NonAcademicDistinction $non_academic)
    {
        $non_academic->update([
            'category'=> $request->category
        ]);

        sweetalert()->addSuccess('Updated successfully!');

        return back();
    }

    public function includeAward(Request $request, NonAcademicDistinction $non_academic)
    {
        $award = $non_academic->whereHas('included', function (Builder $query) use($request, $non_academic) {
            $query->where('job_application_id',  $request->job_application_id)->where('computable_id', $non_academic->id);
        })->get();

        if(count($award) > 0){
            $non_academic->included()->where('job_application_id',  $request->job_application_id)->delete();

            sweetalert()->addSuccess('Added successfully!');
            
        }else{
            $non_academic->included()->create([
                'job_application_id' => $request->job_application_id
            ]);

            sweetalert()->addSuccess('Added successfully!');
        }



        return back();
    }


}
