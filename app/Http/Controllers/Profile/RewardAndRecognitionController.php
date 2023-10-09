<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\EmployeeReward;
use App\Models\RewardAndRecognition;
use Illuminate\Http\Request;

class RewardAndRecognitionController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(RewardAndRecognition::class, 'rewards');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia('Profile/RewardsAndRecognition/Index', [
            'rewards' => $request->user()->reward->load(['reward'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return inertia('Profile/RewardsAndRecognition/Create', [
            'employee' => $request->user(),
            'rewards' => RewardAndRecognition::paginate(15)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->user()->reward()->create([
            'reward_id' => $request->query('reward')
        ]);

        return back()->with('success', 'Reward has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeReward $employeeReward)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeReward $employeeReward)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeReward $employeeReward)
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
