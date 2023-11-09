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
            'View Reward Page',
            'Add Reward', 
            'Edit Reward', 
            'Delete Reward', 
            'View Reward',
            'Add SPMS', 
            'Edit SPMS', 
            'Delete SPMS', 
            'View SPMS',
            
            'View DTR',
            "Add Application",
            "Edit Application",
            "Delete Application",
            "View Application",

            'Manage Roles and Permissions', 
            'Manage Job Vacancies', 
            'Access Job Vacancies', 
            'Manage Employees',
            'Manage DTR',
            'Manage Rewards and Recognition',
            'Manage R&R of own account',
            'Add reward to an employee',
            'Add and delete reward of own account',

            'Add L&D Form',
            'Edit L&D Form',
            'Delete L&D Form',
            'View L&D Form',
            
        ];
        
        $roles = ['superadmin', 'admin', 'hr', 'user', 'employee'];

        foreach($roles as $role){
            Role::create(['name' => $role]);
        }

        $admin = User::create([
            'username' => 'nedaict',
            'middle_name' => 'ICT',
            'first_name' => 'RO2',
            'surname' => 'NEDA',
            'password' => Hash::make('lanxNEDA'),
        ]);

        $admin->assignRole('superadmin');

        $hruser = User::create([
            'username' => 'nedahr',
            'middle_name' => 'HR',
            'first_name' => 'RO2',
            'surname' => 'NEDA',
            'password' => Hash::make('lanxNEDA'),
        ]);

        $hruser->assignRole('hr');

        $employee1 = User::create([
            'username' => 'employee1',
            'middle_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'password' => Hash::make('12341234'),
        ]);

        $employee1->assignRole('employee');

        // employee
        $employee2 = User::create([
            'username' => 'employee2',
            'middle_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'password' => Hash::make('12341234'),
        ]);

        $employee2->assignRole('employee');

        // user
        $user2 = User::create([
            'username' => 'user1',
            'middle_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'password' => Hash::make('12341234'),
        ]);

        $user2->assignRole('user');

        $user3 = User::create([
            'username' => 'user2',
            'middle_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'password' => Hash::make('12341234'),
        ]);

        $user3->assignRole('user');

        event(new Registered($admin));

        Auth::login($admin);

        foreach($permissions as $permission){
            Permission::create(['name' => $permission]);

            $role = Role::findByName('superadmin');
            $role->givePermissionTo($permission);

            $hr = Role::findByName('hr');
            $hr->givePermissionTo($permission);
        }
?>