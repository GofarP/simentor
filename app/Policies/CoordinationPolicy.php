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
    public function view(User $user, Coordination $coordination): bool
    {
        // Cek apakah user sebagai sender atau receiver di coordination_user
        $isUserInCoordination = $coordination->coordinationUsers()
            ->where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->exists();

        // Cek apakah user sebagai penerima forwarded
        $isUserForwarded = $coordination->forwards()
            ->where('forwarded_to', $user->id)
            ->exists();

        return $isUserInCoordination || $isUserForwarded;
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
    public function update(User $user, Coordination $coordination): bool
    {
        return $coordination->coordinationUsers()
            ->where('sender_id', $user->id)
            ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Coordination $coordination): bool
    {
        return $coordination->coordinationUsers()
            ->where('sender_id', $user->id)
            ->exists();
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

    public function forward(User $user, Coordination $coordination): bool
    {
        $isReceiver = $coordination->coordinationUsers()
            ->where('receiver_id', $user->id)
            ->exists();

        return $isReceiver && $user->hasRole('kasubbag');
    }
}
