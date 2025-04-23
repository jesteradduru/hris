<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use App\Models\OtherInformation;
use Illuminate\Http\Request;


class OtherInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('Profile/PDS/OtherInformation/Index', [
            'other_information' => $request->user()->other_information,
            'distinctions' => $request->user()->non_academic_distinction()->with(['files'])->paginate(15),
            'questions'=> $request->user()->page_four_questions,
            'reference_id' => $request->user()->references_id ? $request->user()->references_id->load(['files']) : null
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return inertia('Profile/PDS/OtherInformation/Edit', [
            'other_information' => $request->user()->other_information
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function store_or_update(Request $request)
    {
        $validate = $request->validate([
            "special_skills_hobbies" => 'string|nullable',
            "none_academic_distinctions" => 'string|nullable',
            "membership_in_assoc_org" => 'string|nullable',
        ]);

        if($request->user()->other_information()->exists()){
            $request->user()->other_information()->update($validate);
            sweetalert()->addSuccess('Record updated!');

            return back();
        }else{
            $request->user()->other_information()->create($validate);

            sweetalert()->addSuccess('Record updated!');
            return back();
        }
    }

}
