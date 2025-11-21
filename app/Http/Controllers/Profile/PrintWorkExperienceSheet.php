<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrintWorkExperienceSheet extends Controller
{
    public function print(Request $request){
        $user_id = $request->user_id ?? $request->user()->id;
        $user = User::find($user_id);

        $work_experiences = $user->work_experience()->mostRecent()->get();

        $experiences = $work_experiences->map(function ($experience) {
            $accomplishments = $experience->list_of_accomplishments ? explode("\n", $experience->list_of_accomplishments) : [];
            
            $date_from = Carbon::parse($experience->inclusive_date_from)->format('d F Y');
            $date_to = $experience->to_present ? 'present' : Carbon::parse($experience->inclusive_date_to)->format('d F Y');

            return [
                'duration' => $date_from . ' - ' . $date_to,
                'position' => $experience->position_title,
                'officeUnit' => $experience->name_of_office_unit,
                'supervisor' => $experience->immediate_supervisor,
                'agencyLocation' => $experience->dept_agency_office_company,
                'accomplishments' => $accomplishments,
                'duties' => $experience->summary_of_duties,
            ];
        });
        
        return inertia('Profile/WorkExperienceSheet/Print', [
            'experiences' => $experiences
        ]);
    }
}
