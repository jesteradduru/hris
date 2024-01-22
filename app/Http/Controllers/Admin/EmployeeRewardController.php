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
use Mockery\Undefined;

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
        $reward = RewardAndRecognition::find($request->reward_id);

        // dd($reward);

        $user->non_academic_distinction()->create([
            'reward_id' => $request->reward_id,
            'title' => $reward->title,
            'category' => $reward->category,
            'office' => 'NATIONAL ECONOMIC DEVELOPMENT AUTHORITY REGION 2',
            'date_awarded' => now()
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

        $filters = $request->only(['division', 'year', 'employee_type']);
        $year = $filters['year'] ?? Carbon::now()->format('Y');

        $division = Division::where('abbreviation', '!=', 'ORD')
        ->where('abbreviation', '!=', 'OARD')
        ->get();
// with(['spms' => fn($query) => $query->where('year', $year)])->
        $employees = User::filter($filters)->role(['employee'])->get();
        $employeesWithIPCR = collect();

        foreach($employees as $employee){
            $currentEmp =  $employee->load(['spms' => fn($query) => $query->where('year', $year), 'position' => ['division']]);
            $first = null;
            $second = null;

            $firstRating = $currentEmp->spms->filter(function ($item, $key) {
                return $item->semester === 'FIRST';
            });

            $secondRating = $currentEmp->spms->filter(function ($item, $key) {
                return $item->semester === 'SECOND';
            });

            if(count($firstRating) > 0){
                $first = $firstRating->first()->rating;
            }
            if(count($secondRating) > 0){
                $second = $secondRating->first()->rating;
            }

            $employeesWithIPCR->push([
                'first' => $first,
                'second' => $second,
                'first_link' => count($firstRating) > 0 ? $firstRating->first()->src : null,
                'second_link' =>count($secondRating) > 0 ? $secondRating->first()->src : null,
                'average' =>number_format((float) ($first + $second) / 2, 2, '.', ''),
                'name' => $employee->name,
                'user_id' => $employee->id,
                'division' => $currentEmp->position->division->abbreviation
            ]);
            
        }

        $employeesWithIPCR = $employeesWithIPCR->sortByDesc('average');

        $limitPerDiv = collect();

        if($filters['division'] == 'All'){
            foreach($division as $div){
                $filterPerDiv = $employeesWithIPCR->filter(function ($value, $key) use($div) {
                    // dd($div->abbreviation);
                    return $value['division'] === $div->abbreviation;
                });
                // if($div->abbreviation == 'DRD') dd($filterPerDiv);
                $chunks = $filterPerDiv->take(2);


                $limitPerDiv = $limitPerDiv->merge($chunks);
            }
        }

        $limitPerDiv = $limitPerDiv->sortByDesc('average');
        // dd($limitPerDiv->toArray());
        
        
        

        return inertia('Admin/RnR/EmployeeReward/RankByIpcr', [
            'reward' => $reward,
            'divisions' => $division,
            'years' => SpmsForm::select('year')->distinct()->orderBy('year', 'desc')->pluck('year'),
            'employees' => $filters['division'] == 'All' ? $limitPerDiv->values() : $employeesWithIPCR->values()
        ]);
    }
    
}


