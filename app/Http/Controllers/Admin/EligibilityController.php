<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Eligibility;
use Illuminate\Http\Request;

class EligibilityController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        Eligibility::create([
            "title" => $request->title
        ]);

        return back();
    }
    public function update(Request $request, Eligibility $eligibility){
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $eligibility->update([
            "title" => $request->title
        ]);

        return back();
    }

    public function destroy(Eligibility $eligibility){
        $eligibility->delete();

        sweetalert()->addSuccess('Eligibility deleted successfully!');

        return back();
    }
}
