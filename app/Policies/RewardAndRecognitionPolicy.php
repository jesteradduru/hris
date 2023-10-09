<?php

namespace App\Policies;

use App\Models\RewardAndRecognition;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RewardAndRecognitionPolicy
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
    public function view(User $user, RewardAndRecognition $rewardAndRecognition): bool
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
    public function update(User $user, RewardAndRecognition $rewardAndRecognition): bool
    {
        return $user->hasPermissionTo('Edit Reward');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RewardAndRecognition $rewardAndRecognition): bool
    {
        return $user->hasPermissionTo('Delete Reward');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RewardAndRecognition $rewardAndRecognition): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RewardAndRecognition $rewardAndRecognition): bool
    {
        return true;
    }
}
