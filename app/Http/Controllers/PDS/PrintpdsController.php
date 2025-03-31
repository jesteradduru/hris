<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrintpdsController extends Controller
{
 public function index(Request $request){
    return inertia("Profile/PDS/PDSForm/MainLayout", [
        "personal_information" => $request->user()->personal_information,
        "profile" => $request->user(),
        "family_background" => $request->user()->family_background,
        "children" => $request->user()->children,
        "college_graduate_studies" => $request->user()->college_graduate_studies,
        "civil_service_eligibility" => $request->user()->civil_service_eligibility,
        "work_experience" => $request->user()->work_experience,
        "voluntary_work" => $request->user()->voluntary_work,
        "training_programs" => $request->user()->training_programs,
        "other_information" => $request->user()->other_information,
        "references" => $request->user()->references,
        "service_record" => $request->user()->service_record,
        "learning_and_development" => $request->user()->learning_and_development,
        'questions'=> $request->user()->page_four_questions
    ]);
}

}
