<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;


        $permissions = [
            'Apply Job',
            'Access Admin', 
            'View Roles and Permissions Page',
            'Add Role', 
            'Edit Role', 
            'Delete Role', 
            'View Role', 
            'Add Permission', 
            'Edit Permission', 
            'Delete Permission', 
            'View Permission', 
            'View Recruitment, Selection and Placement Page',
            'Add Job Vacancy', 
            'Edit Job Vacancy', 
            'Delete Job Vacancy', 
            'View Job Vacancy', 
            'Add Reward', 
            'Edit Reward', 
            'Delete Reward', 
            'View Reward', 
            'Manage Roles and Permissions', 
            'Manage Job Vacancies', 
            'Access Job Vacancies', 
            'Access DTR',
            'Manage Employees',
            'Manage DTR',
            'Manage Rewards and Recognition',
            'Manage R&R of own account',
            'Add reward to an employee',
            'Add and delete reward of own account'
        ];
        
        $roles = ['superadmin', 'admin', 'hr', 'user', 'employee'];

        foreach($roles as $role){
            Role::create(['name' => $role]);
        }

        $user = User::create([
            'name' => 'superadmin',
            'username' => 'nedaict',
            'password' => Hash::make('lanxNEDA'),
        ]);

        $hruser = User::create([
            'name' => 'human resource',
            'username' => 'nedahr',
            'password' => Hash::make('lanxNEDA'),
        ]);

        $user->assignRole('superadmin');
        $hruser->assignRole('hr');

        event(new Registered($user));

        Auth::login($user);



        foreach($permissions as $permission){
            Permission::create(['name' => $permission]);

            $role = Role::findByName('superadmin');
            $role->givePermissionTo($permission);

            $hr = Role::findByName('hr');
            $hr->givePermissionTo($permission);
        }
?>