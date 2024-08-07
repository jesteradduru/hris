<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RewardAndRecognition;
use Illuminate\Http\Request;

class AdminRewardAndRecognitionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(RewardAndRecognition::class, 'reward');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Admin/RnR/Index', [
            'rewards' => RewardAndRecognition::paginate(15)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/RnR/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string'
        ]);

        RewardAndRecognition::create($validate);

        sweetalert()->addSuccess('Reward and Recognition has been added.');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(RewardAndRecognition $reward)
    {

        // dd($reward->load('employee'));.
        $rewards = $reward->load(['non_academic' => ['user']]);
        // $employees = $rewards->non_academic->map(function($value, $key){
        //     return $value->user;
        // });
        
        return inertia('Admin/RnR/Show', [
            'reward' => $rewards
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RewardAndRecognition $reward)
    {
        return inertia('Admin/RnR/Edit', [
            'reward' => $reward
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RewardAndRecognition $reward)
    {
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            // 'points' => 'required|integer'
        ]);

        $reward->update($validate);

        sweetalert()->addSuccess('Reward and Recognition has been updated!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RewardAndRecognition $reward)
    {
        $reward->delete();

        sweetalert()->addSuccess('Reward and Recognition has been deleted!');

        return back(); 
    }
}
