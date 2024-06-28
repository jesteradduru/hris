<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IdpAccomplishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IdpAccomplishmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $validate = $request->validate([
            'activity' => 'required|string|max:300',
            'file' => 'required|mimes:pdf|max:25000',
        ], [
            'file.*.required' => 'Select atleast one file.',
            'file.*.mimes' => 'The file you inserted is invalid. Only pdf files is allowed.',
        ]);

        $path = $request->file('file')[0]->store('idp_accomplishment', 'public');


        IdpAccomplishment::create([
            'filepath' => $path,
            'activity' => $validate['activity'],
            'lnd_form_id' => $request->lnd_form_id,
        ]);

        sweetalert()->addSuccess('Record added!');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(IdpAccomplishment $idpAccomplishment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IdpAccomplishment $idpAccomplishment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IdpAccomplishment $idpAccomplishment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IdpAccomplishment $idpAccomplishment)
    {
        Storage::disk('public')->delete($idpAccomplishment->filepath);
        $idpAccomplishment->delete();

        sweetalert()->addSuccess('Removed successfully!');

        return back();
    }
}
