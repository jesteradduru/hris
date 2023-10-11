<?php

namespace App\Policies;

use App\Models\EmployeeReward;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmployeeRewardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Reward');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EmployeeReward $employeeReward): bool
    {
        return $user->hasPermissionTo('View Reward');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Add Reward');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmployeeReward $employeeReward): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EmployeeReward $employeeReward): bool
    {
        return $user->hasPermissionTo('Delete Reward');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EmployeeReward $employeeReward): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EmployeeReward $employeeReward): bool
    {
        //
    }
}
