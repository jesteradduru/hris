<?php

namespace App\Http\Controllers\Admin\DTR;

use App\Http\Controllers\Controller;
use App\Models\DTR\Timesheet;
use App\Models\DTR\TimesheetEntries;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeSheetController extends Controller
{
    public function index(Request $request) {
        $timesheet = TimesheetEntries::with(['user', 'createdBy'])->orderBy('id', 'desc')->get();

        return inertia('Admin/DailyTimeRecord/TimeSheet/Index', [
            'employees' => User::role(['employee', 'hr'])->get(),
            'timesheet' => $timesheet
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'employee' => 'required_unless:rdEmployee,all|integer|nullable',
            'purpose' => 'required|string',
            'date' => 'required_unless:remarks,STUDY_LEAVE,ON_SCHOLARSHIP,REG_OB,REG_SPL,REG_SL,REG_VL,REG_FL|required_unless:reg_multiday,true|date|nullable',
            'pass_type' => 'required_if:purpose,pass|string|nullable',
            'pass_in' => 'required_if:purpose,pass|string|nullable',
            'pass_out' => 'required_if:purpose,pass|string|nullable',
            'supp_am_in' => 'string|nullable',
            'supp_am_out' => 'string|nullable',
            'supp_pm_in' => 'string|nullable',
            'supp_pm_out' => 'string|nullable',
            'remarks' => 'required_if:purpose,off|string|nullable',
            'off_hours' => 'required_if:remarks,OFFSETTING|integer|nullable',
            'off_title' => 'required_if:remarks,EO|string|nullable',
            'eo_sched_type' => 'required_if:remarks,EO|string|nullable',
            'reg_multiday' => 'boolean',
            'reg_start' => 'required_if:reg_multiday,true|date|nullable',
            'reg_end' => 'required_if:reg_multiday,true|date|nullable',
            'multiEmployee' => 'required_if:rdEmployee,multiple|array|nullable'
        ]);


        $employees = array();

        if($request->rdEmployee == 'single'){
            array_push($employees, $request->employee);
        }else if($request->rdEmployee == 'multiple'){
            $employees = $request->multiEmployee;
        }else{
            array_push($employees, 0);
        }
        

        foreach($employees as $employee){
            if($request->purpose === 'pass'){
                $request->user()->timesheet_entry()->create([
                    'employee' => $employee,
                    'purpose' => $request->purpose,
                    'pass_type' => $request->pass_type,
                    'date' => $request->date,
                    'pass_in' => $request->pass_in,
                    'pass_out' => $request->pass_out
                ]);
    
    
                sweetalert()->addSuccess('Pass slip added!');
                
            }
    
            else if($request->purpose === 'supp'){
    
                $request->user()->timesheet_entry()->create([
                    'employee' => $employee,
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
    
                $wholeday_remarks = [
                    'REG_HOLIDAY',
                    'RA_9710',
                    'REG_OB',
                    'REG_SPL',
                    'REG_SL',
                    'REG_VL',
                    'REG_FL',
                    'STUDY_LEAVE',
                    'ON_SCHOLARSHIP'
                ];
                
                // dd($study_or_scholarship);
    
    
                // if EO and allday
                if($eo_and_allday){
                    $request->user()->timesheet_entry()->create([
                        // 'employee' => $request->employee,
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
                    $request->user()->timesheet_entry()->create([
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
                    $request->user()->timesheet_entry()->create([
                        'employee' => $employee,
                        'purpose' => $request->purpose,
                        'date' => $request->date,
                        'remarks' => $request->remarks,
                        'off_hours' => $request->off_hours,
                    ]);
                }
    
    
                else if(in_array($request->remarks, $wholeday_remarks) && $request->reg_multiday){
                    $request->user()->timesheet_entry()->create([
                        'employee' => $employee,
                        'purpose' => $request->purpose,
                        'remarks' => $request->remarks,
                        'reg_start' => $request->reg_start,
                        'reg_end' => $request->reg_end,
                        'reg_multiday' => $request->reg_multiday,
                    ]);
                }
    
                else{
                    $request->user()->timesheet_entry()->create([
                        'employee' => $request->rdEmployee == 'all' ? null : $employee,
                        'purpose' => $request->purpose,
                        'date' => $request->date,
                        'remarks' => $request->remarks,
                    ]);
                }
                
    
                sweetalert()->addSuccess('Successfully added!');
            }
        }

        return back();
    }

    public function destroy(TimesheetEntries $timesheet){
        $timesheet->delete();

        sweetalert()->addSuccess('Successfully deleted!');

        return back();
    }

    public function deleteSelected(Request $request){
        $entries_to_delete =  $request->selected_entries;

        DB::table('timesheet_entries')->whereIn('id', $entries_to_delete)->delete();


        sweetalert()->addSuccess('Successfully deleted!');

        return back();
    }
}
