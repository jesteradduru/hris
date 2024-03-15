<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Eligibility;
use App\Models\PlantillaPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PlantillaPositionController extends Controller
{
    public function index() {

        return inertia('Admin/Recruitment/PlantillaPositions/Index', [
            'positions' => PlantillaPosition::with('division')->paginate(15),
        ]);
    }

    public function create(Request $request) {
        $plantilla = null;
        
        if($request->plantilla){
            $plantilla = PlantillaPosition::find($request->plantilla);
        }

        return inertia('Admin/Recruitment/PlantillaPositions/Create', [
            'eligibilities' => Eligibility::all(),
            'divisions' => Division::all(),
            'positions' => PlantillaPosition::with('division')->get(),
            'plantilla' => $plantilla
        ]);
    }

    public function store(Request $request) {
        $validate = $request->validate([
            "place_of_assignment" => "required|string|max:255",
            "plantilla_item_no" => "required|string|max:255|unique:plantilla_positions,plantilla_item_no",
            "position" => "required|string|max:255",
            "salary_grade" => "required|integer",
            "monthly_salary" => "required|integer",
            "eligibility" => "required|string|max:255",
            "education" => "required|string|max:255",
            "training" => "exclude_if:training_none_required,true|required_if:training_none_required,false|integer|min:1",
            "work_experience" => "exclude_if:work_none_required,true|required_if:work_none_required,false|integer|min:1",
            "competency" => "required|string|max:500",
            'division_id' => 'required|integer',
        ]);

        PlantillaPosition::create($validate);

        sweetalert()->addSuccess('Record saved!');

        return back();
    }

    public function edit(PlantillaPosition $plantilla) {
        return inertia('Admin/Recruitment/PlantillaPositions/Edit', 
            [
                'plantilla' => $plantilla,
                'divisions' => Division::all()
            ]
        );
    }

    public function update(Request $request, PlantillaPosition $plantilla)
    {
        $messages = [
            'plantilla_item_no.unique' => 'The Plantilla Item already exists in the database.'
        ];

        $validated = Validator::make($request->all(), [
            "place_of_assignment" => "required|string|max:255",
            "plantilla_item_no" => ["required", "string", Rule::unique('plantilla_positions')->ignore($plantilla->id)],
            "position" => "required|string|max:255",
            "salary_grade" => "required|integer",
            "monthly_salary" => "required|integer",
            "eligibility" => "required|string|max:255",
            "education" => "required|string|max:255",
            "training" => "exclude_if:training_none_required,true|required_if:training_none_required,false|integer|min:1",
            "work_experience" => "exclude_if:work_none_required,true|required_if:work_none_required,false|integer|min:1",
            "competency" => "required|string|max:500",
            "division_id" => "required|integer",
        ], $messages)->validate();
        
        $plantilla->update($validated);

        sweetalert()->addSuccess('Record updated!');

        return back();

    }

    public function destroy(PlantillaPosition $plantilla) {
        $plantilla->delete();

        sweetalert()->addSuccess('Record deleted!');
        return back();
    }
}
