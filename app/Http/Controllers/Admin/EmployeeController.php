<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\PlantillaPosition;
use App\Models\RewardAndRecognition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    //
    public function index(Request $request)
    {
        $filters = $request->only(['name', 'division']);

        return inertia('Admin/Employee/Index', [
            'employees' => User::with('position')->filter($filters)->role('employee')->paginate(10)->withQueryString(),
            'divisions' => Division::all()
        ]);
    }
    //
    public function create()
    {
        return inertia('Admin/Employee/Create', [
            'roles' => Role::all()->pluck('name'),
            'positions' => PlantillaPosition::doesntHave('user')->with(['division'])->get()
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
            'role' => 'required|string|max:255',
            'plantilla_id' => 'required|integer|unique:users,plantilla_id'
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
            'plantilla_id' => $request->plantilla_id
        ]);

        $user->assignRole($request->role);

        return back()->with('success', "$request->username has been registered." );
    }

    public function edit(User $employee){
        return inertia('Admin/Employee/Edit/Profile', [
            'employee' => $employee->load(['position']),
            'roles' => Role::all()->pluck('name'),
            'positions' => PlantillaPosition::doesntHave('user')->with(['division'])->get()
        ]);
    }

    public function update(Request $request, User $employee) {
        Validator::extend('valid_username', function($attr, $value){
            return preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $value);
        });

        // Validator::extend('unique_plantilla', function($attr, $value){
        //     return Rule::unique('users')->ignore($employee->id);
        // });


        $request->validate([
            "surname" => "required|string|max:255",
            "first_name" =>"required|string|max:255",
            "middle_name" =>"required|string|max:255",
            "name_extension" =>"string|max:255|nullable",
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($employee->id)],
            'dtr_user_id' => ['required', 'integer', Rule::unique('users')->ignore($employee->id)],
            'password' => [Password::defaults(), 'nullable'],
            'plantilla_id' => ['required', 'integer', Rule::unique('users')->ignore($employee->id)],
            'role' => 'required|string|max:255',
        ], [ 
            'username.valid_username' => 'Invalid Username.'
        ]);
        
        if($request->password){
            $employee->update([
                "surname" =>  $request->surname,
                "first_name" => $request->first_name,
                "middle_name" => $request->middle_name,
                "name_extension" => $request->name_extension,
                'username' => $request->username,
                'dtr_user_id' => $request->dtr_user_id,
                'password' => Hash::make($request->password),
                'plantilla_id' => $request->plantilla_id
            ]);
        }else{
            $employee->update([
                "surname" =>  $request->surname,
                "first_name" => $request->first_name,
                "middle_name" => $request->middle_name,
                "name_extension" => $request->name_extension,
                'username' => $request->username,
                'dtr_user_id' => $request->dtr_user_id,
                'plantilla_id' => $request->plantilla_id
            ]);
        }


        $employee->assignRole($request->role);

        return back()->with('success', "$request->username account has been updated." );
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
