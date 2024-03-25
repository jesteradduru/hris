<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationResultController extends Controller
{
    public function store(Request $request) {
        $application = null;

        $application = ApplicationResult::where('application_id', $request->application_id)
        ->where('result_id', $request->result_id)->first();


        DB::table('application_results')
            ->where('application_id', $request->application_id)
            ->where('result_id', $request->result_id)
            ->update(['result' => $request->result ]);

            if($application->user->hasAnyRole('user')){
                $application->user()->removeRole('user');
                $application->user->assignRole('employee');
            }

        
            $application->user->update([
                'plantilla_id' => $request->plantilla_id
            ]);

        sweetalert()->addSuccess('Results updated!');

        return back();
    }

    public function updateNotes(Request $request){
        $application_result = ApplicationResult::find($request->application_result);
        $application_result->update([
            'notes' => $request->notes
        ]);

        return back();
    }
}
