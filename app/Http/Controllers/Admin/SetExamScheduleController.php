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
        ]);

        $result->update($validate);

        return back()->with('success', 'Exam date has been updated.');
    }
}
