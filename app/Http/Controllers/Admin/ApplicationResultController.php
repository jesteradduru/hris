<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationResult;
use App\Models\JobApplicationResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationResultController extends Controller
{
    public function store(Request $request) {
        $application = ApplicationResult::where('application_id', $request->application_id)
        ->where('result_id', $request->result_id)->get();

        // IF SELECTED CHECK IF MAY NA SELECT NA
        if($request->result == 'SELECTED'){
            $selectionDone = JobApplicationResults::find($request->result_id)->whereRelation('result', 'result', 'SELECTED')->get();

            if(count($selectionDone) > 0){
                abort(403, 'Only one candidate can be selected.');
            }
        }


        if(count($application) > 0){
            DB::table('application_results')
            ->where('application_id', $request->application_id)
            ->where('result_id', $request->result_id)
            ->update(['result' => $request->result ]);
        }else{
            ApplicationResult::create([
                'result_id' => $request->result_id,
                'application_id' => $request->application_id,
                'user_id' => $request->user_id,
                'result' => $request->result
            ]);
        }

        return back()->with('success', 'Transaction success.');
    }

    public function updateNotes(Request $request){
        $application_result = ApplicationResult::find($request->application_result);
        $application_result->update([
            'notes' => $request->notes
        ]);

        return back();
    }
}
