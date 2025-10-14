<?php

namespace App\Policies;

use App\Models\FollowupCoordination;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FollowupCoordinationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FollowupCoordination $followupCoordination): bool
    {
        return $user->id === $followupCoordination->sender_id ||
            $user->id === $followupCoordination->receiver_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FollowupCoordination $followupCoordination): bool
    {
        return $user->id === $followupCoordination->sender_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FollowupCoordination $followupCoordination): bool
    {
        return $user->id === $followupCoordination->sender_id;;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FollowupCoordination $followupCoordination): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FollowupCoordination $followupCoordination): bool
    {
        return false;
    }

    public function forward(User $user, FollowupCoordination $followupCoordination)
    {
        return  $user->id === $followupCoordination->receiver_id || $user->hasRole('Kasubbag');
    }
}
