<?php

namespace App\Http\Controllers\Admin\DTR;

use App\Http\Controllers\Controller;
use App\Models\DTR\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;

class TimeSheetController extends Controller
{
    public function index(Request $request) {
        $timesheet_draft = Timesheet::find($request->timesheet_draft)->load(['entries' => ['user']]);

        return inertia('Admin/DailyTimeRecord/TimeSheet/Index', [
            'employees' => User::role('employee')->get(),
            'timesheet_draft' => $timesheet_draft
        ]);
    }

    public function store(Request $request) {

        $timesheet_draft = Timesheet::find($request->timesheet_draft_id);

        $request->validate([
            'employee' => 'required|integer',
            'purpose' => 'required|string',
            'date' => 'required_unless:remarks,STUDY_LEAVE,ON_SCHOLARSHIP|date|nullable',
            'pass_type' => 'required_if:purpose,pass|string|nullable',
            'pass_in' => 'required_if:purpose,pass|string|nullable',
            'pass_out' => 'required_if:purpose,pass|string|nullable',
            'supp_am_in' => 'required_if:purpose,supp|string|nullable',
            'supp_am_out' => 'required_if:purpose,supp|string|nullable',
            'supp_pm_in' => 'required_if:purpose,supp|string|nullable',
            'supp_pm_out' => 'required_if:purpose,supp|string|nullable',
            'remarks' => 'required_if:purpose,off|string|nullable',
            'off_hours' => 'required_if:remarks,OFFSETTING|integer|nullable',
            'off_title' => 'required_if:remarks,EO|string|nullable',
            'eo_sched_type' => 'required_if:remarks,EO|string|nullable',
        ]);

        

        if($request->purpose === 'pass'){
            $timesheet_draft->entries()->create([
                'employee' => $request->employee,
                'purpose' => $request->purpose,
                'pass_type' => $request->pass_type,
                'date' => $request->date,
                'pass_in' => $request->pass_in,
                'pass_out' => $request->pass_out
            ]);


            sweetalert()->addSuccess('Pass slip added!');
            
        }

        else if($request->purpose === 'supp'){
            $timesheet_draft->entries()->create([
                'employee' => $request->employee,
                'purpose' => $request->purpose,
                'date' => $request->date,
                'supp_am_in' => $request->supp_am_in,
                'supp_am_out' => $request->supp_am_out,
                'supp_pm_in' => $request->supp_pm_in,
                'supp_pm_out' => $request->supp_pm_out
            ]);


            sweetalert()->addSuccess('Supplementary added!');
            
        }

        else if($request->purpose === 'off'){
            $eo_and_partial = $request->eo_sched_type === 'PARTIAL' && $request->remarks === 'EO';
            $eo_and_allday = $request->eo_sched_type === 'ALLDAY' && $request->remarks === 'EO';
            $study_or_scholarship = $request->remarks === 'STUDY_LEAVE' || $request->remarks === 'ON_SCHOLARSHIP';
            // dd($study_or_scholarship);

            // validation
            if($study_or_scholarship){
                $request->validate([
                    'off_start' => 'required|string|nullable',
                    'off_end' => 'required|string|nullable',
                ]);

                $timesheet_draft->entries()->create([
                    'employee' => $request->employee,
                    'purpose' => $request->purpose,
                    'remarks' => $request->remarks,
                    'off_start' => $request->off_start,
                    'off_end' => $request->off_end,
                ]);
            }

            // if EO and allday
            else if($eo_and_allday){
                $timesheet_draft->entries()->create([
                    'employee' => $request->employee,
                    'purpose' => $request->purpose,
                    'date' => $request->date,
                    'remarks' => $request->remarks,
                    'off_title' => $request->off_title,
                    'eo_sched_type' => $request->eo_sched_type,
                    'off_hours' => 8
                ]);
            }
            // if EO and partial
            else if($eo_and_partial){
                $timesheet_draft->entries()->create([
                    'employee' => $request->employee,
                    'purpose' => $request->purpose,
                    'date' => $request->date,
                    'remarks' => $request->remarks,
                    'off_title' => $request->off_title,
                    'eo_sched_type' => $request->eo_sched_type,
                    'eo_start' => $request->eo_start,
                    'eo_end' => $request->eo_end,
                ]);
            }

            else if($request->remarks === 'OFFSETTING'){
                $timesheet_draft->entries()->create([
                    'employee' => $request->employee,
                    'purpose' => $request->purpose,
                    'date' => $request->date,
                    'remarks' => $request->remarks,
                    'off_hours' => $request->off_hours,
                ]);
            }

            else{
                
                $timesheet_draft->entries()->create([
                    'employee' => $request->employee,
                    'purpose' => $request->purpose,
                    'date' => $request->date,
                    'remarks' => $request->remarks,
                ]);
            }
            

            sweetalert()->addSuccess('Successfully added!');
        }

        return back();
    }
}
