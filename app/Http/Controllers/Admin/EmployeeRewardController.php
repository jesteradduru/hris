<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\EmployeeReward;
use App\Models\RewardAndRecognition;
use App\Models\SpmsForm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function create(Request $request, RewardAndRecognition $reward)
    {
        $filters = $request->only(['name', 'division', 'year', 'grouped']);
        $year = $filters['year'] ?? Carbon::now()->format('Y');

        $employeeWithIpcr = User::role('employee')->with(
            [
                'spms'=> fn($query) => $query->where('year','like' , '%' . $year  . '%')->get()
            ])->filter($filters)->paginate(15)->withQueryString();


        // $division = Division::with('employees')
        // ->where('abbreviation', '!=', 'ORD')
        // ->where('abbreviation', '!=', 'OARD')
        // ->get();



        // dd($employeeWithIpcr);
        return inertia('Admin/RnR/EmployeeReward/Create', [
            'reward' => $reward,
            'divisions' => Division::all(),
            'employees' => User::role('employee')->filter($filters)->paginate(15)->withQueryString()
        ]);
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

    public function rank_by_ipcr(Request $request, RewardAndRecognition $reward) {

        $filters = $request->only(['name', 'division', 'year', 'grouped']);

        $year = 2022 ?? Carbon::now()->format('Y');

        $division = Division::with(['employees' => [
            'spms'=> fn($query) => $query->where('year','like' , '%' . $year  . '%')->get()
        ]])
        ->where('abbreviation', '!=', 'ORD')
        ->where('abbreviation', '!=', 'OARD')
        ->get();
        

        $SPMS = DB::table('spms_forms')->select([
            'plantilla_positions.division_id',
        ])
        ->join('users', 'spms_forms.user_id', '=', 'users.id')
        ->join('plantilla_positions', 'plantilla_positions.id', '=', 'users.plantilla_id')
        ->where('spms_forms.year', 2022)
        ->get();

        dd($SPMS);

        return inertia('Admin/RnR/EmployeeReward/RankByIpcr', [
            'reward' => $reward,
            'divisions' => $division,
            'years' => SpmsForm::select('year')->distinct()->pluck('year')
        ]);
    }
    
}


