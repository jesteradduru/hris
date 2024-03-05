<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use App\Models\PageFourQuestion;
use Illuminate\Http\Request;

class PageFourQuestionsController extends Controller
{
    public function edit(Request $request) {
        return inertia('Profile/PDS/PageFourQuestions/Edit', [
            'questions'=> $request->user()->page_four_questions
        ]);
    }

    public function store_or_update(Request $request) {

        $user = $request->user();

        $validate = $request->validate([
            "thirty_four_a" => "required|string|max:255",
            "thirty_four_b" => "required|string|max:255",
            "thirty_four_a_b_if_yes" => "required_if:thirty_four_a,Yes|required_if:thirty_four_b,Yes|string|max:255|nullable",
            "thirty_five_a" => "required|string|max:255",
            "thirty_five_a_if_yes" => "required_if:thirty_five_a,Yes|string|max:255|nullable",
            "thirty_five_b" => "required|string|max:255",
            "thirty_five_b_if_yes_date" => "required_if:thirty_five_b,Yes|string|max:255|nullable",
            "thirty_five_b_if_yes_case" => "required_if:thirty_five_b,Yes|string|max:255|nullable",
            "thirty_six" => "required|string|max:255",
            "thirty_six_if_yes" => "required_if:thirty_six,Yes|string|max:255|nullable",
            "thirty_seven" => "required|string|max:255",
            "thirty_seven_if_yes" => "required_if:thirty_seven,Yes|string|max:255|nullable",
            "thirty_eight_a" => "required|string|max:255",
            "thirty_eight_a_if_yes" => "required_if:thirty_eight_a,Yes|string|max:255|nullable",
            "thirty_eight_b" => "required|string|max:255",
            "thirty_eight_b_if_yes" => "required_if:thirty_eight_b,Yes|string|max:255|nullable",
            "thirty_nine" => "required|string|max:255",
            "thirty_nine_if_yes" => "required_if:thirty_nine,Yes|string|max:255|nullable",
            "fourty_a" => "required|string|max:255",
            "fourty_a_if_yes" => "required_if:fourty_a,Yes|string|max:255|nullable",
            "fourty_b" => "required|string|max:255",
            "fourty_b_if_yes" => "required_if:fourty_b,Yes|string|max:255|nullable",
            "fourty_c" => "required|string|max:255",
            "fourty_c_if_yes" => "required_if:fourty_c,Yes|string|max:255|nullable",
        ], [
            'thirty_four_a_b_if_yes.required_if' => 'This field is required.',
            'thirty_five_a_if_yes.required_if' => 'This field is required.',
            'thirty_four_a_b_if_yes.required_if' => 'This field is required.',
            'thirty_four_a_b_if_yes.required_if' => 'This field is required.',
            'thirty_four_a_b_if_yes.required_if' => 'This field is required.',
            'thirty_four_a_b_if_yes.required_if' => 'This field is required.',
            'thirty_five_b_if_yes_date.required_if' => 'This field is required.',
            'thirty_five_b_if_yes_case.required_if' => 'This field is required.',
            'thirty_six_if_yes.required_if' => 'This field is required.',
            'thirty_seven_if_yes.required_if' => 'This field is required.',
            'thirty_eight_a_if_yes.required_if' => 'This field is required.',
            'thirty_eight_b_if_yes.required_if' => 'This field is required.',
            'thirty_nine_if_yes.required_if' => 'This field is required.',
            'fourty_a_if_yes.required_if' => 'This field is required.',
            'fourty_b_if_yes.required_if' => 'This field is required.',
            'fourty_c_if_yes.required_if' => 'This field is required.',
        ]);

        if(!$user->page_four_questions()->exists()){
            $user->page_four_questions()->create($validate);
        }else{
            $user->page_four_questions()->update($validate);
        }
        
        return back()->with('success', 'Record saved.');
    }
}
