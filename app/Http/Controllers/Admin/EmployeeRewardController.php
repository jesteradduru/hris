<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeReward;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeRewardController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(EmployeeReward::class, 'reward');
    }
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
    public function store(Request $request, User $user)
    {
        $user->reward()->create([
            'reward_id' => $request->reward_id
        ]);

        return back()->with('success', 'Reward has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeReward $reward)
    {
        $reward->delete();

        return back()->with('success', 'Reward has been deleted.'); 
    }
}


