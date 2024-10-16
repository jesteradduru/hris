<?php

namespace App\Http\Controllers\Admin\Selection;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\PsbPoint;
use Illuminate\Http\Request;

class PsbPointController extends Controller
{
    public function save(Request $request) {

       $application  = JobApplication::find($request->job_application);
        $user = $application->user;

        $validate = null;

        // EMPLOYEE
        if($user->hasRole('employee')){
            $validate = $request->validate([
                // 'performance' => 'required|decimal:0,2|max:15',  
                'experience' => 'required|decimal:0,2|max:35',
                // 'personality_hrmpsb' => 'required|decimal:0,2|max:80',
                'org_competency' => 'required|decimal:0,2',
                'leadership_competency' => 'required|decimal:0,2',
                'technical_competency' => 'required|decimal:0,2',
                'personality_peer' => 'required|decimal:0,2|max:20',
                'potential' => 'required|decimal:0,2|max:15',
            ]);
        }else{
            $validate = $request->validate([
                // 'performance' => 'required|decimal:0,2|max:15',  
                'experience' => 'required|decimal:0,2|max:35',
                'org_competency' => 'required|decimal:0,2',
                'leadership_competency' => 'required|decimal:0,2',
                'technical_competency' => 'required|decimal:0,2',
                'potential' => 'required|decimal:0,2|max:15',
            ]);
        }


       if($application->psb_points()->exists()){
          $psb_points = $application->psb_points;
          $psb_points->update($validate);

       }else{
          $application->psb_points()->create($validate);
       }

    }
}
