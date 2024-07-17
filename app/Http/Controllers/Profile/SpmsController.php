<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\SpmsForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SpmsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SpmsForm::class, 'spm');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('Profile/SPMS/Index', [
            'spms' => $request->user()->spms
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
            'semester' => 'required|string|max:255',
            'rating' => 'required|decimal:0,2',
            'file' => 'required',
            'file.*' => 'mimes:pdf|max:25000'
        ], [
            'file.*.mimes' => 'Must be a pdf file.',
            'file.*.required' => 'Please attach the file.'
        ]);

        $path = $request->file('file')[0]->store('spms', 'public');

        $request->user()->spms()->create([
            'type' => $validated['type'],
            'year' => $validated['year'],
            'semester' => $validated['semester'],
            'rating' => $validated['rating'],
            'filepath' => $path
        ]);

        sweetalert()->addSuccess('Form has been added!');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(SpmsForm $spmsForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpmsForm $spm)
    {
        return inertia('Profile/SPMS/Edit', [
            'spms' => $spm
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SpmsForm $spm)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:2099',
            'semester' => 'required|string|max:255',
            'rating' => 'required|decimal:0,2',
            'file.*' => 'nullable|mimes:pdf|max:25000'
        ], [
            'file.*.mimes' => 'Must be a pdf file.',
            'file.*.required' => 'Please attach the file.'
        ]);
        
        if($request->hasFile('file')){
            Storage::disk('public')->delete($spm->filepath);
            $path = $request->file('file')[0]->store('spms', 'public');
            $spm->update([
                'type' => $validated['type'],
                'year' => $validated['year'],
                'semester' => $validated['semester'],
                'rating' => $validated['rating'],
                'filepath' => $path
            ]);
        }else{
            $spm->update([
                'type' => $validated['type'],
                'year' => $validated['year'],
                'semester' => $validated['semester'],
                'rating' => $validated['rating']
            ]);
        }

        sweetalert()->addSuccess('Form has been updated!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SpmsForm $spm)
    {
        Storage::disk('public')->delete($spm->filepath);
        $spm->delete();

        sweetalert()->addSuccess('Form has been deleted!');

        return back();
    }
}
