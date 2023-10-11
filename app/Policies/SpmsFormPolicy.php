<?php

namespace App\Policies;

use App\Models\SpmsForm;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SpmsFormPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View SPMS');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SpmsForm $spmsForm): bool
    {
        return $user->hasPermissionTo('View SPMS');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Add SPMS');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('Edit SPMS');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('Delete SPMS');
    }

    /**
     * Determine whether the user can restore the model.
     */
}
