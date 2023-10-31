<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LndForm;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IdpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only('year', 'name');
        $idp_forms = LndForm::filter($filters)->idpForm()->whereHas(
            'user', fn($query) => $query->filter($filters)
        )->with(['user', 'idp_accomplishment'])->paginate(20)->withQueryString();

        return inertia('Admin/L&D/IDP/Index', [
            'idp_forms' => $idp_forms,
            'years' => LndForm::idpForm()->get()->pluck('year')
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
        //
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
    public function edit(LndForm $idp)
    {
        return inertia('Admin/L&D/IDP/Edit/Edit', [
            'idp' => $idp->load(['idp_accomplishment'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
