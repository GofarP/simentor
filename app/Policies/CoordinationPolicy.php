<?php

namespace App\Policies;

use App\Models\Coordination;
use App\Models\User;

class CoordinationPolicy
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
    public function view(User $user, Coordination $instruction): bool
    {
        return $user->id === $instruction->sender_id
            || $user->id === $instruction->receiver_id
            || $instruction->forwards()->where('forwarded_to', $user->id)->exists();
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
    public function update(User $user, Coordination $instruction): bool
    {
        return $user->id === $instruction->sender_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Coordination $instruction): bool
    {
        return $user->id === $instruction->sender_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Coordination $instruksi): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Coordination $instruksi): bool
    {
        return false;
    }

    public function forward(User $user, Coordination $coordination)
    {
        return $user->id == $coordination->receiver_id && $user->hasRole('kasubag');
    }
}
