<?php

namespace App\Http\Controllers;

use App\Models\LndForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LndFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('LndForm/Index', [
            'lndForms' => $request->user()->lnd_form
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
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2099',
            'file' => 'required',
            'file.*.mimes' => 'mimes:pdf|max:25000'
        ], [
            'file.*.required' => 'Please attach the file.'
        ]);

        $path = $request->file('file')[0]->store('lnd_forms', 'public');

        $request->user()->lnd_form()->create([
            'type' => $validated['type'],
            'year' => $validated['year'],
            'filepath' => $path
        ]);


        return back()->with('success', 'Form has been added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LndForm $lndForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LndForm $lndForm)
    {
        return inertia('LndForm/Edit', [
            'lndForm' => $lndForm
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LndForm $lndForm)
    {   

        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2099',
            'file.*' => 'nullable|mimes:pdf|max:25000'
        ], [
            'file.*.required' => 'Please attach the file.'
        ]);
        
        if($request->hasFile('file')){
            Storage::disk('public')->delete($lndForm->filepath);
            $path = $request->file('file')[0]->store('lnd_forms', 'public');

            $lndForm->update([
                'type' => $validated['type'],
                'year' => $validated['year'],
                'filepath' => $path
            ]);

        }else{
            $lndForm->update([
                'type' => $validated['type'],
                'year' => $validated['year'], 
            ]);
        }



        return back()->with('success', "Form has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LndForm $lndForm)
    {
        Storage::disk('public')->delete($lndForm->filepath);
        $lndForm->delete();

        return back()->with('success', 'Form has been deleted.');
    }
}
