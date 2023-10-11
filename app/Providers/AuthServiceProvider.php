<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\EmployeeReward;
use App\Models\JobPosting;
use App\Models\RewardAndRecognition;
use App\Models\SpmsForm;
use App\Policies\EmployeeRewardPolicy;
use App\Policies\JobPostingPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RewardAndRecognitionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SpmsFormPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        JobPosting::class => JobPostingPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        RewardAndRecognition::class => RewardAndRecognitionPolicy::class,
        EmployeeReward::class => EmployeeRewardPolicy::class,
        SpmsForm::class => SpmsFormPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });
    }
}
