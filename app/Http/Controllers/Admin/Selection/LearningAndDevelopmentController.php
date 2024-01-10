<?php

namespace App\Http\Controllers\Admin\Selection;

use App\Http\Controllers\Controller;
use App\Models\LearningAndDevelopment;
use Illuminate\Http\Request;

class LearningAndDevelopmentController extends Controller
{
    public function includeLnd(Request $request, LearningAndDevelopment $lnd)
    {
        $included = $lnd->included;
        if( $lnd->included()->exists()){
            $lnd->included()->delete();

            return back()->with('success', 'Excluded successfully');
        }else{
            $lnd->included()->create([
                'job_application_id' => $request->job_application_id
            ]);
        }

        return back()->with('success', 'Included successfully');
    }
}
