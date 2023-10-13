<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RewardAndRecognition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        return inertia('Admin/Employee/Index', [
            'employees' => User::role('employee')->paginate(10)->withQueryString()
        ]);
    }
    //
    public function create()
    {
        return inertia('Admin/Employee/Create', [
            'roles' => Role::all()->pluck('name')
        ]);
    }
    //
    public function store(Request $request)
    {
        Validator::extend('valid_username', function($attr, $value){
            return preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $value);
        });

        $request->validate([
            "surname" => "required|string|max:255",
            "first_name" =>"required|string|max:255",
            "middle_name" =>"required|string|max:255",
            "name_extension" =>"string|max:255|nullable",
            'username' => 'required|string|valid_username|max:255|unique:'.User::class,
            'dtr_user_id' => 'required|integer|unique:users,dtr_user_id',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|string|max:255'
        ], [
            'username.valid_username' => 'Invalid Username.'
        ]);

        $user = User::create([
            "surname" =>  $request->surname,
            "first_name" => $request->first_name,
            "middle_name" => $request->middle_name,
            "name_extension" => $request->name_extension,
            'username' => $request->username,
            'dtr_user_id' => $request->dtr_user_id,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return back()->with('success', "$request->username has been registered." );
    }

    public function edit(User $employee){
        return inertia('Admin/Employee/Edit/Profile', [
            'employee' => $employee,
        ]);
    }

    public function editRewards(User $employee) {
        return inertia('Admin/Employee/Edit/Rewards', [
            'employee' => $employee,
            'rewards' => $employee->reward->load(['reward'])
        ]);
    }

    public function addReward(User $employee){
        return inertia('Admin/Employee/Edit/Rewards/Add', [
            'employee' => $employee,
            'rewards' => RewardAndRecognition::paginate(15)->withQueryString()
        ]);
    }
}
