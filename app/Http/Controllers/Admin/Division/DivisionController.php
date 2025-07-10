<?php

namespace App\Http\Controllers\Admin\Division;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\DivisionChief;
use App\Models\User;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Admin/Division/Index', [
            'divisions' => Division::with(['positions'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:300',
            'abbreviation' => 'required|string|max:300',
        ]);

        $division = Division::create([
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
        ]);

        sweetalert()->addSuccess('Created Successfully!');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        return inertia('Admin/Division/Edit', [
            "division" => $division,
            "users" => User::role('employee')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        // dd($division);
        $request->validate([
            'name' => 'required|string|max:300',
            'abbreviation' => 'required|string|max:300',
        ]);

        $division->update([
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
        ]);

        sweetalert()->addSuccess('Updated Successfully!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        if($division->chief()->exists())
            $division->chief()->delete();

        $division->deleteOrFail();

        sweetalert()->addSuccess('Successfully Deleted');

        return back();
    }
}
