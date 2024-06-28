<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplicationResults;
use Illuminate\Http\Request;

class SetExamScheduleController extends Controller
{
    public function __invoke(Request $request, JobApplicationResults $result)
    {

        $validate = $request->validate([
            'schedule' => 'required|date',
            'start_time' => 'nullable|string'
        ]);

        $result->update($validate);

        sweetalert()->addSuccess('Schedule has been updated!');

        return back();
    }
}
