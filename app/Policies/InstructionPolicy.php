<?php

namespace App\Policies;

use App\Models\Instruction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InstructionPolicy
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
    public function view(User $user, Instruction $instruction): bool
    {
        return $user->id === $instruction->sender_id || $user->id === $instruction->receiver_id;
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
    public function update(User $user, Instruction $instruksi): bool
    {
        return $user->id === $instruksi->sender_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Instruction $instruksi): bool
    {
        return $user->id === $instruksi->sender_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Instruction $instruksi): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Instruction $instruksi): bool
    {
        return false;
    }

    public function forward(User $user, Instruction $instruction)
    {
        return $user->id === $instruction->sender_id || $user->id === $instruction->receiver_id;
    }
}
